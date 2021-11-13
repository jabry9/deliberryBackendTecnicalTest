<?php

namespace DeliberryAPI\Product\Product\Infrastructure\UI\API\Controller;

use DeliberryAPI\Core\CommandBus\Application\Service\CommandBus;
use DeliberryAPI\Core\CommandBus\Application\Service\QueryBus;
use DeliberryAPI\Core\Common\Infrastructure\Domain\Service\HttpFoundation\RequestHelperService;
use DeliberryAPI\Core\Common\Infrastructure\Domain\Service\HttpFoundation\ResponseHelperService;
use DeliberryAPI\Core\Session\Application\Service\SessionMemento;
use DeliberryAPI\Product\Product\Application\Command\CreateProductCommand;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ProductController
{
    use ContainerAwareTrait;

    public function __construct(
        private CommandBus $commandBus,
        private SessionMemento $sessionMemento,
        private QueryBus $queryBus
    ) {
    }


    public function createProduct(Request $request): JsonResponse
    {
        $response = $this
            ->commandBus
            ->execute(
                new CreateProductCommand(
                    $this->sessionMemento->user()->userId(),
                    RequestHelperService::requestRequiredParameter(
                        $request,
                        'name'
                    ),
                    RequestHelperService::requestRequiredParameter(
                        $request,
                        'description'
                    ),
                    RequestHelperService::requestParameter(
                        $request,
                        'categoryId'
                    ),
                    RequestHelperService::requestParameter(
                        $request,
                        'price'
                    ),
                )
            );

        return ResponseHelperService::fromFailureDomainEvents(
            Response::HTTP_CREATED,
            ...
            $response->domainEvents()
        );
    }
}