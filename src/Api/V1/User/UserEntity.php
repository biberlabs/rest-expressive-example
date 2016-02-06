<?php
/**
 * Abstract Resource
 *
 * @since     Dec 2015
 * @author    Haydar KULEKCI  <haydarkulekci@gmail.com>
 */
namespace Api\V1\User;

use Mocker\Annotations\Property as PropertyMock;

/**
 * @SWG\Definition(definition="User")
 */
class UserEntity
{
    /**
     * Name of user
     *
     * @var string
     * @PropertyMock(name="name", type="First Name");
     * @SWG\Property()
     */
    protected $name;

    /**
     * Surname of user
     *
     * @var string
     * @SWG\Property()
     */
    protected $surname;
}