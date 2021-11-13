<?php

namespace DeliberryAPI\Product\Product\Domain\QueryModel;

final class ProductQueryProductCategoryOutput
{
    public function __construct(
        private string $categoryId,
        private string $name,
    ) {
    }
}