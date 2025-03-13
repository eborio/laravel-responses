<?php

namespace Eborio\LaravelResponses\Enums;

enum Codes: int
{
    case OK = 200;

    case UNAUTHENTICATED = 401;

    case FORBIDDEN = 403;

    case NOT_FOUND = 404;

    case VALIDATION_ERRORS = 422;

    case FAILED = 500;

    case MAINTENANCE = 503;
}
