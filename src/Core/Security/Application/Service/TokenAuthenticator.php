<?php

namespace DeliberryAPI\Core\Security\Application\Service;

use DeliberryAPI\Core\Session\Application\Service\SessionMemento;
use Namshi\JOSE\JWT;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;


class TokenAuthenticator extends AbstractAuthenticator
{
    private const HEADER_AUTHORIZATION = 'Authorization';
    private const HEADER_AUTHORIZATION_TYPE = 'Bearer';

    public function __construct(private readonly SessionMemento $sessionMemento)
    {
    }

    private function extractToken(Request $request): ?string
    {
        $prefix = self::HEADER_AUTHORIZATION_TYPE;
        $token = $request->headers->get(self::HEADER_AUTHORIZATION, null);

        if (false === empty($prefix)) {
            $headerParts = explode(' ', $token);

            $token = $headerParts[1] ?? null;
        }

        return $token;
    }


    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): JsonResponse
    {
        return new JsonResponse(
            [
                'message' => $exception->getMessage(),
                'code' => Response::HTTP_UNAUTHORIZED
            ],
            Response::HTTP_UNAUTHORIZED
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $this->sessionMemento->withUser($token->getUser());
        return null;
    }

    public function supports(Request $request): ?bool
    {
        return true;
    }

    public function authenticate(Request $request): Passport|JWT
    {
        $jsonWebToken = $this->extractToken($request);

        if (empty($jsonWebToken)) {
            throw new CustomUserMessageAuthenticationException('The token is an invalid');
        }

        $preAuthToken = JWTTool::generateFromString($jsonWebToken);


        $validators = [
            is_null($preAuthToken),
            empty($preAuthToken->getPayload()),
            false === array_key_exists('sub', $preAuthToken->getPayload())
        ];

        if (in_array(true, $validators)) {
            throw new CustomUserMessageAuthenticationException('The token is an invalid');
        }

        return new SelfValidatingPassport(new UserBadge($preAuthToken->getPayload()['sub']));
    }

}