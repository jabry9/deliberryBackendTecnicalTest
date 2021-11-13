<?php

namespace DeliberryAPI\Core\Security\Application\Service;

use DeliberryAPI\Core\Session\Application\Service\SessionMemento;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;


final class TokenAuthenticator extends AbstractGuardAuthenticator
{
    private const HEADER_AUTHORIZATION = 'Authorization';
    private const HEADER_AUTHORIZATION_TYPE = 'Bearer';

    public function __construct(private SessionMemento $sessionMemento)
    {
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new JsonResponse(
            [
                'message' => $message = ($authException ? $authException->getMessage() : 'Authentication Required'),
                'error_code' => strtoupper(hash('adler32', $message, FALSE))
            ],
            Response::HTTP_UNAUTHORIZED
        );
    }

    public function supports(Request $request)
    {
        return true;
    }

    public function getCredentials(Request $request)
    {
        $jsonWebToken = $this->extractToken($request, self::HEADER_AUTHORIZATION, self::HEADER_AUTHORIZATION_TYPE);

        if (empty($jsonWebToken)) {
            throw new CustomUserMessageAuthenticationException('The token is an invalid');
        }

        $preAuthToken = JWTTool::generateFromString($jsonWebToken);

        if (is_null($preAuthToken) || empty($preAuthToken->getPayload())) {
            throw new CustomUserMessageAuthenticationException('The token is an invalid');
        }

        return $preAuthToken;
    }


    private function extractToken(Request $request, string $name, ?string $prefix): ?string
    {
        $token = $request->headers->get($name, null);

        if (false === empty($prefix)) {
            $headerParts = explode(' ', $token);

            if (!(2 === count($headerParts) && $headerParts[0] === $prefix)) {
                $token = null;
            }

            $token = $headerParts[1] ?? null;
        }

        return $token;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByUsername($credentials->getPayload()['sub']);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse(
            [
                'message' => $exception->getMessage(),
                'code' => Response::HTTP_UNAUTHORIZED
            ],
            Response::HTTP_UNAUTHORIZED
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        $this->sessionMemento->withUser($token->getUser());
    }

    public function supportsRememberMe()
    {
        return false;
    }

}