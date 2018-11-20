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

namespace Tests\Sylius\ElasticSearchPlugin\DependencyInjection;

use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use Sylius\ElasticSearchPlugin\View\AttributeView;
use Sylius\ElasticSearchPlugin\View\ImageView;
use Sylius\ElasticSearchPlugin\View\PriceView;
use Sylius\ElasticSearchPlugin\View\ProductListView;
use Sylius\ElasticSearchPlugin\View\ProductView;
use Sylius\ElasticSearchPlugin\View\TaxonView;
use Sylius\ElasticSearchPlugin\View\VariantView;
use Sylius\ElasticSearchPlugin\DependencyInjection\Configuration;
use Sylius\ElasticSearchPlugin\Document\AttributeDocument;
use Sylius\ElasticSearchPlugin\Document\ImageDocument;
use Sylius\ElasticSearchPlugin\Document\OptionDocument;
use Sylius\ElasticSearchPlugin\Document\PriceDocument;
use Sylius\ElasticSearchPlugin\Document\ProductDocument;
use Sylius\ElasticSearchPlugin\Document\TaxonDocument;
use Sylius\ElasticSearchPlugin\Document\VariantDocument;

/**
 * @author Arkadiusz Krakowiak <arkadiusz.krakowiak@lakion.com>
 */
final class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    use ConfigurationTestCaseTrait;

    /**
     * @test
     */
    public function it_has_document_classes()
    {
        $this->assertProcessedConfigurationEquals([], ['document_classes' => [
            'product' => ProductDocument::class,
            'attribute' => AttributeDocument::class,
            'image' => ImageDocument::class,
            'price' => PriceDocument::class,
            'taxon' => TaxonDocument::class,
            'variant' => VariantDocument::class,
            'option' => OptionDocument::class,
        ]], 'document_classes');
    }

    /**
     * @test
     */
    public function it_has_view_classes()
    {
        $this->assertProcessedConfigurationEquals([], ['view_classes' => [
            'product_list' => ProductListView::class,
            'product' => ProductView::class,
            'product_variant' => VariantView::class,
            'attribute' => AttributeView::class,
            'image' => ImageView::class,
            'price' => PriceView::class,
            'taxon' => TaxonView::class,
        ]], 'view_classes');
    }

    /**
     * @test
     */
    public function it_has_attribute_white_list()
    {
        $this->assertProcessedConfigurationEquals(
            ['sylius_elastic_search' => ['attribute_whitelist' => ['color']]],
            ['attribute_whitelist' => ['color']],
            'attribute_whitelist'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        return new Configuration();
    }
}
