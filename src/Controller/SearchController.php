<?php

declare(strict_types=1);

namespace Sylius\ElasticSearchPlugin\Controller;

use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use ONGR\FilterManagerBundle\Search\FilterManagerInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\ElasticSearchPlugin\Factory\View\ProductListViewFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Arkadiusz Krakowiak <arkadiusz.k.e@gmail.com>
 */
final class SearchController
{
    /**
     * @var ViewHandlerInterface
     */
    private $restViewHandler;

    /**
     * @var \Sylius\ElasticSearchPlugin\Factory\View\ProductListViewFactoryInterface
     */
    private $productListViewFactory;

    /**
     * @var FilterManagerInterface
     */
    private $filterManager;

    /**
     * @var RepositoryInterface
     */
    private $channelRepository;

    /**
     * @param ViewHandlerInterface $restViewHandler
     * @param \Sylius\ElasticSearchPlugin\Factory\View\ProductListViewFactoryInterface $productListViewFactory
     * @param FilterManagerInterface $filterManager
     * @param RepositoryInterface $channelRepository
     */
    public function __construct(
        ViewHandlerInterface $restViewHandler,
        ProductListViewFactoryInterface $productListViewFactory,
        FilterManagerInterface $filterManager,
        RepositoryInterface $channelRepository
    ) {
        $this->restViewHandler = $restViewHandler;
        $this->productListViewFactory = $productListViewFactory;
        $this->filterManager = $filterManager;
        $this->channelRepository = $channelRepository;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        if (!$request->query->has('channel')) {
            throw new NotFoundHttpException('Cannot find products without channel provided!');
        }

        if (!$request->query->has('locale')) {
            $channelCode = $request->query->get('channel');
            $channel = $this->channelRepository->findOneBy(['code' => $channelCode]);

            if (null === $channel) {
                throw new NotFoundHttpException(sprintf('Channel with code "%s" cannot be found!', $channelCode));
            }

            $request->query->set('locale', $channel->getDefaultLocale()->getCode());
        }

        if (!$request->query->has('stock')) {
            $request->query->set('stock', '1');
        }

        if (!$request->query->has('sort')) {
            if (null !== $request->get('taxonCode')) {
                $request->query->set('sort', ['taxonPositionByCode' => [$request->get('taxonCode') => 'asc']]);
            }

            if (null !== $request->get('taxonSlug')) {
                $request->query->set('sort', ['taxonPositionBySlug' => [$request->get('taxonSlug') => 'asc']]);
            }
        }

        $request->query->set('enabled', true);

        $response = $this->filterManager->handleRequest($request);

        return $this->restViewHandler->handle(
            View::create(
                $this->productListViewFactory->createFromSearchResponse($response),
                Response::HTTP_OK
            )
        );
    }
}
