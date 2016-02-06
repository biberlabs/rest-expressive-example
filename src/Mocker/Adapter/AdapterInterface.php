<?php
/**
 * Mockaroo Adapter
 *
 * @since     Feb 2016
 * @author    Haydar KULEKCI  <haydarkulekci@gmail.com>
 */
namespace Mocker\Adapter;

interface AdapterInterface
{
    public function getMockData($context, $count = 1);
}