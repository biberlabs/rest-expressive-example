<?php
/**
 * Api Middleware Factory
 *
 * @since     Dec 2015
 * @author    Haydar KULEKCI  <haydarkulekci@gmail.com>
 */
namespace Api\Helper;

use Interop\Container\ContainerInterface;

class ApiMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config       = $container->get('Config');
        $routesConfig = $config['routes'];

        return new ApiMiddleware($routesConfig);
    }
}
