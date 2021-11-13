<?php

namespace DeliberryAPI\Product\Product\Domain\Model;

class ProductState
{
    public function __construct(
        private string $productId,
        private string $name,
        private string $description,
        private ?string $categoryId,
        private float $price
    ) {
    }

    public function productId(): string
    {
        return $this->productId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function categoryId(): ?string
    {
        return $this->categoryId;
    }

    public function price(): float
    {
        return $this->price;
    }

}