<?php


namespace DeliberryAPI\Core\Message\Domain\Repository;


use DeliberryAPI\Core\Message\Domain\Model\MessageEventState;

interface MessageEventStore
{
    public function append(MessageEventState $messageEventState): void;
}