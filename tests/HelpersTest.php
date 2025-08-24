<?php

use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
{
    public function test_helpers_functions_exist()
    {
        $this->assertTrue(function_exists('laravel_responses_ok'));
        $this->assertTrue(function_exists('laravel_responses_failed'));
        $this->assertTrue(function_exists('laravel_responses_validation_errors'));
    }
}
