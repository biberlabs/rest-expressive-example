<?php
/**
 * Mock Resource
 *
 * @since     Feb 2016
 * @author    Haydar KULEKCI  <haydarkulekci@gmail.com>
 */
namespace Api\V1\Mock;

use Api\V1\AbstractResource;
use Zend\Diactoros\Response\JsonResponse;
use ZF\ApiProblem\ApiProblem;
use Swagger\Annotations\Swagger;
use Swagger\Util;
use Symfony\Component\Finder\Finder;
use Exception;


class MockResource extends AbstractResource
{
    protected $entities = [
        'user' => ['namespace' => 'src/Api/V1/User'],
        'address' => ['namespace' => 'src/Api/V1/Address'],
    ];

    public function fetch($id)
    {
        $entity = null;
        if (!isset($this->entities[$id])) {
            return new ApiProblem(404, 'Entity not found');
        }

        $entity = $this->entities[$id];
        $mocker = new \Mocker\Mocker(new \Mocker\Adapter\Mockaroo('c0964650'));
        try {
            $mocker->scan($entity['namespace']);
        } catch (\Mocker\Exception\MoreThanOneException $e){
            return new ApiProblem(400, $e->getMessage());
        } catch (\Mocker\Exception\MissingContextData $e){
            return new ApiProblem(400, $e->getMessage());
        } catch (\InvalidArgumentException $e) {
            return new ApiProblem(400, 'Invalid Argument');
        } catch (\Exception $e){
            return new ApiProblem(500, 'Interval Error');
        }
        var_dump($mocker->mockOne());
        var_dump($mocker->mockMore(10));
        exit;
    }
}