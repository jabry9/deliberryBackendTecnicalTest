<?php

namespace DeliberryAPI\Product\Product\Domain\QueryModel;

final class ProductQueryProductCategoryOutput
{
    public function __construct(
        public readonly string $categoryId,
        public readonly string $name,
    ) {
    }
}