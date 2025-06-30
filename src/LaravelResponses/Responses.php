<?php

namespace Eborio\LaravelResponses;

use Eborio\LaravelResponses\Enums\Codes;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class Responses implements Responsable
{
    /**
     * @var int
     */
    protected int $httpCode;

    /**
     * @var array
     */
    protected array $data;

    /**
     * @var string
     */
    protected string $title;

    /**
     * Responses constructor
     *
     * @param int $httpCode
     * @param array $data
     * @param string $title
     */
    public function __construct(int $httpCode, array $data = [], string $title = '')
    {
        $this->httpCode = $httpCode;
        $this->data = $data;
        $this->title = $title;
    }

    /**
     * Response format
     *
     * @param $request
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        $this->data['title'] = $this->data['title'] ?? $this->title;
        $payload = ['data' => $this->data];

        return response()->json(
            data: $payload,
            status: $this->httpCode,
            options: JSON_UNESCAPED_UNICODE
        );
    }

    /**
     * Failed response
     *
     * @param array $data
     * @param string $title
     * @return static
     */
    public static function failed(array $data = [], string $title = 'Server error'): static
    {
        return new static(Codes::FAILED->value, title: $title);
    }

    /**
     * Forbidden response
     *
     * @param array $data
     * @param string $title
     * @return static
     */
    public static function forbidden(array $data = [], string $title = 'Forbidden resource'): static
    {
        return new static(Codes::FORBIDDEN->value, $data, title: $title);
    }

    /**
     * Not found response
     *
     * @param array $data
     * @param string $title
     * @return static
     */
    public static function notFound(array $data = [], string $title = 'Item not found'): static
    {
        return new static(Codes::NOT_FOUND->value, $data, title: $title);
    }

    /**
     * OK response
     *
     * @param array $data
     * @return static
     */
    public static function ok(array $data): static
    {
        return new static(Codes::OK->value, $data);
    }

    /**
     * Unauthenticated response
     *
     * @param array $data
     * @param string $title
     * @return static
     */
    public static function unauthenticated(array $data = [], string $title = 'Unauthenticated user'): static
    {
        return new static(Codes::UNAUTHENTICATED->value, title: $title);
    }

    /**
     * Validation errors
     *
     * @param array $data
     * @param string $title
     * @return static
     */
    public static function validationErrors(array $data = [], string $title = 'Incomplete form'): static
    {
        return new static(Codes::VALIDATION_ERRORS->value, $data, title: $title);
    }
}