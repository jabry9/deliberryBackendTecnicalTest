<?php


namespace DeliberryAPI\Core\Message\Domain\Model;


use DateTimeInterface;

class MessageEventState
{
    public function __construct(
        private string $messageId,
        private string $correlationId,
        private string $causationId,
        private DateTimeInterface $occurredOn,
        private string $userId,
        private string $eventName,
        private array $body
    )
    {
    }

}