<?php

namespace Eborio\LaravelResponses\Enums;

/**
 * Semantic status strings used in the JSON payloads.
 *
 * These are high-level states that correspond to groups of HTTP codes.
 */
enum Status: string
{
    /** Indicates a successful response. */
    case OK = 'OK';

    /** Indicates a server failure or critical error. */
    case FAILED = 'FAILED';

    /** Indicates a client or non-server error. */
    case ERROR = 'ERROR';
}
