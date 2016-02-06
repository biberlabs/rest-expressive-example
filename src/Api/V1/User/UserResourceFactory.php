<?php
/**
 * User Resource Middleware Factory
 *
 * @since     Dec 2015
 * @author    Haydar KULEKCI  <haydarkulekci@gmail.com>
 */
namespace Api\V1\User;

use Interop\Container\ContainerInterface;

class UserResourceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');
        $mocker = new \Mocker\Mocker(new \Mocker\Adapter\Mockaroo($config['mocker']['key']));
        return new UserResource($mocker);
    }
}
