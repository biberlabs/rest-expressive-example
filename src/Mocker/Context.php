<?php
/**
 * Context file
 *
 * @since     Feb 2016
 * @author    Haydar KULEKCI  <haydarkulekci@gmail.com>
 */
namespace Mocker;

use Mocker\Annotations\Entity;
use Mocker\Annotations\Property;

class Context
{
    protected $file;
    protected $entity;
    protected $properties = [];

    public function getEntity()
    {
        return $this->entity;
    }

    public function setEntity(Entity $entity)
    {
        $this->entity = $entity;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;
    }


    public function getProperties()
    {
        return $this->properties;
    }

    public function addProperty(Property $property)
    {
        $this->properties[] = $property;
    }
}