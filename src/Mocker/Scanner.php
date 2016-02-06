<?php
/**
 * Scanner Class
 *
 * @since     Feb 2016
 * @author    Haydar KULEKCI  <haydarkulekci@gmail.com>
 */
namespace Mocker;

use Swagger\Util;
use Symfony\Component\Finder\Finder;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\DocParser;
use Doctrine\Common\Annotations\SimpleAnnotationReader;
use Mocker\Annotations\Entity;
use Mocker\Annotations\Property;

class Scanner
{

    public function __construct()
    {
        // Load all whitelisted annotations
        AnnotationRegistry::registerLoader(function ($class) {
            foreach (['Mocker\Annotations'] as $namespace) {
                if (strtolower(substr($class, 0, strlen($namespace))) === strtolower($namespace)) {
                    $loaded = class_exists($class);
                    return $loaded;
                }
            }
            return false;
        });

    }

    public function scan($dir, $exclude = [])
    {
        $contexts = [];

        // Crawl directory and parse all files
        $finder = Util::finder($dir, $exclude);
        foreach ($finder as $file) {

            $tokens = $this->getFileTokens($file->getPathname());
            $class = $this->getNamespaceFromToken($tokens);

            $reader = new SimpleAnnotationReader();
            $reflClass = new \ReflectionClass($class);
            $entityAnnotation = $reader->getClassAnnotation($reflClass, Entity::class);
            if (!$entityAnnotation) {
                continue;
            }
            $context = new Context();
            $context->setFile($file->getPathname());
            $context->setEntity($entityAnnotation);
            
            $propertyAnnotations = [];
            foreach ($reflClass->getProperties() as $property) {
                $annotation = $reader->getPropertyAnnotation($property, Property::class);
                if ($annotation && !$annotation->name) {
                    $annotation->name = $property->getName();
                    $context->addProperty($annotation);
                }
            }
            $contexts[] = $context;
        }

        return $contexts;
    }

    public function getNamespaceFromToken($tokens, $namespace = '') {
        for ($i=0;$i<count($tokens);$i++) {
            if ($tokens[$i][0] === T_NAMESPACE) {
                for ($j=$i+1;$j<count($tokens); $j++) {
                    if ($tokens[$j][0] === T_STRING) {
                         $namespace .= '\\'.$tokens[$j][1];
                    } else if ($tokens[$j] === '{' || $tokens[$j] === ';') {
                         break;
                    }
                }
            }

            if ($tokens[$i][0] === T_CLASS) {
                for ($j=$i+1;$j<count($tokens);$j++) {
                    if ($tokens[$j] === '{') {
                        $class = $tokens[$i+2][1];
                    }
                }
            }
        }

        return $namespace . '\\' . $class;
    }

    public function getFileTokens($filename)
    {
        return token_get_all(file_get_contents($filename));
    }

    public function parseFileToken($token, $context = '')
    {
        return $this->docParser->parse($token, $context);
    }
}