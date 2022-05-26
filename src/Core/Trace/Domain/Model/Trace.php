<?php


namespace DeliberryAPI\Core\Trace\Domain\Model;


final class Trace
{

    public function __construct(
        private string $traceId,
        private readonly string $correlationId,
        private string $causationId
    )
    {
    }

    public function traceId(): string
    {
        return $this->traceId;
    }

    public function withTraceId(string $traceId): self
    {
        $clone = clone $this;
        $clone->traceId = $traceId;
        return $clone;
    }

    public function correlationId(): string
    {
        return $this->correlationId;
    }

    public function causationId(): string
    {
        return $this->causationId;
    }

    public function withCausationId(string $causationId): self
    {
        $clone = clone $this;
        $clone->causationId = $causationId;
        return $clone;
    }


}