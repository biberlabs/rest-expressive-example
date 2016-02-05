<?php
/**
 * Address Resource Middleware Factory
 *
 * @since     Dec 2015
 * @author    Haydar KULEKCI  <haydarkulekci@gmail.com>
 */
namespace Api\V1\Address;

use Interop\Container\ContainerInterface;

class AddressResourceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AddressResource();
    }
}
