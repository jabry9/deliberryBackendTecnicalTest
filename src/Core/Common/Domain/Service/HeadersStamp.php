<?php


namespace DeliberryAPI\Core\Common\Domain\Service;


use Symfony\Component\Messenger\Stamp\StampInterface;

final class HeadersStamp implements StampInterface
{
    public function __construct(private array $headers)
    {
    }

    public function headers(): array
    {
        return $this->headers;
    }

}