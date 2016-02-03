<?php
/**
 * Abstract Index Service
 *
 * @since     Oct 2015
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace Search\Index\Service;

use Elastica\Document;
use Search\Exception\IndexingException;
use Search\Exception\MissingDataException;
use Search\Service\AbstractSearchService;

class AbstractIndexService extends AbstractSearchService
{
    /**
     * Indexing Data
     *
     * @param  array    $data
     * @param  integer  $version
     *
     * @throws IndexingException
     *
     * @return null
     */
    public function index(array $data, $version = 1)
    {
        if (!array_key_exists('id', $data)) {
            throw new MissingDataException('`id` field is requeired to index data', 400);
            $data['id'] = '';
        }

        $this->createIndex('user_test');
        $this->updateMapping('user_test', 'user');

        //TODO: this creation will be moved to a builder
        $document = new Document($data['id'], $data);
        try {
            $this->getType($version)->addDocument($document);
        } catch (\Exception $e) {
            throw new IndexingException('Throw exception while indexing', $e->getCode(), $e);
        }
    }

    /**
     * Partial Update
     *
     * @param  string  $docId
     * @param  array    $data
     * @param  integer  $version
     *
     * @throws IndexingException
     *
     * @return null
     */
    public function update($docId, array $data, $version = 1)
    {
        $document = new Document();
        $document->setData($data);
        $document->setId($docId);
        $document->setDocAsUpsert(true);
        try {
            $this->getType($version)->updateDocument($document);
        } catch (\Exception $e) {
            throw new IndexingException('Throw exception while updating', $e->getCode(), $e);
        }
    }

    /**
     * Deleting Document by DocId
     *
     * @param  string  $docId
     * @param  integer  $version
     *
     * @throws IndexingException
     *
     * @return null
     */
    public function delete($docId, $version = 1)
    {
        try {
            $this->getType($version)->delete($docId);
        } catch (\Exception $e) {
            throw new IndexingException('Throw exception while updating', $e->getCode(), $e);
        }
    }

    protected function updateMapping($indexName, $typeName, $mapping = [])
    {
        $elasticaType = $this->getClient()
                             ->getIndex($indexName)
                             ->getType($typeName);

        // Define mapping
        $mapping = new \Elastica\Type\Mapping();
        $mapping->setType($elasticaType);
        $mapping->setParam('index_analyzer', 'indexAnalyzer');
        $mapping->setParam('search_analyzer', 'searchAnalyzer');

        // Define boost field
        $mapping->setParam('_boost', array('name' => '_boost', 'null_value' => 1.0));

        // Set mapping
        $mapping->setProperties(array(
            'id'      => array('type' => 'integer', 'include_in_all' => false),
            'user'    => array(
                'type'       => 'object',
                'properties' => array(
                    'name'      => array('type' => 'string', 'include_in_all' => true),
                    'fullName'  => array('type' => 'string', 'include_in_all' => true)
                ),
            ),
            'msg'     => array('type' => 'string', 'include_in_all' => true),
            'tstamp'  => array('type' => 'date', 'include_in_all' => false),
            'location'=> array('type' => 'geo_point', 'include_in_all' => false),
            '_boost'  => array('type' => 'float', 'include_in_all' => false)
        ));

        // Send mapping to type
        $mapping->send();
    }


    protected function createIndex($indexName, $settings = [])
    {
        $elasticaIndex = $this->getClient()->getIndex($indexName);
        $elasticaIndex->create($this->getDefaultIndexSettings());
    }

    protected function getIndexSettings($setting = [])
    {
        return array_merge_recursive($setting, $this->getDefaultIndexSettings());
    }

    protected function getDefaultIndexSettings()
    {
        return [
            'number_of_shards'   => 5,
            'number_of_replicas' => 1,
            'analysis'           => [
                'analyzer' => [
                    'indexAnalyzer' => [
                        'type'      => 'custom',
                        'tokenizer' => 'standard',
                        'filter'    => ['lowercase', 'mySnowball'],
                    ],
                    'searchAnalyzer' => [
                        'type'      => 'custom',
                        'tokenizer' => 'standard',
                        'filter'    => ['standard', 'lowercase', 'mySnowball'],
                    ],
                ],
                'filter' => [
                    'mySnowball' => [
                        'type'     => 'snowball',
                        'language' => 'turkish'
                    ],
                ],
            ],
        ];
    }
}
