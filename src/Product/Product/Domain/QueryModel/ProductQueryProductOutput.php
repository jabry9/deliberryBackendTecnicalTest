<?php

namespace DeliberryAPI\Product\Product\Domain\QueryModel;

final class ProductQueryProductOutput
{
    public function __construct(
        private string $productId,
        private string $name,
        private string $description,
        private ?ProductQueryProductCategoryOutput $category,
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

    public function category(): ?ProductQueryProductCategoryOutput
    {
        return $this->category;
    }

    public function price(): float
    {
        return $this->price;
    }

    /**
     * @param array $items
     * @return self[]
     */
    public static function fromCollection(array $items): array
    {
        return array_map(
            fn($item) => new self(
                $item['productId'],
                $item['name'],
                $item['description'],
                $item['categoryId'] ? new ProductQueryProductCategoryOutput(
                    $item['categoryId'],
                    $item['categoryName']
                ) : null,
                $item['price']
            ),
            $items
        );
    }
}