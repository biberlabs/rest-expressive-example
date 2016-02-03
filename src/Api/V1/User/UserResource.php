<?php
/**
 * Abstract Resource
 *
 * @since     Dec 2015
 * @author    Haydar KULEKCI  <haydarkulekci@gmail.com>
 */
namespace Api\V1\User;

use Api\V1\AbstractResource;
use Zend\Diactoros\Response\JsonResponse;
use ZF\ApiProblem\ApiProblem;

class UserResource extends AbstractResource
{
    protected $userQueryService = null;
    protected $userIndexService = null;

    public function __construct($userQueryService, $userIndexService)
    {
        $this->userQueryService = $userQueryService;
        $this->userIndexService = $userIndexService;
    }

    public function fetch($id)
    {
        try {
            $data = $this->userQueryService->getById($id);

            return $data;
        } catch (\Exception $e) {
            return new ApiProblem($e->getCode(), $e->getMessage());
        }
    }

    public function fetchAll($params = [])
    {
        try {
            $data = $this->userQueryService->search([]);

            return $data;
        } catch (\Exception $e) {
            return new ApiProblem($e->getCode(), $e->getMessage());
        }
    }

    public function create($data = [])
    {
        try {
            $this->userIndexService->index($data);

            return (new JsonResponse())->withStatus(201);
        } catch (\Exception $e) {
            return new ApiProblem($e->getCode(), $e->getMessage());
        }
    }
}
