<?php


namespace DeliberryAPI\Core\CommandBus\Application\Service;


use DeliberryAPI\Core\Event\Domain\Service\EventCollection;

interface CommandHandler
{
    /**
     * @param Command $command
     * @return EventCollection
     */
    public function __invoke(): EventCollection;
}