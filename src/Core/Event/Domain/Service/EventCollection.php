<?php


namespace DeliberryAPI\Core\Event\Domain\Service;


use DeliberryAPI\Core\Event\Domain\Model\DomainEvent;

final class EventCollection
{
    private array $domainEvents;

    private function __construct(DomainEvent ...$domainEvents)
    {
        $this->domainEvents = $domainEvents;
    }

    public static function fromDomainEvents(DomainEvent ...$domainEvents): self
    {
        return new self(...$domainEvents);
    }


    /**
     * @return DomainEvent[]
     */
    public function domainEvents(): array
    {
        return $this->domainEvents;
    }
}