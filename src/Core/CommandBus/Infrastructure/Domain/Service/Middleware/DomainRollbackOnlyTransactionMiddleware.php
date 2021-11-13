<?php


namespace DeliberryAPI\Core\CommandBus\Infrastructure\Domain\Service\Middleware;


use Doctrine\ORM\EntityManagerInterface;
use League\Tactician\Middleware;
use Throwable;

final class DomainRollbackOnlyTransactionMiddleware implements Middleware
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function execute($command, callable $next)
    {
        $isTransactionActive = $this->entityManager->getConnection()->isTransactionActive();

        if (false === $isTransactionActive) {
            $this->entityManager->beginTransaction();
        }


        try {
            $returnValue = $next($command);

            if (false === $isTransactionActive) {
                $this->entityManager->flush();
                $this->entityManager->commit();
            }
        } catch (Throwable $e) {
            $this->entityManager->rollback();
            throw $e;
        }

        return $returnValue;
    }
}