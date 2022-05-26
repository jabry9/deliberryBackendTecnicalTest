<?php


namespace DeliberryAPI\User\User\Infrastructure\Domain\Persistence\Doctrine;


use Doctrine\ORM\EntityManager;
use DeliberryAPI\User\User\Domain\Model\UserState;
use DeliberryAPI\User\User\Domain\Repository\UserRepository;

final class DoctrineUserRepository implements UserRepository
{

    public function __construct(private readonly EntityManager $entityManager)
    {
    }

    public function ofId(string $userId): ?UserState
    {
        return $this
            ->entityManager
            ->createQueryBuilder()
            ->select('user')
            ->from(UserState::class, 'user')
            ->where('user.userId = :userId')
            ->setParameter('userId', $userId)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function ofUsername(string $username): ?UserState
    {
        return $this
            ->entityManager
            ->createQueryBuilder()
            ->select('user')
            ->from(UserState::class, 'user')
            ->where('user.username = :username')
            ->setParameter('username', $username)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}