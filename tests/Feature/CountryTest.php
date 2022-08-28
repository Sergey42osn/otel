<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CountryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_countries()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/api/countries');
        $response->assertStatus(200);
    }
    public function test_filter_cities()
    {
        $response = $this->post('/api/filter-cities?country_id=1');
        $response->assertStatus(200);
    }
}
