<?php

namespace DeliberryAPI\Core\Common\Infrastructure\Domain\Service\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;

final class DoctrinePaginationTools
{

    public function __construct(private QueryBuilder $queryBuilder, private ?int $limit, private ?int $page)
    {
    }

    public function paginate(): QueryBuilder
    {
        $clone = clone $this->queryBuilder;
        if ($this->limit > 0 && $this->page > 0) {
            $clone
                ->setFirstResult(
                    $this->limit * ($this->page - 1)
                )
                ->setMaxResults($this->limit);
        }

        return $clone;
    }

    public function calculateNumberOfPages(int $totalItems): int
    {
        return (int)ceil(
            $totalItems / ($this->limit > 0 ? $this->limit : 1)
        );
    }

    public static function paginateStatic(QueryBuilder $queryBuilder, ?int $page, ?int $limit): QueryBuilder
    {
        return (new self($queryBuilder, $limit, $page))->paginate();
    }
}