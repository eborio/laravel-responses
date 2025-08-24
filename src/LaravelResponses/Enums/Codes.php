<?php

namespace Eborio\LaravelResponses\Enums;

/**
 * HTTP status codes used by the responses package.
 *
 * Each enum case maps to the numeric HTTP status code returned in responses.
 */
enum Codes: int
{
    /** Successful request. */
    case OK = 200;

    /** Authentication required or invalid credentials. */
    case UNAUTHENTICATED = 401;

    /** Authenticated but not authorized to access resource. */
    case FORBIDDEN = 403;

    /** Resource not found. */
    case NOT_FOUND = 404;

    /** Validation failed for the provided input. */
    case VALIDATION_ERRORS = 422;

    /** Internal server error. */
    case FAILED = 500;

    /** Service unavailable due to maintenance or overload. */
    case MAINTENANCE = 503;

    /**
     * Map an arbitrary HTTP code to a semantic Status enum.
     *
     * @param int $code
     * @return Status
     */
    public static function statusFromHttpCode(int $code): Status
    {
        if ($code >= 200 && $code < 300) {
            return Status::OK;
        }

        if ($code >= 500) {
            return Status::FAILED;
        }

        return Status::ERROR;
    }

    /**
     * Instance helper: map this enum case to a semantic Status.
     *
     * @return Status
     */
    public function toStatus(): Status
    {
        return self::statusFromHttpCode($this->value);
    }
}
