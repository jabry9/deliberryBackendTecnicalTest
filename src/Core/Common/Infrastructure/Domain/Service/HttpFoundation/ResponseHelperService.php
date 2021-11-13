<?php


namespace DeliberryAPI\Core\Common\Infrastructure\Domain\Service\HttpFoundation;


use DeliberryAPI\Core\Event\Domain\Model\DomainEvent;
use DeliberryAPI\Core\Event\Domain\Model\DomainEventFailure;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ResponseHelperService
{
    public static function fromFailureDomainEvents(int $httpCode, DomainEvent ...$domainEvents): JsonResponse
    {
        $reasons = [];
        foreach ($domainEvents as $domainEvent) {
            if ($domainEvent instanceof DomainEventFailure) {
                $httpCode = JsonResponse::HTTP_CONFLICT;
                foreach ($domainEvent->reasons() as $reason) {
                    $reasons[] = [
                        'reasonText' => $reason->reasonText(),
                        'reasonCode' => $reason->code(),
                        'reasonContent' => $reason->content(),
                    ];
                }

            }
        }

        return new JsonResponse(0 === count($reasons) ? null : $reasons, $httpCode);
    }
}