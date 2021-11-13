<?php


namespace DeliberryAPI\Core\CommandBus\Infrastructure\Domain\Service\Middleware;


use League\Tactician\Middleware;
use Psr\Container\ContainerInterface;
use DeliberryAPI\Core\Event\Domain\Service\EventCollection;
use DeliberryAPI\Core\Event\Infrastructure\Domain\Service\Projector\ProjectorMapper;

final class DomainEventProjectMiddleware implements Middleware
{
    public function __construct(private ContainerInterface $container, private ProjectorMapper $projectorMapper)
    {
    }

    public function execute($command, callable $next)
    {
        /**
         * @var EventCollection $returnValue
         */
        $returnValue = $next($command);

        foreach ($returnValue->domainEvents() as $domainEvent) {
            foreach ($this->projectorMapper->getProjectors($domainEvent::eventName()) as $projectorId) {
                $this->container->get($projectorId)->project($domainEvent);
            }
        }

        return $returnValue;
    }
}