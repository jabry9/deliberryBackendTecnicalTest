<?php

namespace DeliberryAPI\Product\Product\Application\Command;

use DeliberryAPI\Core\CommandBus\Application\Service\Command;
use DeliberryAPI\Core\CommandBus\Application\Service\CommandHandler;
use DeliberryAPI\Core\Event\Domain\Service\EventCollection;
use DeliberryAPI\Product\Product\Domain\Service\ProductCreatorService;

final class CreateProductCommandHandler implements CommandHandler
{

    public function __construct(private ProductCreatorService $productCreatorService)
    {
    }

    public function __invoke(CreateProductCommand $command = null): EventCollection
    {
        return $this->productCreatorService->execute($command);
    }
}