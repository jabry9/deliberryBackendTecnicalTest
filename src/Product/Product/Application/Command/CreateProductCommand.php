<?php

namespace DeliberryAPI\Product\Product\Application\Command;

use DeliberryAPI\Core\CommandBus\Application\Service\Command;

final class CreateProductCommand implements Command
{
    public function __construct(
        public readonly string $userLoggedId,
        public readonly string $name,
        public readonly string $description,
        public readonly ?string $categoryId,
        public readonly float $price
    )
    {
    }
}