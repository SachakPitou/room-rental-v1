<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase; // Add this
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase; // Add this line

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}

