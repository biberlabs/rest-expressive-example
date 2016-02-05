<?php
/**
 * Abstract Resource
 *
 * @since     Dec 2015
 * @author    Haydar KULEKCI  <haydarkulekci@gmail.com>
 */
namespace Api\V1\User;

/**
 * @SWG\Definition(definition="User")
 */
class UserEntity
{
    /**
     * Name of user
     *
     * @var string
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