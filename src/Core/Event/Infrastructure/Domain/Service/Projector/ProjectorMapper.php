<?php


namespace DeliberryAPI\Core\Event\Infrastructure\Domain\Service\Projector;


final class ProjectorMapper
{
    private array $mapper = [];

    public function addProjectorEvent(string $eventName, string $projectorClass)
    {
        if (false === array_key_exists($eventName, $this->mapper)) {
            $this->mapper[$eventName] = [];
        }

        if (false === in_array($projectorClass, $this->mapper[$eventName])) {
            $this->mapper[$eventName][] = $projectorClass;
        }
    }

    public function getProjectors(string $eventName): array
    {
        return $this->mapper[$eventName] ?? [];
    }
}