<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Controller;

class TaxonView implements TaxonViewInterface
{
    /**
     * @var string
     */
    public $main;

    /**
     * @var string[]
     */
    public $others = [];
}
