<?php

namespace DeliberryAPI\Product\Product\Domain\QueryModel;

final class ProductQueryProductOutput
{
    public function __construct(
        public readonly string $productId,
        public readonly string $name,
        public readonly string $description,
        public readonly ?ProductQueryProductCategoryOutput $category,
        public readonly float $price
    ) {
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