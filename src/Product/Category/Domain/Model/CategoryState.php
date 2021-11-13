<?php

namespace DeliberryAPI\Product\Category\Domain\Model;

class CategoryState
{
    public function __construct(private string $categoryId, private string $name)
    {
    }

    public function categoryId(): string
    {
        return $this->categoryId;
    }

    public function name(): string
    {
        return $this->name;
    }

}