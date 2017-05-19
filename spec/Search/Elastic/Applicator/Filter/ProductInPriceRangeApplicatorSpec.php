<?php

namespace spec\Sylius\ElasticSearchPlugin\Search\Elastic\Applicator\Filter;

use Sylius\ElasticSearchPlugin\Search\Criteria\Filtering\ProductInPriceRangeFilter;
use Sylius\ElasticSearchPlugin\Search\Elastic\Applicator\Filter\ProductInPriceRangeApplicator;
use Sylius\ElasticSearchPlugin\Search\Elastic\Applicator\SearchCriteriaApplicatorInterface;
use Sylius\ElasticSearchPlugin\Search\Elastic\Factory\Query\QueryFactoryInterface;
use ONGR\ElasticsearchDSL\Query\BoolQuery;
use ONGR\ElasticsearchDSL\Query\NestedQuery;
use ONGR\ElasticsearchDSL\Search;
use PhpSpec\ObjectBehavior;

/**
 * @author Arkadiusz Krakowiak <arkadiusz.krakowiak@lakion.com>
 */
final class ProductInPriceRangeApplicatorSpec extends ObjectBehavior
{
    function let(QueryFactoryInterface $productInPriceRangeQueryFactory)
    {
        $this->beConstructedWith($productInPriceRangeQueryFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ProductInPriceRangeApplicator::class);
    }

    function it_is_search_criteria_applicator()
    {
        $this->shouldImplement(SearchCriteriaApplicatorInterface::class);
    }

    function it_applies_search_criteria_for_given_query(QueryFactoryInterface $productInPriceRangeQueryFactory, Search $search, NestedQuery $nestedQuery)
    {
        $criteria = new ProductInPriceRangeFilter(20, 50);
        $productInPriceRangeQueryFactory->create(['product_price_range' => ['grater_than' => 20, 'less_than' => 50]])->willReturn($nestedQuery);
        $search->addFilter($nestedQuery, BoolQuery::MUST)->shouldBeCalled();

        $this->apply($criteria, $search);
    }
}
