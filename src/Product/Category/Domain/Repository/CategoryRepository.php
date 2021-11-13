<?php

namespace DeliberryAPI\Product\Category\Domain\Repository;

use DeliberryAPI\Product\Category\Domain\Model\CategoryState;

interface CategoryRepository
{
    public function ofId(string $categoryId): ?CategoryState;
}