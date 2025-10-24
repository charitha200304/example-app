<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Inertia\Testing\AssertableInertia;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->withoutVite();
        
        // Set up Inertia testing
        $this->app->instance('inertia.testing.view-usage', true);
        $this->app->instance('inertia.testing.page', null);
        $this->app->instance('inertia.testing.component', null);
        $this->app->instance('inertia.testing.props', []);
    }
    
    /**
     * Assert that the response is an Inertia response.
     */
    protected function assertInertia(callable $callback = null): self
    {
        $assert = AssertableInertia::fromTestResponse($this);
        
        if ($callback) {
            $callback($assert);
        }
        
        return $this;
    }
}
