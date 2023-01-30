<?php

namespace App\Http\Responses;

use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * This class is used to format and send the API response
 * Its json response doesn't escape unicode characters, so it can handle translations well
 */
class ApiResponse
{
    /**
     * Make success response
     *
     * @param array|string $data = []
     *
     * @return Response
     * @throws BindingResolutionException
     */
    public static function success(array|string $data = ""): Response
    {
        $responseBody = [
            'data' => $data,
        ];
        $code = is_array($data) && count($data) ? 200 : 201;
        return self::buildResponse($responseBody, $code);
    }

    /**
     * Build a json response with the provided body and status code
     *
     * @param array|string $responseBody
     * @param int $code = 400
     *
     * @return Response
     * @throws BindingResolutionException
     */
    protected static function buildResponse(array|string $responseBody, int $code): Response
    {
        if (isset($responseBody['data']) && is_array($responseBody['data']) && $pagination = self::fixPagination($responseBody['data'])) {
            $responseBody['data']['pagination'] = $pagination;
        }
        return response()
            ->make(
                json_encode($responseBody, JSON_UNESCAPED_UNICODE),
                $code,
                ['Content-Type' => 'application/json']
            );
    }

    /**
     * @throws Exception
     */
    private static function fixPagination($data): array|\stdClass|null
    {
        $meta = null;
        foreach ($data as $resource) {
            if ($new_meta = self::resourceJsonPagination($resource)) {
                $meta = $new_meta;
            }
        }
        return $meta;

    }

    /**
     * Fixing the removal of pagination links when returning json
     *
     * @param object $resource
     * @param string $key
     *
     * @return array|null
     * @throws Exception
     */
    private static function resourceJsonPagination($resource, string $key = 'data'): ?array
    {
        if (!is_object($resource) || !property_exists($resource, 'resource') || ($resource->count() && !$resource->resource instanceof LengthAwarePaginator)) {

            return null;
        }
        if ($resource->resource instanceof LengthAwarePaginator) {
            return [
                'current_page' => $resource->currentPage(),
                'first_page_url' => $resource->url(1),
                'from' => $resource->firstItem(),
                'last_page' => $resource->lastPage(),
                'last_page_url' => $resource->url($resource->lastPage()),
                'next_page_url' => $resource->nextPageUrl(),
                'path' => $resource->path(),
                'per_page' => $resource->perPage(),
                'prev_page_url' => $resource->previousPageUrl(),
                'to' => $resource->lastItem(),
                'total' => $resource->total(),
            ];
        }
        return null;
    }

    /**
     * Make failure response
     *
     * @param array|string $messages = []
     * @param int $code = 400
     *
     * @return Response
     * @throws BindingResolutionException
     */
    public static function fail(array|string $messages = [], int $code = 400): Response
    {
        $responseBody = [];
        if (!empty($messages)) {
            $responseBody = [
                'messages' => $messages,
            ];
        }
        return self::buildResponse($responseBody, $code);
    }

    /**
     * Make UnAuthorized response
     *
     * @return Response
     * @throws BindingResolutionException
     */
    public static function unauthorized(array|string $messages = []): Response
    {
        $responseBody = [];
        if (!empty($messages)) {
            $responseBody = [
                'messages' => $messages,
            ];
        }
        return self::buildResponse($responseBody, 401);
    }

    /**
     * Make Forbidden response
     *
     * @return Response
     * @throws BindingResolutionException
     */
    public static function forbidden(array|string $messages = []): Response
    {
        $responseBody = [];
        if (!empty($messages)) {
            $responseBody = [
                'messages' => $messages,
            ];
        }
        return self::buildResponse($messages, 403);
    }
}
