<?php

namespace DeliberryAPI\Product\Product\Domain\QueryModel;

final class ProductQueryInput
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly array $categoriesIds = []
    )
    {
    }

}