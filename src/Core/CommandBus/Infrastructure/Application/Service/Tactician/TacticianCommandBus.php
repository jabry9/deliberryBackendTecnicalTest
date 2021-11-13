<?php


namespace DeliberryAPI\Core\CommandBus\Infrastructure\Application\Service\Tactician;


use League\Tactician\CommandBus as CommandBusTactician;
use DeliberryAPI\Core\CommandBus\Application\Service\Command;
use DeliberryAPI\Core\CommandBus\Application\Service\CommandBus;
use DeliberryAPI\Core\Event\Domain\Service\EventCollection;

final class TacticianCommandBus implements CommandBus
{
    private CommandBusTactician $commandBus;

    public function __construct(CommandBusTactician $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function execute(Command $command): EventCollection
    {
        return $this->commandBus->handle($command);
    }

}