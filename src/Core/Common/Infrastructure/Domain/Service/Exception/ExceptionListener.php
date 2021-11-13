<?php

namespace DeliberryAPI\Core\Common\Infrastructure\Domain\Service\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final class ExceptionListener
{

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $response = new JsonResponse($exception->getMessage());
        $event->setResponse($response);
    }
}