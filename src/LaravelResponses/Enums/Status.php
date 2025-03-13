<?php

namespace Eborio\LaravelResponses\Enums;

enum Status: string
{
    case OK = 'OK';

    case FAILED = 'FAILED';

    case ERROR = 'ERROR';
}
