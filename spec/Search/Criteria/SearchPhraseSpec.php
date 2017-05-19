<?php

namespace spec\Sylius\ElasticSearchPlugin\Search\Criteria;

use Sylius\ElasticSearchPlugin\Search\Criteria\SearchPhrase;
use PhpSpec\ObjectBehavior;

/**
 * @author Arkadiusz Krakowiak <arkadiusz.krakowiak@lakion.com>
 */
final class SearchPhraseSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Mug');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SearchPhrase::class);
    }

    function it_has_immutable_search_phrase()
    {
        $this->getPhrase()->shouldReturn('Mug');
    }
}
