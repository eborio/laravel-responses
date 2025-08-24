<?php

use Eborio\LaravelResponses\Responses;
use Eborio\LaravelResponses\Enums\Codes;
use PHPUnit\Framework\TestCase;

class ResponsesTest extends TestCase
{
    public function test_ok_returns_expected_payload()
    {
        $response = Responses::ok(['foo' => 'bar'])->toResponse(null);
        $payload = json_decode($response->getContent(), true);

        $this->assertSame('OK', $payload['status']);
        $this->assertSame(Codes::OK->value, $payload['code']);
        $this->assertSame('bar', $payload['data']['foo']);
    }

    public function test_validation_errors_preserve_data()
    {
        $errors = ['email' => ['The email field is required.']];
    $response = Responses::validationErrors(['errors' => $errors])->toResponse(null);
    $payload = json_decode($response->getContent(), true);

    $this->assertSame(Codes::VALIDATION_ERRORS->value, $payload['code']);
    $this->assertSame($errors, $payload['data']['errors']);
    }

    public function test_failed_returns_500()
    {
    $response = Responses::failed()->toResponse(null);
    $payload = json_decode($response->getContent(), true);

    $this->assertSame(Codes::FAILED->value, $payload['code']);
    }
}
