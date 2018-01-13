<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Filter\Widget;

use ONGR\ElasticsearchBundle\Result\DocumentIterator;
use ONGR\ElasticsearchDSL\Aggregation\Metric\StatsAggregation;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Query\Joining\NestedQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\RangeQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermQuery;
use ONGR\ElasticsearchDSL\Search;
use ONGR\FilterManagerBundle\Filter\FilterState;
use ONGR\FilterManagerBundle\Filter\ViewData;
use ONGR\FilterManagerBundle\Filter\Widget\Range\AbstractRange;
use ONGR\FilterManagerBundle\Search\SearchRequest;
use Symfony\Component\HttpFoundation\Request;

/**
 * In Stock filter. If single value given, than searches for gt/gte than given number based on isInclusive param
 * If 2 values are given, than searches for a range
 */
class InStock extends AbstractRange
{
    /**
     * {@inheritdoc}
     */
    public function getState(Request $request)
    {
        $state = new FilterState();
        $value = $request->get($this->getRequestField());

        if (isset($value) && $value !== '') {
            $value = is_array($value) ? array_values($value) : $value;
            $state->setActive(true);
            $state->setValue($value);
        }

        if (!$state->isActive()) {
            return $state;
        }

        $values = explode(';', $state->getValue(), 2);

        $argumentCount = count($values);
        if ($argumentCount === 0) {
            $state->setActive(false);

            return $state;
        }

        $gt = $this->isInclusive() ? 'gte' : 'gt';
        $lt = $this->isInclusive() ? 'lte' : 'lt';

        $normalized = [];

        if ($argumentCount === 1) {
            $normalized[$gt] = $values[0];
        }
        if ($argumentCount === 2) {
            $normalized[$gt] = $values[0];
            $normalized[$lt] = $values[1];
        }

        $state->setValue($normalized);

        return $state;
    }

    /**
     * {@inheritdoc}
     */
    public function modifySearch(Search $search, FilterState $state = null, SearchRequest $request = null)
    {
        if ($state && $state->isActive()) {
            $boolQuery = new BoolQuery();
            $boolQuery->add(new RangeQuery($this->getDocumentField(), $state->getValue()), BoolQuery::SHOULD);
            $boolQuery->add(new TermQuery('variants.is_tracked', false), BoolQuery::SHOULD);
            $nestedQuery = new NestedQuery('variants', $boolQuery);
            $search->addPostFilter($nestedQuery);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function preProcessSearch(Search $search, Search $relatedSearch, FilterState $state = null)
    {
        $stateAgg = new StatsAggregation($state->getName());
        $stateAgg->setField($this->getDocumentField());
        $filters = $relatedSearch->getPostFilters();
        if (!empty($filters)) {
            $search->addPostFilter($filters);
        }
        $search->addAggregation($stateAgg);
    }

    /**
     * {@inheritdoc}
     */
    public function getViewData(DocumentIterator $result, ViewData $data)
    {
        $name = $data->getState()->getName();
        /** @var $data ViewData\RangeAwareViewData */
        $data->setMinBounds($result->getAggregation($name)['min']);
        $data->setMaxBounds($result->getAggregation($name)['max']);

        return $data;
    }
}
