<?php
/**
 * Abstract Resource
 *
 * @since     Dec 2015
 * @author    Haydar KULEKCI  <haydarkulekci@gmail.com>
 */
namespace Api\V1\Address;

/**
 * @SWG\Definition(definition="Address")
 */
class AddressEntity
{
    /**
     * Name of address
     *
     * @var string
     * @SWG\Property()
     */
    protected $title;

    /**
     * Surname of address
     *
     * @var string
     * @SWG\Property()
     */
    protected $address;
}