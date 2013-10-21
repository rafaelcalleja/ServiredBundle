<?php

namespace RC\ServiredBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class RCServiredExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $container->setParameter($this->getAlias().'.clave', $config['clave']);
        $container->setParameter($this->getAlias().'.name', $config['name']);
        $container->setParameter($this->getAlias().'.code', $config['code']);
        $container->setParameter($this->getAlias().'.terminal', $config['terminal']);
        $container->setParameter($this->getAlias().'.transactiontype', $config['transactiontype']);
        $container->setParameter($this->getAlias().'.url', $config['url']);
        $container->setParameter($this->getAlias().'.provider', $config['provider']);
        $container->setParameter($this->getAlias().'.url_ko', $config['url_ko']);
        $container->setParameter($this->getAlias().'.url_ok', $config['url_ok']);
        $container->setParameter($this->getAlias().'.cachedir', $config['cachedir']);
        $container->setParameter($this->getAlias().'.paymethod', $config['paymethod']);
        $container->setParameter($this->getAlias().'.payment_session_key', $config['payment_session_key']);

    }
}
