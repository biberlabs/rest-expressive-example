<?php
/**
 * Mockaroo Adapter
 *
 * @since     Feb 2016
 * @author    Haydar KULEKCI  <haydarkulekci@gmail.com>
 */
namespace Mocker\Adapter;

use GuzzleHttp\Client;

class Mockaroo implements AdapterInterface
{
    /**
     * @var string
     */
    protected $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function getMockData($context, $count = 1)
    {
        $client = new Client([
            'base_uri' => 'http://www.mockaroo.com/',
        ]);
        $response = $client->request('GET', 'api/generate.json',
            [
                'query' => [
                    'key'    => $this->key,
                    'fields' => json_encode($this->createMockarooFieldsFromContext($context)),
                    'count'  => $count,
                ]
            ]
        );

        return json_decode((string) $response->getBody(), true);
    }

    protected function createMockarooFieldsFromContext($context)
    {
        $fields = [];
        foreach ($context->getProperties() as $property) {
            $fields[] = [
                'name' => $property->name,
                'type' => $property->type,
            ];
        }

        return $fields;
    }
}