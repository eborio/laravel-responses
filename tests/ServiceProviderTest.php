<?php

use Eborio\LaravelResponses\ServiceProvider;
use PHPUnit\Framework\TestCase;

class ServiceProviderTest extends TestCase
{
    public function test_register_macros_runs_without_errors()
    {
        $provider = new ServiceProvider(null);

        // Ensure method runs without throwing
        $provider->registerMacros();

        $this->assertTrue(true);
    }

    public function test_responsefactory_has_macro_method()
    {
        if (! class_exists(\Illuminate\Routing\ResponseFactory::class)) {
            $this->assertTrue(true);
            return;
        }

        $this->assertTrue(method_exists(\Illuminate\Routing\ResponseFactory::class, 'macro'));
    }
}
