<?php


namespace DeliberryAPI\Core\Common\Domain\Service;


use DeliberryAPI\Core\Common\Domain\Tools\ArrayTools;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

final class Serializer implements SerializerInterface
{
    public function decode(array $encodedEnvelope): Envelope
    {
        // TODO: Implement decode() method.
    }

    public function encode(Envelope $envelope): array
    {
        $headers = [];

        foreach ($envelope->all() as $stamp) {
            $stamp = current($stamp);
            if ($stamp instanceof HeadersStamp) {
                $headers += $stamp->headers();
            }
        }

        return [
            'body' => json_encode(
                ArrayTools::objectToArray(
                    $envelope->getMessage()
                )
            ),
            'headers' => $headers,
        ];
    }
}