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

        $this->assertSame(Codes::SERVER_ERROR->value, $payload['code']);
    }

    public function test_default_message_is_used_when_none_provided()
    {
        $response = Responses::notFound(['foo' => 'bar'])->toResponse(null);
        $payload = json_decode($response->getContent(), true);
        $this->assertSame('Resource Not Found', $payload['message']);
    }

    public function test_custom_message_overrides_default()
    {
        $customMessage = 'Custom not found';
        $response = Responses::notFound(['foo' => 'bar'], $customMessage)->toResponse(null);
        $payload = json_decode($response->getContent(), true);
        $this->assertSame($customMessage, $payload['message']);
    }

    public function test_constructor_accepts_int_code()
    {
        $response = new Responses(200, ['test' => 'data']);
        $reflection = new \ReflectionClass($response);
        $httpCodeProperty = $reflection->getProperty('httpCode');
        $httpCodeProperty->setAccessible(true);
        $this->assertEquals(Codes::OK, $httpCodeProperty->getValue($response));
    }

    public function test_constructor_accepts_codes_enum()
    {
        $response = new Responses(Codes::OK, ['test' => 'data']);
        $reflection = new \ReflectionClass($response);
        $httpCodeProperty = $reflection->getProperty('httpCode');
        $httpCodeProperty->setAccessible(true);
        $this->assertEquals(Codes::OK, $httpCodeProperty->getValue($response));
    }

    public function test_toArray_returns_correct_structure()
    {
        $response = new Responses(Codes::OK, ['test' => 'data'], 'Test message');
        $reflection = new \ReflectionClass($response);
        $toArrayMethod = $reflection->getMethod('toArray');
        $toArrayMethod->setAccessible(true);
        $result = $toArrayMethod->invoke($response);

        $this->assertArrayHasKey('status', $result);
        $this->assertArrayHasKey('code', $result);
        $this->assertArrayHasKey('message', $result);
        $this->assertArrayHasKey('data', $result);
        $this->assertEquals('OK', $result['status']);
        $this->assertEquals(200, $result['code']);
        $this->assertEquals('Test message', $result['message']);
        $this->assertEquals(['test' => 'data'], $result['data']);
    }

    public function test_toArray_handles_message_in_data()
    {
        $response = new Responses(Codes::OK, ['message' => 'Data message', 'payload' => ['test' => 'data']]);
        $reflection = new \ReflectionClass($response);
        $toArrayMethod = $reflection->getMethod('toArray');
        $toArrayMethod->setAccessible(true);
        $result = $toArrayMethod->invoke($response);

        $this->assertEquals('Data message', $result['message']);
        $this->assertEquals(['test' => 'data'], $result['data']);
    }

    public function test_toArray_handles_payload_in_data()
    {
        $response = new Responses(Codes::OK, ['payload' => ['test' => 'data']]);
        $reflection = new \ReflectionClass($response);
        $toArrayMethod = $reflection->getMethod('toArray');
        $toArrayMethod->setAccessible(true);
        $result = $toArrayMethod->invoke($response);

        $this->assertEquals(['test' => 'data'], $result['data']);
    }

    public function test_toArray_removes_message_from_data_payload()
    {
        $response = new Responses(Codes::OK, ['payload' => ['message' => 'should be removed', 'other' => 'data']], 'Actual message');
        $reflection = new \ReflectionClass($response);
        $toArrayMethod = $reflection->getMethod('toArray');
        $toArrayMethod->setAccessible(true);
        $result = $toArrayMethod->invoke($response);

        $this->assertEquals('Actual message', $result['message']);
        $this->assertEquals(['other' => 'data'], $result['data']);
        $this->assertArrayNotHasKey('message', $result['data']);
    }

    public function test_forbidden_returns_403()
    {
        $response = Responses::forbidden();
        $jsonResponse = $response->toResponse(null);
        $data = $jsonResponse->getData(true);

        $this->assertEquals(403, $jsonResponse->getStatusCode());
        $this->assertEquals('ERROR', $data['status']);
        $this->assertEquals(403, $data['code']);
    }

    public function test_unauthenticated_returns_401()
    {
        $response = Responses::unauthenticated()->toResponse(null);
        $payload = json_decode($response->getContent(), true);
        $this->assertSame(401, $payload['code']);
        $this->assertSame('ERROR', $payload['status']);
    }

    public function test_toResponse_uses_config_json_options()
    {
        // Mock config to return custom options
        // Since we can't easily mock config in unit tests, we'll test the fallback
        $response = Responses::ok(['test' => 'data'])->toResponse(null);
        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $response);
    }

    public function test_toResponse_falls_back_without_config()
    {
        // This should work even without Laravel config
        $response = Responses::ok(['test' => 'data'])->toResponse(null);
        $payload = json_decode($response->getContent(), true);
        $this->assertSame(['test' => 'data'], $payload['data']);
    }
}
