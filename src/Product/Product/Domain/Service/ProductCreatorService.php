<?php

namespace DeliberryAPI\Product\Product\Domain\Service;

use DeliberryAPI\Core\Common\Domain\Service\DateTimeService;
use DeliberryAPI\Core\Event\Domain\Model\DomainEventFailureReason;
use DeliberryAPI\Core\Event\Domain\Service\EventCollection;
use DeliberryAPI\Product\Category\Domain\Repository\CategoryRepository;
use DeliberryAPI\Product\Product\Application\Command\CreateProductCommand;
use DeliberryAPI\Product\Product\Domain\Event\ProductCreated;
use DeliberryAPI\Product\Product\Domain\Event\ProductCreationFailed;
use DeliberryAPI\Product\Product\Domain\Repository\ProductRepository;
use DeliberryAPI\User\User\Domain\Model\UserState;
use DeliberryAPI\User\User\Domain\Repository\UserRepository;

final class ProductCreatorService
{

    public const REASON_USER_DOES_NOT_FOUND = [
        DomainEventFailureReason::REASON_TEXT => 'User does not found.',
        DomainEventFailureReason::REASON_CODE => 'REASON_USER_DOES_NOT_FOUND',
    ];

    public const REASON_USER_HAS_NOT_ROLE_ADMIN = [
        DomainEventFailureReason::REASON_TEXT => 'User has not role admin.',
        DomainEventFailureReason::REASON_CODE => 'REASON_USER_HAS_NOT_ROLE_ADMIN',
    ];

    public const REASON_CATEGORY_DOES_NOT_FOUND = [
        DomainEventFailureReason::REASON_TEXT => 'Category does not found.',
        DomainEventFailureReason::REASON_CODE => 'REASON_CATEGORY_DOES_NOT_FOUND',
    ];

    public function __construct(
        private UserRepository $userRepository,
        private CategoryRepository $categoryRepository,
        private ProductRepository $productRepository,
        private DateTimeService $dateTimeService
    )
    {
    }

    public function execute(CreateProductCommand $command): EventCollection
    {
        $events = [];

        $failureEvent = new ProductCreationFailed(
            $command,
            $this->dateTimeService->currentDateTime()
        );

        $user = $this->userRepository->ofId($command->userLoggedId());

        if ($command->categoryId()) {
            $category = $this->categoryRepository->ofId($command->categoryId());

            if (is_null($category)) {
                $failureEvent->appendReason(
                    DomainEventFailureReason::fromArray(
                        self::REASON_CATEGORY_DOES_NOT_FOUND
                    )
                );
            }
        }

        if (is_null($user)) {
            $failureEvent->appendReason(
                DomainEventFailureReason::fromArray(
                    self::REASON_USER_DOES_NOT_FOUND
                )
            );
        }

        if (false === is_null($user) && false === in_array(UserState::ROLE_ADMIN, $user->getRoles())) {
            $failureEvent->appendReason(
                DomainEventFailureReason::fromArray(
                    self::REASON_USER_HAS_NOT_ROLE_ADMIN
                )
            );
        }

        if (0 !== count($failureEvent->reasons())) {
            $events[] = $failureEvent;
        }

        if (0 === count($events)) {
            $events[] = new ProductCreated(
                $this->productRepository->nextId(),
                $command->name(),
                $command->description(),
                $command->categoryId(),
                $command->price(),
                $this->dateTimeService->currentDateTime()
            );
        }


        return EventCollection::fromDomainEvents(...$events);
    }
}