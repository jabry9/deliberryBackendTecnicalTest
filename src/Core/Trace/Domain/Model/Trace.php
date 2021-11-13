<?php


namespace DeliberryAPI\Core\Trace\Domain\Model;


final class Trace
{
    private string $traceId;
    private string $correlationId;
    private string $causationId;

    public function __construct(string $traceId, string $correlationId, string $causationId)
    {
        $this->traceId = $traceId;
        $this->correlationId = $correlationId;
        $this->causationId = $causationId;
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