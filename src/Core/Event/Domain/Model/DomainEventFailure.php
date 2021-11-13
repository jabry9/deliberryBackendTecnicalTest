<?php


namespace DeliberryAPI\Core\Event\Domain\Model;


use DeliberryAPI\Core\CommandBus\Application\Service\Command;

interface DomainEventFailure extends DomainEvent
{
    public function command(): Command;
    /**
     * @return DomainEventFailureReason[]
     */
    public function reasons(): array;
    public function appendReason(DomainEventFailureReason $reason): void;
}