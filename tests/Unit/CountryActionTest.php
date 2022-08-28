<?php

namespace Tests\Unit;

use App\Actions\CountriesAction;
use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class CountryActionTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $action = new CountriesAction;
        $this->assertEquals(count($action->execute()), Country::all()->count());
    }
}
