<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\View;

class ProductView implements ProductViewInterface
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $code;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $slug;

    /**
     * @var array
     */
    public $taxons = [];

    /**
     * @var array
     */
    public $variants = [];

    /**
     * @var array
     */
    public $attributes = [];

    /**
     * @var array
     */
    public $images = [];

    /**
     * @var PriceView
     */
    public $price;

    /**
     * @var string
     */
    public $channelCode;

    /**
     * @var string
     */
    public $localeCode;

    /**
     * @var array
     */
    public $mainTaxon;

    /**
     * @var float
     */
    public $rating;

    /**
     * @var DateTime
     */
    public $createdAt;
}
