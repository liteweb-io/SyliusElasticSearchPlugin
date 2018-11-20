<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\View;

class ProductListView implements ProductListViewInterface
{
    /**
     * @var int
     */
    public $page;

    /**
     * @var int
     */
    public $limit;

    /**
     * @var int
     */
    public $total;

    /**
     * @var int
     */
    public $pages;

    /**
     * @var ProductView[]
     */
    public $items = [];

    /**
     * @var ViewData[]
     */
    public $filters;
}
