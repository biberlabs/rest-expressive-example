<?php
/**
 * Abstract Resource
 *
 * @since     Dec 2015
 * @author    Haydar KULEKCI  <haydarkulekci@gmail.com>
 */
namespace Api\V1;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use ZF\ApiProblem\ApiProblem;

/**
 * @SWG\Info(title="Example API Interface", 
 *      description="API Description",
 *      version="0.1")
 */
class AbstractResource
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $method      = $request->getMethod();
        $attributes  = $request->getAttributes();
        $params      = $request->getQueryParams();
        $data        = $this->getRequestData($request);
        if ($data instanceof ApiProblem) {
            return $this->prepareResponse($data);
        }

        if ($method === 'GET') {
            $result = null;
            if (isset($attributes['id'])) {
                $result = $this->fetch($attributes['id']);
            } else {
                $result = $this->fetchAll($params);
            }

            return $this->prepareResponse($result);
        } elseif ($method === 'POST') {
            return $this->prepareResponse($this->create($data));
        } elseif ($method === 'PUT') {
            if (isset($attributes['id'])) {
                return $this->prepareResponse($this->update($attributes['id'], $data));
            }
        } elseif ($method === 'PATCH') {
            if (isset($attributes['id'])) {
                return $this->prepareResponse($this->patch($attributes['id'], $data));
            }
        } elseif ($method === 'DELETE') {
            if (isset($attributes['id'])) {
                return $this->prepareResponse($this->delete($attributes['id']));
            }
        } else {
            return $this->prepareResponse((new ApiProblem(405, 'Method not allowed!'))->toArray());
        }
        
        return $this->prepareResponse((new ApiProblem(400, 'Bad Request'))->toArray());
    }

    public function prepareResponse($result)
    {
        if ($result instanceof ApiProblem) {
            $response = new JsonResponse($result->toArray());

            return $response->withStatus($result->status);
        } elseif ($result instanceof JsonResponse) {
            return $result;
        } elseif ($result instanceof \Zend\Paginator\Paginator) {
            return new JsonResponse((array)$result->getCurrentItems());
        } elseif (is_object($result) && method_exists($result, 'toArray')) {
            return new JsonResponse($result->toArray());
        } elseif ($result instanceof \Traversable) {
            return new JsonResponse((array)$result);
        } elseif (is_array($result)) {
            return new JsonResponse($result);
        }

        return $this->prepareResponse(new ApiProblem(502));
    }

    public function create($data = [])
    {
        return new ApiProblem(405, 'Method not implemented!');
    }

    public function fetch($id)
    {
        return new ApiProblem(405, 'Method not implemented!');
    }

    public function fetchAll($data = [])
    {
        return new ApiProblem(405, 'Method not implemented!');
    }

    public function patch($id, $data = [])
    {
        return new ApiProblem(405, 'Method not implemented!');
    }

    public function update($id, $data = [])
    {
        return new ApiProblem(405, 'Method not implemented!');
    }

    public function delete($id)
    {
        return new ApiProblem(405, 'Method not implemented!');
    }

    public function getRequestData($request)
    {
        $body = $request->getParsedBody();

        if (!empty($body)) {
            return $body;
        }

        return $this->parseRequestData(
            $request->getBody()->getContents(),
            $request->getHeaderLine('content-type')
        );
    }

    public function parseRequestData($input, $contentType)
    {
        $contentTypeParts = preg_split('/\s*[;,]\s*/', $contentType);
        $parser           = $this->returnParserContentType($contentTypeParts[0]);

        return $parser($input);
    }

    public function returnParserContentType($contentType)
    {
        if ($contentType === 'application/x-www-form-urlencoded') {
            return function ($input) {
                parse_str($input, $data);

                return $data;
            };
        } elseif ($contentType === 'application/json') {
            return function ($input) {
                $jsonDecoder = new \Zend\Json\Json();
                try {
                    return $jsonDecoder->decode($input, \Zend\Json\Json::TYPE_ARRAY);
                } catch (\Exception $e) {
                    return new ApiProblem(400, 'Data Parsing Error.');
                }
            };
        } elseif ($contentType === 'multipart/form-data') {
            return function ($input) {
                return $input;
            };
        }

        return function ($input) {
            return $input;
        };
    }
}
