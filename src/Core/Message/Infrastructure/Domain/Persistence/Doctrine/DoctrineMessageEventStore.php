<?php


namespace DeliberryAPI\Core\Message\Infrastructure\Domain\Persistence\Doctrine;


use Doctrine\ORM\EntityManager;
use DeliberryAPI\Core\Message\Domain\Model\MessageEventState;
use DeliberryAPI\Core\Message\Domain\Repository\MessageEventStore;

final class DoctrineMessageEventStore implements MessageEventStore
{

    public function __construct(private EntityManager $entityManager)
    {
    }

    public function append(MessageEventState $messageEventState): void
    {
        $this->entityManager->persist($messageEventState);
    }

}