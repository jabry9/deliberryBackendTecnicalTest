<?php

namespace DeliberryAPI\Tests\Product\Product\Application\Command;

use DateTimeImmutable;
use DateTimeInterface;
use DeliberryAPI\Core\Common\Domain\Service\DateTimeService;
use DeliberryAPI\Core\Event\Domain\Model\DomainEventFailure;
use DeliberryAPI\Core\Event\Domain\Model\DomainEventFailureReason;
use DeliberryAPI\Core\Event\Domain\Service\EventCollection;
use DeliberryAPI\Product\Category\Domain\Model\CategoryState;
use DeliberryAPI\Product\Category\Domain\Repository\CategoryRepository;
use DeliberryAPI\Product\Product\Application\Command\CreateProductCommand;
use DeliberryAPI\Product\Product\Application\Command\CreateProductCommandHandler;
use DeliberryAPI\Product\Product\Domain\Event\ProductCreated;
use DeliberryAPI\Product\Product\Domain\Event\ProductCreationFailed;
use DeliberryAPI\Product\Product\Domain\Repository\ProductRepository;
use DeliberryAPI\Product\Product\Domain\Service\ProductCreatorService;
use DeliberryAPI\User\User\Domain\Model\UserState;
use DeliberryAPI\User\User\Domain\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class CreateProductCommandHandlerTest extends TestCase
{

    /**
     * @test
     * @dataProvider scenarios
     */
    public function scenarioExecutor(
        CreateProductCommand $command,
        ?UserState $user,
        ?CategoryState $category,
        ?string $productId,
        DateTimeInterface $currentDateTime,
        array $events
    ) {

        $userRepository = $this->createMock(UserRepository::class);

        $userRepository->method('ofId')
            ->willReturn($user);

        $categoryRepository = $this->createMock(CategoryRepository::class);

        $categoryRepository->method('ofId')
            ->willReturn($category);

        $productRepository = $this->createMock(ProductRepository::class);

        $productRepository->method('nextId')
            ->willReturn($productId);

        $dateTimeService = $this->createMock(DateTimeService::class);

        $dateTimeService->method('currentDateTime')
            ->willReturn($currentDateTime);

        $creatorService = new ProductCreatorService(
            $userRepository,
            $categoryRepository,
            $productRepository,
            $dateTimeService
        );

        $commandHandler = new CreateProductCommandHandler($creatorService);

        $this->assertEquals(
            EventCollection::fromDomainEvents(
                ...
                $events
            ),
            $commandHandler($command)
        );
    }

    public function scenarios(): array
    {
        return [
            $this->whenUserDoesNotFound(),
            $this->whenUserAndCategoryDoesNotFound(),
            $this->whenUserDoesNotHaveRoleAdminAndCategoryDoesNotFound(),
            $this->whenProductCreated(),
        ];
    }

    private function whenUserDoesNotFound(): array
    {
        return [
            $command = new CreateProductCommand(
                '',
                '',
                '',
                '',
                0
            ),
            $user = null,
            $category = null,
            $productId = '',
            $currentDateTime = new DateTimeImmutable(),
            $events = [
                $this->appendReasons(
                    new ProductCreationFailed(
                        $command,
                        $currentDateTime
                    ),
                    [
                        DomainEventFailureReason::fromArray(
                            ProductCreatorService::REASON_USER_DOES_NOT_FOUND
                        )
                    ]
                )
            ]
        ];
    }

    private function whenUserAndCategoryDoesNotFound(): array
    {
        return [
            $command = new CreateProductCommand(
                '',
                '',
                '',
                'categoryId',
                0
            ),
            $user = null,
            $category = null,
            $productId = '',
            $currentDateTime = new DateTimeImmutable(),
            $events = [
                $this->appendReasons(
                    new ProductCreationFailed(
                        $command,
                        $currentDateTime
                    ),
                    [
                        DomainEventFailureReason::fromArray(
                            ProductCreatorService::REASON_CATEGORY_DOES_NOT_FOUND
                        ),
                        DomainEventFailureReason::fromArray(
                            ProductCreatorService::REASON_USER_DOES_NOT_FOUND
                        ),

                    ]
                )
            ]
        ];
    }

    private function whenUserDoesNotHaveRoleAdminAndCategoryDoesNotFound(): array
    {

        $user = $this->createMock(UserState::class);

        $user->method('getRoles')
            ->willReturn([]);


        return [
            $command = new CreateProductCommand(
                '',
                '',
                '',
                'categoryId',
                0
            ),
            $user,
            $category = null,
            $productId = '',
            $currentDateTime = new DateTimeImmutable(),
            $events = [
                $this->appendReasons(
                    new ProductCreationFailed(
                        $command,
                        $currentDateTime
                    ),
                    [
                        DomainEventFailureReason::fromArray(
                            ProductCreatorService::REASON_CATEGORY_DOES_NOT_FOUND
                        ),
                        DomainEventFailureReason::fromArray(
                            ProductCreatorService::REASON_USER_HAS_NOT_ROLE_ADMIN
                        ),

                    ]
                )
            ]
        ];
    }

    private function whenProductCreated(): array
    {

        $user = $this->createMock(UserState::class);

        $user->method('getRoles')
            ->willReturn([UserState::ROLE_ADMIN]);


        return [
            $command = new CreateProductCommand(
                '41963516-a753-4b06-9347-54e8f6b3daa9',
                'Milk',
                'Milk 1L',
                null,
                74.1
            ),
            $user,
            $category = null,
            $productId = '2453d4ab-b665-4d86-8afb-fb04006cfc2f',
            $currentDateTime = new DateTimeImmutable(),
            $events = [
                new ProductCreated(
                    $productId,
                    'Milk',
                    'Milk 1L',
                    null,
                    74.1,
                    $currentDateTime
                )
            ]
        ];
    }

    private function appendReasons(DomainEventFailure $domainEventFailure, array $reasons): DomainEventFailure
    {
        foreach ($reasons as $reason) {
            $domainEventFailure->appendReason($reason);
        }

        return $domainEventFailure;
    }
}
