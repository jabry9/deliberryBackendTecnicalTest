<?php


namespace DeliberryAPI\Core\CommandBus\Application\Service;


use DeliberryAPI\Core\Event\Domain\Service\EventCollection;

interface CommandBus
{
    public function execute(Command $command): EventCollection;
}