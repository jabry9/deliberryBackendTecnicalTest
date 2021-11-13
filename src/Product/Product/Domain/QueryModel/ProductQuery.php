<?php

namespace DeliberryAPI\Product\Product\Domain\QueryModel;

interface ProductQuery
{
    /**
     * @return ProductQueryProductOutput[]
     */
    public function find(ProductQueryInput $input): array;
}