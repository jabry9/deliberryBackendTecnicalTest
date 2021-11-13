<?php

namespace DeliberryAPI\Core\Security\Application\Service;



use Namshi\JOSE\Base64\Base64Encoder;
use Namshi\JOSE\Base64\Base64UrlSafeEncoder;
use Namshi\JOSE\JWT;

final class JWTTool
{
    public static function generateFromString(?string $jwsTokenString): ?JWT
    {
        $jwsTokenString = $jwsTokenString ?? '';
        $encoder = strpbrk($jwsTokenString, '+/=') ? new Base64Encoder() : new Base64UrlSafeEncoder();

        $parts = explode('.', $jwsTokenString);

        if (false === (count($parts) === 3)) {
            return null;
        }

        $header = json_decode($encoder->decode($parts[0]), true);
        $payload = json_decode($encoder->decode($parts[1]), true);

        if (false === (is_array($header) && is_array($payload))) {
            return null;
        }

        return (new JWT($payload, $header))->setEncoder($encoder);
    }
}