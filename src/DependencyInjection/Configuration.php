<?php

namespace Nkt\ImageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Gusakov Nikita <dev@nkt.me>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('nkt_image');
        $rootNode->children()
            ->scalarNode('upload_dir')->defaultValue('%kernel.root_dir%/uploads')->end()
            ->arrayNode('types')
                ->isRequired()
                ->requiresAtLeastOneElement()
                ->prototype('array')
                ->children()
                    ->scalarNode('extension')->defaultValue('png')->end()
                    ->integerNode('min_width')->min(0)->defaultValue(0)->example(100)->end()
                    ->integerNode('max_width')->min(0)->defaultValue(0)->example(1000)->end()
                    ->integerNode('min_height')->min(0)->defaultValue(0)->example(1000)->end()
                    ->integerNode('max_height')->min(0)->defaultValue(0)->example(1000)->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
