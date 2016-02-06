<?php
/**
 * Abstract Resource
 *
 * @since     Dec 2015
 * @author    Haydar KULEKCI  <haydarkulekci@gmail.com>
 */
namespace Api\V1\User;

/**
 * @Mocker\Annotations\Entity(uri="/user");
 * @SWG\Definition(definition="User")
 */
class UserEntity
{
    /**
     * Name of user
     *
     * @var string
     * @Mocker\Annotations\Property(type="First Name");
     * @SWG\Property()
     */
    protected $name;

    /**
     * Surname of user
     *
     * @var string
     * @Mocker\Annotations\Property(type="Last Name");
     * @SWG\Property()
     */
    protected $surname;
}