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
        return new UserResource(
            $container->get('search.query.user'),
            $container->get('search.index.user')
        );
    }
}
