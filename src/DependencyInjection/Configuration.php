<?php

namespace Yrial\Simrandom\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        // TODO: Implement getConfigTreeBuilder() method.
        $treeBuilder = new TreeBuilder('yrial_simrandom');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('generator')
                    ->children()
                        ->arrayNode('randomizers')
                            ->children()
                                ->arrayNode('rooms')
                                    ->children()
                                        ->integerNode('min')->end()
                                        ->integerNode('max')->end()
                                    ->end()
                                ->end()
                                ->arrayNode('budget')
                                    ->children()
                                        ->integerNode('min')->end()
                                        ->integerNode('max')->end()
                                    ->end()
                                ->end()
                                ->arrayNode('letter')
                                    ->children()
                                        ->scalarNode('start')->end()
                                        ->scalarNode('end')->end()
                                    ->end()
                                ->end()
                                ->arrayNode('buildings')
                                    ->scalarPrototype()->end()
                                ->end()
                                ->arrayNode('colors')
                                    ->arrayPrototype()
                                        ->children()
                                            ->scalarNode('name')->end()
                                            ->integerNode('weight')->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('challenges')
                            ->arrayPrototype()
                                ->children()
                                    ->integerNode('id')->end()
                                    ->scalarNode('name')->end()
                                    ->arrayNode('randomizers')
                                        ->scalarPrototype()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}