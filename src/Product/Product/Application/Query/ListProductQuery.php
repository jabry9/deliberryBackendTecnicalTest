<?php

namespace DeliberryAPI\Product\Product\Application\Query;

use DeliberryAPI\Core\CommandBus\Application\Service\Query;

final class ListProductQuery implements Query
{

    public function __construct(
        public readonly ?string $name = null,
        public readonly ?array $categoriesIds = []
    )
    {
    }

}