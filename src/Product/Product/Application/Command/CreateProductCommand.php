<?php

namespace DeliberryAPI\Product\Product\Application\Command;

use DeliberryAPI\Core\CommandBus\Application\Service\Command;

final class CreateProductCommand implements Command
{
    public function __construct(
        private string $userLoggedId,
        private string $name,
        private string $description,
        private ?string $categoryId,
        private float $price
    )
    {
    }

    public function userLoggedId(): string
    {
        return $this->userLoggedId;
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