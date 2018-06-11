<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Factory\View;

use ONGR\ElasticsearchBundle\Collection\Collection;
use ONGR\FilterManagerBundle\Search\SearchResponse;
use Sylius\ElasticSearchPlugin\Controller\AttributeView;
use Sylius\ElasticSearchPlugin\Controller\ImageView;
use Sylius\ElasticSearchPlugin\Controller\PriceView;
use Sylius\ElasticSearchPlugin\Controller\ProductListView;
use Sylius\ElasticSearchPlugin\Controller\ProductView;
use Sylius\ElasticSearchPlugin\Controller\TaxonView;
use Sylius\ElasticSearchPlugin\Controller\VariantView;
use Sylius\ElasticSearchPlugin\Document\AttributeDocument;
use Sylius\ElasticSearchPlugin\Document\ImageDocument;
use Sylius\ElasticSearchPlugin\Document\PriceDocument;
use Sylius\ElasticSearchPlugin\Document\ProductDocument;
use Sylius\ElasticSearchPlugin\Document\TaxonDocument;
use Sylius\ElasticSearchPlugin\Document\VariantDocument;

final class ProductListViewFactory implements ProductListViewFactoryInterface
{
    /** @var string */
    private $productListViewClass;

    /** @var string */
    private $productViewClass;

    /** @var string */
    private $productVariantViewClass;

    /** @var string */
    private $attributeViewClass;

    /** @var string */
    private $imageViewClass;

    /** @var string */
    private $priceViewClass;

    /** @var string */
    private $taxonViewClass;

    public function __construct(
        string $productListViewClass,
        string $productViewClass,
        string $productVariantViewClass,
        string $attributeViewClass,
        string $imageViewClass,
        string $priceViewClass,
        string $taxonViewClass
    ) {
        $this->productListViewClass = $productListViewClass;
        $this->productViewClass = $productViewClass;
        $this->productVariantViewClass = $productVariantViewClass;
        $this->attributeViewClass = $attributeViewClass;
        $this->imageViewClass = $imageViewClass;
        $this->priceViewClass = $priceViewClass;
        $this->taxonViewClass = $taxonViewClass;
    }

    /**
     * {@inheritdoc}
     */
    public function createFromSearchResponse(SearchResponse $response): ProductListView
    {
        $result = $response->getResult();
        $filters = $response->getFilters();

        /** @var ProductListView $productListView */
        $productListView = new $this->productListViewClass();
        $productListView->filters = $filters;

        $pager = $filters['paginator']->getSerializableData()['pager'];
        $productListView->page = $pager['current_page'];
        $productListView->total = $pager['total_items'];
        $productListView->pages = $pager['num_pages'];
        $productListView->limit = $pager['limit'];

        /** @var ProductDocument $product */
        foreach ($result as $product) {
            $productListView->items[] = $this->getProductView($product);
        }

        return $productListView;
    }

    /**
     * @param Collection|ImageDocument[] $images
     *
     * @return ImageView[]
     */
    private function getImageViews($images): array
    {
        $imageViews = [];
        foreach ($images as $image) {
            /** @var ImageView $imageView */
            $imageView = new $this->imageViewClass();
            $imageView->code = $image->getCode();
            $imageView->path = $image->getPath();

            $imageViews[] = $imageView;
        }

        return $imageViews;
    }

    /**
     * @param Collection|TaxonDocument[] $taxons
     * @param TaxonDocument|null $mainTaxonDocument
     *
     * @return TaxonView
     */
    private function getTaxonView($taxons, ?TaxonDocument $mainTaxonDocument): TaxonView
    {
        /** @var TaxonView $taxonView */
        $taxonView = new $this->taxonViewClass();

        $taxonView->main = null === $mainTaxonDocument ? null : $mainTaxonDocument->getCode();
        foreach ($taxons as $taxon) {
            $taxonView->others[] = $taxon->getCode();
        }

        return $taxonView;
    }

    /**
     * @param Collection|AttributeDocument[] $attributes
     *
     * @return AttributeView[]
     */
    private function getAttributeViews($attributes): array
    {
        $attributeValueViews = [];
        foreach ($attributes as $attribute) {
            /** @var AttributeView $attributeView */
            $attributeView = new $this->attributeViewClass();
            $attributeView->code = $attribute->getCode();
            $attributeView->value = $attribute->getValue();
            $attributeView->name = $attribute->getName();

            $attributeValueViews[$attribute->getCode()] = $attributeView;
        }

        return $attributeValueViews;
    }

    /**
     * @param PriceDocument $price
     *
     * @return PriceView
     */
    private function getPriceView(PriceDocument $price): PriceView
    {
        /** @var PriceView $priceView */
        $priceView = new $this->priceViewClass();
        $priceView->current = $price->getAmount();
        $priceView->currency = $price->getCurrency();
        $priceView->original = $price->getOriginalAmount();

        return $priceView;
    }

    /**
     * @param VariantDocument[]|Collection $variants
     *
     * @return array
     */
    private function getVariantViews($variants): array
    {
        $variantViews = [];
        foreach ($variants as $variant) {
            /** @var VariantView $variantView */
            $variantView = new $this->productVariantViewClass();
            $variantView->id = $variant->getId();
            $variantView->price = $this->getPriceView($variant->getPrice());
            $variantView->code = $variant->getCode();
            $variantView->name = $variant->getName();
            $variantView->stock = $variant->getStock();
            $variantView->isTracked = $variant->getIsTracked();

            if ($variant->getImages()->count() > 0) {
                $variantView->images = $this->getImageViews($variant->getImages());
            }
            $variantViews[] = $variantView;
        }

        return $variantViews;
    }

    /**
     * @param ProductDocument $product
     *
     * @return ProductView
     */
    private function getProductView(ProductDocument $product): ProductView
    {
        /** @var ProductView $productView */
        $productView = new $this->productViewClass();
        $productView->id = $product->getId();
        $productView->slug = $product->getSlug();
        $productView->name = $product->getName();
        $productView->code = $product->getCode();
        $productView->rating = $product->getAverageReviewRating();
        $productView->localeCode = $product->getLocaleCode();
        $productView->channelCode = $product->getChannelCode();
        if ($product->getImages()->count() > 0) {
            $productView->images = $this->getImageViews($product->getImages());
        }
        $productView->taxons = $this->getTaxonView($product->getTaxons(), $product->getMainTaxon());
        $productView->attributes = $this->getAttributeViews($product->getAttributes());
        $productView->variants = $this->getVariantViews($product->getVariants());
        $productView->price = $this->getPriceView($product->getPrice());

        return $productView;
    }
}
