<?php
/**
 * Abstract Resource
 *
 * @since     Dec 2015
 * @author    Haydar KULEKCI  <haydarkulekci@gmail.com>
 */
namespace Api\V1\Address;

use Api\V1\AbstractResource;
use Zend\Diactoros\Response\JsonResponse;
use ZF\ApiProblem\ApiProblem;


class AddressResource extends AbstractResource
{

    public function __construct()
    {
    }

    /**
     * @SWG\Get(
     *     path="/address/{id}",
     *     @SWG\Response(response="200", description="Address fetching endpoint"),
     *     @SWG\Response(response="500", description="Some errors"),
     *     @SWG\Parameter(required=true, name="id", in="path", type="integer")
     * )
     */
    public function fetch($id)
    {
        return ['id' => 5];
    }

    /**
     * @SWG\Get(
     *     path="/address",
     *     @SWG\Response(response="200", description="Addresss fetching endpoint"),
     *     @SWG\Response(response="500", description="Some errors"),
     *     @SWG\Parameter(name="keyword", in="query", type="string"),
     *     @SWG\Parameter(name="type", in="query", type="integer")
     * )
     */
    public function fetchAll($params = [])
    {
        return [
            ['id' => 2],
            ['id' => 3]
        ];
    }
}
