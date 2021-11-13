<?php


namespace DeliberryAPI\Core\Common\Domain\Service;


use DateTimeInterface;

interface DateTimeService
{
    public const DEFAULT_FORMAT_DATE = 'Y-m-d H:i:s';
    public function currentDateTime(): DateTimeInterface;
}