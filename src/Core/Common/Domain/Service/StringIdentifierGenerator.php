<?php


namespace DeliberryAPI\Core\Common\Domain\Service;


interface StringIdentifierGenerator
{
    public function execute(): string;
}