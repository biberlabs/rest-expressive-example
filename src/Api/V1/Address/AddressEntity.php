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
 * @Mocker\Annotations\Entity(uri="/address");
 */
class AddressEntity
{
    /**
     * Address
     *
     * @var string
     * @Mocker\Annotations\Property(type="Street Address");
     * @SWG\Property()
     */
    protected $address;

    /**
     * City of address
     *
     * @var string
     * @Mocker\Annotations\Property(type="City");
     * @SWG\Property()
     */
    protected $city;

    /**
     * Country of address
     *
     * @var string
     * @Mocker\Annotations\Property(type="Country");
     * @SWG\Property()
     */
    protected $country;

    /**
     * Postal Code of address
     *
     * @var string
     * @Mocker\Annotations\Property(type="Postal Code");
     * @SWG\Property()
     */
    protected $postalCode;
}