<?php


namespace DeliberryAPI\Core\CommandBus\Infrastructure\Application\Service\Tactician;


use League\Tactician\CommandBus;
use DeliberryAPI\Core\CommandBus\Application\Service\Query;
use DeliberryAPI\Core\CommandBus\Application\Service\QueryBus;

final class TacticianQueryBus implements QueryBus
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function execute(Query $query): mixed
    {
        return $this->commandBus->handle($query);
    }
}