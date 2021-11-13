<?php


namespace DeliberryAPI\Core\Common\Infrastructure\Domain\Service\HttpFoundation;


use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class RequestHelperService
{
    public static function requestRequiredParameter(Request $request, string $parameterName)
    {
        if (str_contains($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : []);
        }

        return $request->request->get($parameterName)
            ?? throw new BadRequestException(
                "Parameter $parameterName is required",
                Response::HTTP_PRECONDITION_FAILED
            );
    }

    public static function requestParameter(Request $request, string $parameterName, ?callable $formatter = null)
    {
        if (str_contains($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : []);
        }

        $value = $request->request->get($parameterName);
        return $value && $formatter ? $formatter($value) : $value;
    }

    public static function queryParameter(Request $request, string $parameterName, ?callable $formatter = null)
    {
        $value = $request->query->get($parameterName);
        return null !== $value && $formatter ? $formatter($value) : $value;
    }
}