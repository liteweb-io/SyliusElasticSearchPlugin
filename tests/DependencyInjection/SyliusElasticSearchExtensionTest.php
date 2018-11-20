<?php

declare(strict_types=1);

namespace Tests\Sylius\ElasticSearchPlugin\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Sylius\ElasticSearchPlugin\View\AttributeView;
use Sylius\ElasticSearchPlugin\View\ImageView;
use Sylius\ElasticSearchPlugin\View\PriceView;
use Sylius\ElasticSearchPlugin\View\ProductListView;
use Sylius\ElasticSearchPlugin\View\ProductView;
use Sylius\ElasticSearchPlugin\View\TaxonView;
use Sylius\ElasticSearchPlugin\View\VariantView;
use Sylius\ElasticSearchPlugin\DependencyInjection\SyliusElasticSearchExtension;
use Sylius\ElasticSearchPlugin\Document\AttributeDocument;
use Sylius\ElasticSearchPlugin\Document\ImageDocument;
use Sylius\ElasticSearchPlugin\Document\OptionDocument;
use Sylius\ElasticSearchPlugin\Document\PriceDocument;
use Sylius\ElasticSearchPlugin\Document\ProductDocument;
use Sylius\ElasticSearchPlugin\Document\TaxonDocument;
use Sylius\ElasticSearchPlugin\Document\VariantDocument;

final class SyliusElasticSearchExtensionTest extends AbstractExtensionTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensions()
    {
        return [new SyliusElasticSearchExtension()];
    }

    /**
     * @test
     */
    public function it_defines_document_classes_parameters()
    {
        $this->load([]);

        $this->assertContainerBuilderHasParameter('sylius_elastic_search.document.product.class', ProductDocument::class);
        $this->assertContainerBuilderHasParameter('sylius_elastic_search.document.attribute.class', AttributeDocument::class);
        $this->assertContainerBuilderHasParameter('sylius_elastic_search.document.image.class', ImageDocument::class);
        $this->assertContainerBuilderHasParameter('sylius_elastic_search.document.price.class', PriceDocument::class);
        $this->assertContainerBuilderHasParameter('sylius_elastic_search.document.taxon.class', TaxonDocument::class);
        $this->assertContainerBuilderHasParameter('sylius_elastic_search.document.variant.class', VariantDocument::class);
        $this->assertContainerBuilderHasParameter('sylius_elastic_search.document.option.class', OptionDocument::class);
    }

    /**
     * @test
     */
    public function it_defines_view_classes_parameters()
    {
        $this->load([]);

        $this->assertContainerBuilderHasParameter('sylius_elastic_search.view.product_list.class', ProductListView::class);
        $this->assertContainerBuilderHasParameter('sylius_elastic_search.view.product.class', ProductView::class);
        $this->assertContainerBuilderHasParameter('sylius_elastic_search.view.product_variant.class', VariantView::class);
        $this->assertContainerBuilderHasParameter('sylius_elastic_search.view.attribute.class', AttributeView::class);
        $this->assertContainerBuilderHasParameter('sylius_elastic_search.view.image.class', ImageView::class);
        $this->assertContainerBuilderHasParameter('sylius_elastic_search.view.price.class', PriceView::class);
        $this->assertContainerBuilderHasParameter('sylius_elastic_search.view.taxon.class', TaxonView::class);
    }

    /**
     * @test
     */
    public function it_defines_attribute_whitelist_parameter()
    {
        $this->load([]);

        $this->assertContainerBuilderHasParameter('sylius_elastic_search.attribute_whitelist', []);
    }
}
