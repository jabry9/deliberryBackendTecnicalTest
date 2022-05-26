<?php

namespace DeliberryAPI\Product\Product\Infrastructure\Domain\QueryModel\Doctrine;

use DeliberryAPI\Core\Common\Infrastructure\Domain\Service\Doctrine\DoctrineFieldsHelper;
use DeliberryAPI\Product\Product\Domain\QueryModel\ProductQuery;
use DeliberryAPI\Product\Product\Domain\QueryModel\ProductQueryInput;
use DeliberryAPI\Product\Product\Domain\QueryModel\ProductQueryProductOutput;
use Doctrine\DBAL\Connection;

final class DoctrineProductQuery implements ProductQuery
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function find(ProductQueryInput $input): array
    {
        $productFields = DoctrineFieldsHelper::buildFields(
            '',
            'product',
            [
                'productId',
                'name',
                'description',
                'price',
            ]
        );

        $categoryFields = 'category.category_id as categoryId, category.name as categoryName';

        $queryBuilder = $this
            ->connection
            ->createQueryBuilder()
            ->select($productFields)
            ->addSelect($categoryFields)
            ->from(
                'product',
                'product'
            )
            ->leftJoin(
                'product',
                'category',
                'category',
                'category.category_id = product.category_id'
            )
        ;

        if (false === empty($input->name)) {
            $queryBuilder->where('product.name LIKE :name')
                ->setParameter(
                    'name',
                    '%' . $input->name . '%'
                );
        }

        if (false === empty($input->categoriesIds)) {
            $queryBuilder->where('category.category_id IN (:categoriesIds)')
                ->setParameter(
                    'categoriesIds',
                    $input->categoriesIds,
                    Connection::PARAM_STR_ARRAY
                );
        }


        return ProductQueryProductOutput::fromCollection(
            $queryBuilder->executeQuery()->fetchAllAssociative()
        );
    }
}