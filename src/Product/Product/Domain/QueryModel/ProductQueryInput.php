<?php

namespace DeliberryAPI\Product\Product\Domain\QueryModel;

final class ProductQueryInput
{
    private ?string $name = null;
    private array $categoriesIds = [];

    public function name(): ?string
    {
        return $this->name;
    }

    public function withName(?string $name): self
    {
        $clone = clone $this;
        $clone->name = $name;
        return $clone;
    }

    /**
     * @return string[]
     */
    public function categoriesIds(): array
    {
        return $this->categoriesIds;
    }

    public function withCategoriesIds(array $categoriesIds): self
    {
        $clone = clone $this;
        $clone->categoriesIds = $categoriesIds;
        return $clone;
    }

}