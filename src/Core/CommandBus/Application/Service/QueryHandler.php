<?php


namespace DeliberryAPI\Core\CommandBus\Application\Service;


interface QueryHandler
{
    /**
     * @param Query $query
     * @return mixed
     */
    public function __invoke(): mixed;
}