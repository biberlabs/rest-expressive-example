<?php
/**
 * Entity Annotation
 *
 * @since     Jan 2016
 * @author    Haydar KULEKCI  <haydarkulekci@gmail.com>
 */

namespace Mocker\Annotations;

/**
 * @Annotation
 */
class Entity extends \Doctrine\Common\Annotations\Annotation
{
    /**
     * @var string
     */
    public $uri;

    /**
     * @var array
     */
    public $properties;
}
