<?php


namespace DeliberryAPI\Core\Common\Domain\Tools;


use DeliberryAPI\Core\Common\Domain\Service\DateTimeService;

final class ArrayTools
{
    public static function arrayOfObjectsToArray(
        ?array $objects,
        ?string $formatDate = DateTimeService::DEFAULT_FORMAT_DATE,
        bool $snakeCase = false
    ): array {
        $arrayReturned = [];

        foreach ($objects as $object) {
            $arrayReturned[] = self::objectToArray($object, $formatDate, $snakeCase);
        }

        return $arrayReturned;
    }

    public static function objectToArray(
        $object,
        ?string $formatDate = DateTimeService::DEFAULT_FORMAT_DATE,
        bool $snakeCase = false
    )
    {
        $array = $object;

        if (is_object($object)) {
            $reflectionClass = new \ReflectionClass(get_class($object));
            $array = [];
            foreach ($reflectionClass->getProperties() as $property) {
                $property->setAccessible(true);
                $propertyName = $snakeCase
                    ? StringTools::camelCaseToSnakeCase($property->getName())
                    : $property->getName();

                $propertyValue = $property->getValue($object);
                $array[$propertyName] = $propertyValue;
                if (is_object($propertyValue) && false === $propertyValue instanceof \DateTimeInterface) {
                    $array[$propertyName] = self::objectToArray($propertyValue, $formatDate, $snakeCase);
                }

                if (is_object($propertyValue) && $propertyValue instanceof \DateTimeInterface) {
                    if (empty($formatDate)) {
                        $array[$propertyName] = self::objectToArray($propertyValue, $formatDate, $snakeCase);
                    }

                    if (false === empty($formatDate)) {
                        $array[$propertyName] = $propertyValue->format($formatDate);
                    }
                }

                if (is_array($propertyValue)) {
                    $array[$propertyName] = self::arrayOfObjectsToArray($propertyValue, $formatDate, $snakeCase);
                }
                $property->setAccessible(false);
            }
        }

        return $array;
    }



    public static function removeSpecialCharacters(array $data): array
    {
        $output = [];
        foreach ($data as $key => $item) {
            if (false === is_array($item) && is_string($item)) {
                $output[$key] = str_replace('"', '', $item);
            }
            if (false === is_array($item) && false === is_string($item)) {
                $output[$key] = $item;
            }
            if (is_array($item)) {
                $output[$key] = self::removeSpecialCharacters($item);
            }
        }

        return $output;
    }

    public static function arrayCastRecursive(array $array)
    {
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $array[$key] = self::arrayCastRecursive($value);
                }
                if ($value instanceof \stdClass) {
                    $array[$key] = self::arrayCastRecursive((array)$value);
                }
            }
        }
        if ($array instanceof \stdClass) {
            return self::arrayCastRecursive((array)$array);
        }
        return $array;
    }

    public static function arrayCompare($actual, $expected) {
        if (!is_array($expected) || !is_array($actual)) return $actual === $expected;
        foreach ($expected as $key => $value) {
            if (!self::arrayCompare($actual[$key], $expected[$key])) return false;
        }
        foreach ($actual as $key => $value) {
            if (!self::arrayCompare($actual[$key], $expected[$key])) return false;
        }
        return true;
    }
}