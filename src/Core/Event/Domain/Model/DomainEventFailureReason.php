<?php


namespace DeliberryAPI\Core\Event\Domain\Model;


final class DomainEventFailureReason
{
    public const REASON_TEXT = 'reasonText';
    public const REASON_CODE = 'reasonCode';
    public const REASON_CONTENT = 'reasonContent';

    private function __construct(private string $reasonText, private string $code, private array $content)
    {
    }

    public static function fromArray(array $reason): self
    {
        return new self(
            $reason[self::REASON_TEXT],
            $reason[self::REASON_CODE],
            $reason[self::REASON_CONTENT] ?? []
        );
    }

    public function reasonText(): string
    {
        return $this->reasonText;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function content(): array
    {
        return $this->content;
    }

}