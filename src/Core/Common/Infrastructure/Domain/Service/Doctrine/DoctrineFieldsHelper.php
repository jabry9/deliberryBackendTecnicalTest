<?php

namespace DeliberryAPI\Core\Common\Infrastructure\Domain\Service\Doctrine;

use DeliberryAPI\Core\Common\Domain\Tools\StringTools;

final class DoctrineFieldsHelper
{
    public static function buildFields(string $context, string $table,array $fields): string
    {
        $stringReturned = '';

        foreach ($fields as $field) {
            $fieldToUpperCase = '' !== $context ? ucwords($field) : $field;
            $field = StringTools::camelCaseToSnakeCase($field);
            $stringReturned .= " $table.$field as $context$fieldToUpperCase,";
        }

        return rtrim($stringReturned,',');
    }
}