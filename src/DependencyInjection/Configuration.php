<?php

declare(strict_types=1);

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\ElasticSearchPlugin\DependencyInjection;

use Sylius\ElasticSearchPlugin\View\AttributeView;
use Sylius\ElasticSearchPlugin\View\ImageView;
use Sylius\ElasticSearchPlugin\View\PriceView;
use Sylius\ElasticSearchPlugin\View\ProductListView;
use Sylius\ElasticSearchPlugin\View\ProductView;
use Sylius\ElasticSearchPlugin\View\TaxonView;
use Sylius\ElasticSearchPlugin\View\VariantView;
use Sylius\ElasticSearchPlugin\Document\AttributeDocument;
use Sylius\ElasticSearchPlugin\Document\ImageDocument;
use Sylius\ElasticSearchPlugin\Document\OptionDocument;
use Sylius\ElasticSearchPlugin\Document\PriceDocument;
use Sylius\ElasticSearchPlugin\Document\ProductDocument;
use Sylius\ElasticSearchPlugin\Document\TaxonDocument;
use Sylius\ElasticSearchPlugin\Document\VariantDocument;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Arkadiusz Krakowiak <arkadiusz.k.e@gmail.com>
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sylius_elastic_search');

        $this->buildAttributeWhitelistNode($rootNode);
        $this->buildDocumentClassesNode($rootNode);
        $this->buildViewClassesNode($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $rootNode
     */
    private function buildDocumentClassesNode(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('document_classes')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('product')->defaultValue(ProductDocument::class)->end()
                        ->scalarNode('attribute')->defaultValue(AttributeDocument::class)->end()
                        ->scalarNode('image')->defaultValue(ImageDocument::class)->end()
                        ->scalarNode('price')->defaultValue(PriceDocument::class)->end()
                        ->scalarNode('taxon')->defaultValue(TaxonDocument::class)->end()
                        ->scalarNode('variant')->defaultValue(VariantDocument::class)->end()
                        ->scalarNode('option')->defaultValue(OptionDocument::class)->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    /**
     * @param ArrayNodeDefinition $rootNode
     */
    private function buildViewClassesNode(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('view_classes')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('product_list')->defaultValue(ProductListView::class)->end()
                        ->scalarNode('product')->defaultValue(ProductView::class)->end()
                        ->scalarNode('product_variant')->defaultValue(VariantView::class)->end()
                        ->scalarNode('attribute')->defaultValue(AttributeView::class)->end()
                        ->scalarNode('image')->defaultValue(ImageView::class)->end()
                        ->scalarNode('price')->defaultValue(PriceView::class)->end()
                        ->scalarNode('taxon')->defaultValue(TaxonView::class)->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    /**
     * @param ArrayNodeDefinition $rootNode
     */
    private function buildAttributeWhitelistNode(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('attribute_whitelist')
                    ->prototype('scalar')->end()
                ->end()
            ->end()
        ;
    }
}
