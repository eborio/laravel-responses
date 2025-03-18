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
    protected string $errorMessage;

    /**
     * Responses constructor
     *
     * @param int $httpCode
     * @param array $data
     * @param string $errorMessage
     */
    public function __construct(int $httpCode, array $data = [], string $errorMessage = '')
    {
        $this->httpCode = $httpCode;
        $this->data = $data;
        $this->errorMessage = $errorMessage;
    }

    /**
     * Response format
     *
     * @param $request
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        $message = $data['title'] ?? $this->errorMessage;
        $payload = ['data' => $this->data];

        if ($this->httpCode >= 400) {
            $payload = array_merge($payload, ['error_message' => $message]);
        }

        return response()->json(
            data: $payload,
            status: $this->httpCode,
            options: JSON_UNESCAPED_UNICODE
        );
    }

    /**
     * Failed response
     *
     * @param string $errorMessage
     * @return static
     */
    public static function failed(string $errorMessage = 'Server error'): static
    {
        return new static(Codes::FAILED->value, errorMessage: $errorMessage);
    }

    /**
     * Forbidden response
     *
     * @param array $data
     * @param string $errorMessage
     * @return static
     */
    public static function forbidden(array $data, string $errorMessage = 'Forbidden resource'): static
    {
        return new static(Codes::FORBIDDEN->value, $data, errorMessage: $errorMessage);
    }

    /**
     * Not found response
     *
     * @param string $errorMessage
     * @return static
     */
    public static function notFound(string $errorMessage = 'Item not found'): static
    {
        return new static(Codes::NOT_FOUND->value, errorMessage: $errorMessage);
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
     * @param string $errorMessage
     * @return static
     */
    public static function unauthenticated(string $errorMessage = 'Unauthenticated user'): static
    {
        return new static(Codes::UNAUTHENTICATED->value, errorMessage: $errorMessage);
    }

    /**
     * Validation errors
     *
     * @param array $data
     * @param string $errorMessage
     * @return static
     */
    public static function validationErrors(array $data, string $errorMessage = 'Incomplete form'): static
    {
        return new static(Codes::VALIDATION_ERRORS->value, $data, errorMessage: $errorMessage);
    }
}