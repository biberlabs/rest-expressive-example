<?php
/**
 * Abstract Resource
 *
 * @since     Jan 2016
 * @author    Haydar KULEKCI  <haydarkulekci@gmail.com>
 */

namespace Mocker\Annotations;

/**
 * @Annotation
 */
class Property extends \Swagger\Annotations\AbstractAnnotation
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
     * @var string
     */
    public $type;

    /**
     * An integer between 0 and 100 that determines what percent of the 
     * generated values will be null
     * @var integer
     */
    public $percentBlank;

    /** @inheritdoc */
    public static $_required = ['name', 'type'];

    /** @inheritdoc */
    public static $_types = [
        'name' => 'string',
        'type' => 'string',
        'percentBlank' => 'string'
    ];

    /** @inheritdoc */
    public static $_parents = [
        'Swagger\Annotations\Definition',
        'Swagger\Annotations\Schema',
        'Swagger\Annotations\Property',
    ];

    public function __construct($properties) {
        parent::__construct($properties);
    }
}
