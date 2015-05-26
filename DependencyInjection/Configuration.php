<?php

namespace Mediapark\MPDoctrineRepositoryExtensionBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mp_doctrine');

        $this->addORMSection($rootNode);

        return $treeBuilder;
    }

    private function addORMSection(ArrayNodeDefinition $node) {
        $node 
            ->children()
                ->arrayNode('doctrine')
                    ->children()
                        ->arrayNode('orm')
                            ->children()
                                ->arrayNode('repository_factory')
                                    ->children()
                                        ->scalarNode('class')
                                        ->end()
                                        ->arrayNode('repositories_resolver')
                                            ->children()
                                                ->scalarNode('class')
                                                ->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
