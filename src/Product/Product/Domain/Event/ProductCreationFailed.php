<?php

namespace DeliberryAPI\Product\Product\Domain\Event;

use DateTimeInterface;
use DeliberryAPI\Core\CommandBus\Application\Service\Command;
use DeliberryAPI\Core\Event\Domain\Model\DomainEventFailure;
use DeliberryAPI\Core\Event\Domain\Model\DomainEventFailureReason;
use DeliberryAPI\Product\Product\Application\Command\CreateProductCommand;

final class ProductCreationFailed implements DomainEventFailure
{

    private array $reasons;

    public function __construct(
        private readonly CreateProductCommand $command,
        private readonly DateTimeInterface $occurredOn
    )
    {
        $this->reasons = [];
    }

    public function occurredOn(): DateTimeInterface
    {
        return $this->occurredOn;
    }

    public static function eventName(): string
    {
        return 'deliberryAPI.event.1.product.product.creationFailed';
    }

    public function command(): Command
    {
        return $this->command;
    }

    public function reasons(): array
    {
        return $this->reasons;
    }

    public function appendReason(DomainEventFailureReason $reason): void
    {
        $this->reasons[] = $reason;
    }
}