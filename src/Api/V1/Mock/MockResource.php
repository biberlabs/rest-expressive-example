<?php
/**
 * Mock Resource
 *
 * @since     Feb 2016
 * @author    Haydar KULEKCI  <haydarkulekci@gmail.com>
 */
namespace Api\V1\Mock;

use Api\V1\AbstractResource;
use Zend\Diactoros\Response\JsonResponse;
use ZF\ApiProblem\ApiProblem;
use Swagger\Annotations\Swagger;
use Swagger\Util;
use Symfony\Component\Finder\Finder;

class MockResource extends AbstractResource
{
    public function fetch($id)
    {
        $analyser = new \Swagger\StaticAnalyser();
        $analysis = new \Swagger\Analysis();
        $processors = \Swagger\Analysis::processors();

        \Swagger\Analyser::$whitelist[] = 'Mocker\Annotations\\';

        // Crawl directory and parse all files
        $finder = Util::finder('src/', []);
        foreach ($finder as $file) {
            $analysis->addAnalysis($analyser->fromFile($file->getPathname()));
        }
        $analysis->process($processors);
        //$analysis->validate();
        $analysedData = $analysis->swagger;

        $mockarooData = [];
        $mockarooData['count'] = 10;

        var_dump($analysedData->definitions);
        var_dump($analysedData->_unmerged); exit;

        foreach ($analysedData->_unmerged as $definition) {
            //echo $definition->definition . "\n";
            /*foreach ($definition->properties as $property) {
                $mockarooData[] = [
                    'name' => $property->property,
                    $property->type
                ];
                var_dump($property);
            }*/
        }
    }
}