<?php


namespace DeliberryAPI\Core\Event\Domain\Model;


use DateTimeInterface;

interface DomainEvent
{
    public function occurredOn(): DateTimeInterface;
    /**
     * @return string
     * @example 'deliberryAPI.event.1.product.product.created'
     * @Annotation 'deliberryAPI.event.version.module.submodule.action'
     */
    public static function eventName(): string;
}