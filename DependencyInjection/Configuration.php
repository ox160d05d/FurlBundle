<?php

namespace HardFAQCafe\FurlBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;


class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('hard_faq_cafe_furl');

        $rootNode->children()
                ->scalarNode('url_encoder_service_id')
                    ->defaultValue('hard_faq_cafe_furl.gmpbase62endec')
                ->end()
                ->scalarNode('url_validator_service_id')
                    ->defaultValue('hard_faq_cafe_furl.url_validator')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
