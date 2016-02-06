<?php
/**
 * Property Annotation
 *
 * @since     Jan 2016
 * @author    Haydar KULEKCI  <haydarkulekci@gmail.com>
 */

namespace Mocker\Annotations;

/**
 * @Annotation
 */
class Property extends \Doctrine\Common\Annotations\Annotation
{
    /**
     * The name of the field. When using json format, you can use "." in 
     * field names to generate nested json objects, brackets to generate arrays. 
     * @var string
     */
    public $name;

    /**
     * A short description of the application. GFM syntax can be used for 
     * rich text representation.
     * Check https://www.mockaroo.com/api/docs for meaning of types
     *
     * @var string
     */
    public $type;

    /**
     * An integer between 0 and 100 that determines what percent of the 
     * generated values will be null
     * @var integer
     */
    public $percentBlank;
}
