<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Controller;

class AttributeView implements AttributeViewInterface
{
    /**
     * @var string
     */
    public $code;

    /**
     * @var string
     */
    public $name;

    /**
     * @var mixed
     */
    public $value;
}
