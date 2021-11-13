<?php


namespace DeliberryAPI\Core\Event\Application\Projector;


use DeliberryAPI\Core\Event\Domain\Model\DomainEvent;

interface Projector
{
    public function project(DomainEvent $domainEvent): void;
    /**
     * @return string[]
     */
    public static function eventNameProjected(): array;
}