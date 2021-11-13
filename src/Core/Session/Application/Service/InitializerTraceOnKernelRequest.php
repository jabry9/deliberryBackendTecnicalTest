<?php


namespace DeliberryAPI\Core\Session\Application\Service;


use DeliberryAPI\Core\Common\Domain\Service\UuidService;
use DeliberryAPI\Core\Trace\Domain\Model\Trace;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final class InitializerTraceOnKernelRequest
{
    public function __construct(private SessionMemento $sessionMemento)
    {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $this
            ->sessionMemento
            ->withTrace(
                new Trace(
                    $traceId = UuidService::generateVersion4(),
                    $traceId,
                    $traceId
                )
            );
    }

}