<?php

namespace Sylius\ElasticSearchPlugin\Filter\Widget;

use ONGR\ElasticsearchBundle\Result\DocumentIterator;
use ONGR\ElasticsearchDSL\Search;
use ONGR\FilterManagerBundle\Filter\FilterState;
use ONGR\FilterManagerBundle\Filter\Helper\ViewDataFactoryInterface;
use ONGR\FilterManagerBundle\Filter\ViewData;
use ONGR\FilterManagerBundle\Filter\Widget\AbstractFilter;
use ONGR\FilterManagerBundle\Search\SearchRequest;
use Sylius\ElasticSearchPlugin\Filter\ViewData\PagerAwareViewData;
use Symfony\Component\HttpFoundation\Request;

final class Pager extends AbstractFilter implements ViewDataFactoryInterface
{
    /**
     * @param FilterState|null $state
     *
     * @return int
     */
    public function getCountPerPage(FilterState $state)
    {
        if (null !== $state) {
            return $state->getOption('limit', 10);
        }

        return $this->getOption('limit', 10);
    }

    /**
     * {@inheritdoc}
     */
    public function getState(Request $request)
    {
        $state = parent::getState($request);
        // Reset pager with any filter.
        $state->setUrlParameters([]);
        $page = (integer)$state->getValue();
        $state->setValue($page < 1 ? 1 : $page);
        $state->addOption('limit', $request->get('limit', 10));

        return $state;
    }

    /**
     * {@inheritdoc}
     */
    public function modifySearch(Search $search, FilterState $state = null, SearchRequest $request = null)
    {

        if ($state && $state->isActive()) {
            $search->setFrom($this->getCountPerPage($state) * ($state->getValue() - 1));
        }

        $search->setSize($this->getCountPerPage($state));
    }

    /**
     * {@inheritdoc}
     */
    public function preProcessSearch(Search $search, Search $relatedSearch, FilterState $state = null)
    {
        // Nothing to do here.
    }

    /**
     * {@inheritdoc}
     */
    public function createViewData()
    {
        return new PagerAwareViewData();
    }

    /**
     * {@inheritdoc}
     */
    public function getViewData(DocumentIterator $result, ViewData $data)
    {
        /** @var ViewData\PagerAwareViewData $data */

        $data->setData(
            $result->count(),
            $data->getState()->getValue(),
            $data->getState()->getOption('limit'),
            $this->getOption('max_pages', 10)
        );

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function isRelated()
    {
        return false;
    }
}