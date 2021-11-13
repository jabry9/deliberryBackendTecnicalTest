<?php

namespace DeliberryAPI\Product\Product\Application\Query;

use DeliberryAPI\Core\CommandBus\Application\Service\Query;
use DeliberryAPI\Core\CommandBus\Application\Service\QueryHandler;
use DeliberryAPI\Product\Product\Domain\QueryModel\ProductQuery;
use DeliberryAPI\Product\Product\Domain\QueryModel\ProductQueryInput;

final class ListProductQueryHandler implements QueryHandler
{

    public function __construct(private ProductQuery $productQuery)
    {
    }

    public function __invoke(ListProductQuery $query = null): mixed
    {
        return $this->productQuery->find(
            (new ProductQueryInput())->withName($query->name())->withCategoriesIds($query->categoriesIds())
        );
    }
}