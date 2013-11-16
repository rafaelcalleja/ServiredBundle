<?php

namespace RC\ServiredBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\Container;

abstract class BaseTestCase extends WebTestCase
{
   /**
     * @var Container
     */
    protected $container;

    /**
     * Return the configuration to use when creating the Kernel.
     *
     * The following settings are used:
     *
     *  * environment - The environment to use (defaults to 'rctest')
     *  * debug - If debug should be enabled/disabled (defaults to true)
     *
     * @return array
     */
    protected function getKernelConfiguration()
    {
        return array();
    }

    /**
     * Gets the container.
     *
     * @return Container
     */
    public function getContainer()
    {
        if (null === $this->container) {
            $client = $this->createClient($this->getKernelConfiguration());
            $this->container = $client->getContainer();
        }

        return $this->container;
    }

    /**
     * {@inheritDoc}
     *
     * This is overriden to set the default environment to 'rctest'
     */
    protected static function createKernel(array $options = array())
    {
        // default environment is 'rctest'
        if (!isset($options['environment'])) {
            $options['environment'] = 'default.yml';
        }

        return parent::createKernel($options);
    }
}