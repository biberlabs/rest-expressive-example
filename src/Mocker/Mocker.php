<?php
/**
 * Mocker Class
 *
 * @since     Feb 2016
 * @author    Haydar KULEKCI  <haydarkulekci@gmail.com>
 */
namespace Mocker;

use Mocker\Adapter\AdapterInterface;

class Mocker
{
    /**
     * @var Context
     */
    protected $context;

    protected $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function setContext(Context $context)
    {
        $this->context = $context;
    }

    public function scan($entity)
    {
        $scanner = new \Mocker\Scanner();
        $contexts = $scanner->scan($entity);
        if (count($contexts) > 1) {
            throw new Exception\MoreThanOneException(400, 'Scanner return more than one context');
        }
        $this->setContext($contexts[0]);
        if (empty($this->context->getEntity())) {
            throw new \Exception('Entity is required in context to create a mock');
        }
        if (empty($this->context->getProperties())) {
            throw new \Exception('Propety is required in context to create a mock');
        }
    }

    public function mockOne()
    {
        return $this->adapter->getMockData($this->context);
    }

    public function mockMore($count)
    {
        return $this->adapter->getMockData($this->context, $count);
    }

}