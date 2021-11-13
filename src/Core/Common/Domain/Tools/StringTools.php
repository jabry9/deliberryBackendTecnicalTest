<?php


namespace DeliberryAPI\Core\Common\Domain\Tools;


final class StringTools
{
    public static function camelCaseToSnakeCase(string $input): string
    {
        $pattern = '/([a-z])([A-Z])/';

        return preg_match( '/[A-Z]/', $input) === 0
            ? $input
            : strtolower(
                preg_replace_callback($pattern, function ($a) {
                    return $a[1] . "_" . strtolower($a[2]);
                },
                    $input
                )
            );
    }

}