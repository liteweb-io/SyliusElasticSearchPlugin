<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\View;

class VariantView implements VariantViewInterface
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
     * @var PriceView
     */
    public $price;

    /**
     * @var int
     */
    public $stock;

    /**
     * @var int
     */
    public $isTracked;

    /**
     * @var ImageView[]
     */
    public $images = [];
}
