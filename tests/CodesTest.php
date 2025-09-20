<?php

use Eborio\LaravelResponses\Enums\Codes;
use Eborio\LaravelResponses\Enums\Status;
use PHPUnit\Framework\TestCase;

class CodesTest extends TestCase
{
    public function test_statusFromHttpCode_maps_200_to_ok()
    {
        $this->assertSame(Status::OK, Codes::statusFromHttpCode(200));
    }

    public function test_statusFromHttpCode_maps_201_to_ok()
    {
        $this->assertSame(Status::OK, Codes::statusFromHttpCode(201));
    }

    public function test_statusFromHttpCode_maps_299_to_ok()
    {
        $this->assertSame(Status::OK, Codes::statusFromHttpCode(299));
    }

    public function test_statusFromHttpCode_maps_400_to_error()
    {
        $this->assertSame(Status::ERROR, Codes::statusFromHttpCode(400));
    }

    public function test_statusFromHttpCode_maps_404_to_error()
    {
        $this->assertSame(Status::ERROR, Codes::statusFromHttpCode(404));
    }

    public function test_statusFromHttpCode_maps_499_to_error()
    {
        $this->assertSame(Status::ERROR, Codes::statusFromHttpCode(499));
    }

    public function test_statusFromHttpCode_maps_500_to_failed()
    {
        $this->assertSame(Status::FAILED, Codes::statusFromHttpCode(500));
    }

    public function test_statusFromHttpCode_maps_503_to_failed()
    {
        $this->assertSame(Status::FAILED, Codes::statusFromHttpCode(503));
    }

    public function test_toStatus_maps_ok_to_ok()
    {
        $this->assertSame(Status::OK, Codes::OK->toStatus());
    }

    public function test_toStatus_maps_unauthenticated_to_error()
    {
        $this->assertSame(Status::ERROR, Codes::UNAUTHENTICATED_USER->toStatus());
    }

    public function test_toStatus_maps_forbidden_to_error()
    {
        $this->assertSame(Status::ERROR, Codes::FORBIDDEN_RESOURCE->toStatus());
    }

    public function test_toStatus_maps_not_found_to_error()
    {
        $this->assertSame(Status::ERROR, Codes::RESOURCE_NOT_FOUND->toStatus());
    }

    public function test_toStatus_maps_validation_errors_to_error()
    {
        $this->assertSame(Status::ERROR, Codes::VALIDATION_ERRORS->toStatus());
    }

    public function test_toStatus_maps_server_error_to_failed()
    {
        $this->assertSame(Status::FAILED, Codes::SERVER_ERROR->toStatus());
    }

    public function test_toStatus_maps_maintenance_to_failed()
    {
        $this->assertSame(Status::FAILED, Codes::MAINTENANCE->toStatus());
    }

    public function test_getFriendlyName_for_ok()
    {
        $this->assertSame('Ok', Codes::OK->getFriendlyName());
    }

    public function test_getFriendlyName_for_unauthenticated_user()
    {
        $this->assertSame('Unauthenticated User', Codes::UNAUTHENTICATED_USER->getFriendlyName());
    }

    public function test_getFriendlyName_for_forbidden_resource()
    {
        $this->assertSame('Forbidden Resource', Codes::FORBIDDEN_RESOURCE->getFriendlyName());
    }

    public function test_getFriendlyName_for_resource_not_found()
    {
        $this->assertSame('Resource Not Found', Codes::RESOURCE_NOT_FOUND->getFriendlyName());
    }

    public function test_getFriendlyName_for_validation_errors()
    {
        $this->assertSame('Validation Errors', Codes::VALIDATION_ERRORS->getFriendlyName());
    }

    public function test_getFriendlyName_for_server_error()
    {
        $this->assertSame('Server Error', Codes::SERVER_ERROR->getFriendlyName());
    }

    public function test_getFriendlyName_for_maintenance()
    {
        $this->assertSame('Maintenance', Codes::MAINTENANCE->getFriendlyName());
    }
}