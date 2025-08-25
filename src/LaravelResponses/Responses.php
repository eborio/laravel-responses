<?php

namespace Eborio\LaravelResponses;

use Eborio\LaravelResponses\Enums\Codes;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

/**
 * Class Responses
 *
 * Build standardized JSON API responses that implement the Laravel
 * Responsible contract. The response payload follows the package
 * convention: [status, code, message, data].
 */
class Responses implements Responsable
{
    /**
     * HTTP status represented as a {@see Codes} enum instance.
     *
     * @var Codes
     */
    protected Codes $httpCode;

    /**
     * Response data payload. If the array contains a "message" key it
     * will be used as the message and removed from the data section.
     *
     * @var array
     */
    protected array $data;

    /**
     * Message to expose as the response message.
     *
     * @var string
     */
    protected string $message;

    /**
     * Create a new Responses instance.
     *
     * Accepts either an integer HTTP status code or a {@see Codes}
     * enum case. The provided data and message are stored and used when
     * building the final JSON payload.
     *
     * @param int|Codes $httpCode HTTP status code or Codes enum case
     * @param array $data Response payload data
     * @param string $message Optional message
     */
    public function __construct(int|Codes $httpCode, array $data = [], string $message = '')
    {
        $this->httpCode = $httpCode instanceof Codes ? $httpCode : Codes::from($httpCode);
        $this->data = $data;
        if ($message === '') {
            try {
                $defaultMessages = config('laravel-responses.default_messages', []);
                $code = $this->httpCode->value;
                $this->message = $defaultMessages[$code] ?? $this->httpCode->getFriendlyName();
            } catch (\Throwable $e) {
                $this->message = $this->httpCode->getFriendlyName();
            }
        } else {
            $this->message = $message;
        }
    }

    /**
     * Create a server error response instance.
     *
     * This returns a {@see Responses} pre-configured with the
     * {@see Codes::FAILED} HTTP code.
     *
     * @param array $data Optional payload data
     * @param string $message Optional message
     * @return static A Responses instance configured as an error
     */
    public static function failed(array $data = [], string $message = 'Server error'): static
    {
        return new static(Codes::FAILED, $data, $message);
    }

    /**
     * Create a forbidden response instance.
     *
     * Returns a {@see Responses} configured with the
     * {@see Codes::FORBIDDEN} status.
     *
     * @param array $data Optional payload data
     * @param string $message Optional message
     * @return static A Responses instance configured as forbidden
     */
    public static function forbidden(array $data = [], string $message = 'Forbidden resource'): static
    {
        return new static(Codes::FORBIDDEN, $data, $message);
    }

    /**
     * Create a not found response instance.
     *
     * Returns a {@see Responses} configured with the
     * {@see Codes::NOT_FOUND} status.
     *
     * @param array $data Optional payload data
     * @param string $message Optional message
     * @return static A Responses instance configured as not found
     */
    public static function notFound(array $data = [], string $message = 'Item not found'): static
    {
        return new static(Codes::NOT_FOUND, $data, $message);
    }

    /**
     * Create a successful (OK) response instance.
     *
     * Returns a {@see Responses} configured with the {@see Codes::OK}
     * HTTP status.
     *
     * @param array $data Payload data to include in the response
     * @return static A Responses instance configured as OK
     */
    public static function ok(array $data): static
    {
        return new static(Codes::OK, $data);
    }

    /**
     * Build the response payload as an array.
     *
     * The resulting array follows the package schema and is intentionally
     * produced without relying on Laravel helpers to make it testable in
     * isolation.
     *
     * @return array The final JSON serializable payload
     */
    protected function toArray(): array
    {
        $message = $this->data['message'] ?? $this->message;
        $payloadData = $this->data['payload'] ?? $this->data;

        return [
            'status' => $this->httpCode->toStatus()->value,
            'code' => $this->httpCode->value,
            'message' => $message,
            'data' => $payloadData,
        ];
    }

    /**
     * Convert the response to a Laravel JsonResponse.
     *
     * This method implements the {@see Responsable} contract so
     * the object can be returned directly from controllers. It
     * attempts to read JSON encoding options from configuration but
     * falls back to a safe default when the config helper is not
     * available (for example, in isolated tests).
     *
     * @param mixed $request The incoming request instance (unused)
     * @return JsonResponse The HTTP JSON response
     */
    public function toResponse($request): JsonResponse
    {
        $payload = $this->toArray();

        try {
            $options = config('laravel-responses.json_options', JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $e) {
            $options = JSON_UNESCAPED_UNICODE;
        }

        return new JsonResponse($payload, $this->httpCode->value, [], $options);
    }

    /**
     * Create an unauthenticated response instance.
     *
     * Returns a {@see Responses} configured with the
     * {@see Codes::UNAUTHENTICATED} status.
     *
     * @param array $data Optional payload data
     * @param string $message Optional message
     * @return static A Responses instance configured as unauthenticated
     */
    public static function unauthenticated(array $data = [], string $message = 'Unauthenticated user'): static
    {
        return new static(Codes::UNAUTHENTICATED, $data, $message);
    }

    /**
     * Create a validation errors response instance.
     *
     * Returns a {@see Responses} configured with the
     * {@see Codes::VALIDATION_ERRORS} status and the provided
     * validation payload.
     *
     * @param array $data Validation errors or payload data
     * @param string $message Optional message title
     * @return static A Responses instance configured for validation errors
     */
    public static function validationErrors(array $data = [], string $message = 'Incomplete form'): static
    {
        return new static(Codes::VALIDATION_ERRORS, $data, $message);
    }
}