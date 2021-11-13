<?php


namespace DeliberryAPI\Core\CommandBus\Infrastructure\Domain\Service\Middleware;


use League\Tactician\Middleware;
use DeliberryAPI\Core\Common\Domain\Service\HeadersStamp;
use DeliberryAPI\Core\Message\Domain\Repository\MessageEventStore;
use DeliberryAPI\Core\Session\Application\Service\SessionMemento;
use DeliberryAPI\Core\Common\Domain\Service\DateTimeService;
use DeliberryAPI\Core\Common\Domain\Service\UuidService;
use DeliberryAPI\Core\Common\Domain\Tools\ArrayTools;
use DeliberryAPI\Core\Event\Domain\Service\EventCollection;
use DeliberryAPI\Core\Message\Domain\Model\MessageEventState;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\TransportInterface;

final class DomainEventPublisherMiddleware implements Middleware
{
    public function __construct(
        private SessionMemento $sessionMemento,
        private TransportInterface $transportMessage,
        private MessageEventStore $messageEventStore
    )
    {
    }

    public function execute($command, callable $next)
    {
        /**
         * @var EventCollection $returnValue
         */
        $returnValue = $next($command);

        $currentTrace = $this->sessionMemento->trace();
        $userId = $this->sessionMemento->user()->userId();

        foreach ($returnValue->domainEvents() as $domainEvent) {

            $this
                ->messageEventStore
                ->append(
                    new MessageEventState(
                        $messageId = UuidService::generateVersion4(),
                        $currentTrace->correlationId(),
                        $currentTrace->traceId(),
                        $domainEvent->occurredOn(),
                        $userId,
                        $domainEvent::eventName(),
                        ArrayTools::objectToArray($domainEvent)
                    )
                );

            $this->transportMessage->send(
                new Envelope(
                    $domainEvent,
                    [
                        new AmqpStamp($domainEvent::eventName()),
                        new HeadersStamp(
                            [
                                'eventName' => $domainEvent::eventName(),
                                'occurredOn' => $domainEvent->occurredOn()->format(DateTimeService::DEFAULT_FORMAT_DATE),
                                'messageId' => $messageId,
                                'correlationId' => $currentTrace->correlationId(),
                                'causationId' => $currentTrace->traceId(),
                                'userId' => $userId,
                            ]
                        )
                    ]
                )
            );
        }

        return $returnValue;
    }
}