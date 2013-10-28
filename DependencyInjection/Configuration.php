<?php

namespace RC\ServiredBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use RC\ServiredBundle\Session\ServiredSession;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('rc_servired');

        $rootNode
            ->children()
            ->scalarNode('clave')->defaultValue(false)->end()
            ->scalarNode('name')->defaultValue(false)->end()
            ->scalarNode('code')->defaultValue(false)->end()
            ->scalarNode('terminal')->defaultValue(false)->end()
            ->scalarNode('transactiontype')->defaultValue(false)->end()
            ->scalarNode('url')->defaultValue(false)->end()
            ->scalarNode('provider')->defaultValue(false)->end()
            ->scalarNode('url_ok')->defaultValue(false)->end()
            ->scalarNode('url_ko')->defaultValue(false)->end()
            ->scalarNode('paymethod')->defaultValue(false)->end()
        ->end();

        return $treeBuilder;
    }
}
