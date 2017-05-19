<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\ElasticSearchPlugin\Form\Configuration\Provider;

use Sylius\ElasticSearchPlugin\Exception\FilterSetConfigurationNotFoundException;
use Sylius\ElasticSearchPlugin\Form\Configuration\FilterSet;

/**
 * @author Arkadiusz Krakowiak <arkadiusz.k.e@gmail.com>
 */
final class FromArrayFilterSetProvider implements FilterSetProviderInterface
{
    /**
     * @var FilterSet[]
     */
    private $filterSets = [];

    /**
     * @param array $configuration
     */
    public function __construct(array $configuration = [])
    {
        foreach ($configuration as $filterSetName => $filterSetConfiguration) {
            $this->filterSets[$filterSetName] = FilterSet::createFromConfiguration($filterSetName, $filterSetConfiguration);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFilterSetConfiguration($filterSetName)
    {
        if (isset($this->filterSets[$filterSetName])) {
            return $this->filterSets[$filterSetName];
        }

        throw new FilterSetConfigurationNotFoundException();
    }
}
