<?php

namespace DeliberryAPI\Product\Product\Domain\Repository;

use DeliberryAPI\Product\Product\Domain\Model\ProductState;

interface ProductRepository
{
    public function nextId(): string;
    public function add(ProductState $productState): void;
    public function ofId(string $productId): ?ProductState;
}