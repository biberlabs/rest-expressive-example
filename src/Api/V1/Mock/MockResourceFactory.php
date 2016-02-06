<?php
/**
 * Mock Resource Middleware Factory
 *
 * @since     Feb 2016
 * @author    Haydar KULEKCI  <haydarkulekci@gmail.com>
 */
namespace Api\V1\Mock;

use Interop\Container\ContainerInterface;

class MockResourceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new MockResource();
    }
}
