<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Factory\View;

use ONGR\FilterManagerBundle\Search\SearchResponse;
use Sylius\ElasticSearchPlugin\Controller\ProductListViewInterface;

interface ProductListViewFactoryInterface
{
    /**
     * @param SearchResponse $response
     *
     * @return ProductListViewInterface
     */
    public function createFromSearchResponse(SearchResponse $response): ProductListViewInterface;
}