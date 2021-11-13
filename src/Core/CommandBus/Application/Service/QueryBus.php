<?php


namespace DeliberryAPI\Core\CommandBus\Application\Service;


interface QueryBus
{
    public function execute(Query $query): mixed;
}