<?php


namespace DeliberryAPI\Core\Common\Infrastructure\Domain\Service\Php;


use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use DeliberryAPI\Core\Common\Domain\Service\DateTimeService;

final class PhpDateTimeService implements DateTimeService
{
    public function currentDateTime(): DateTimeInterface
    {
        return new DateTimeImmutable('now', new DateTimeZone('UTC'));
    }
}