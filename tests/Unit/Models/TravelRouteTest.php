<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\TravelRoute;

class TravelRouteTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testfindCheapestRoute()
    {
        $travelRoute = new TravelRoute();

        $this->assertEquals([
            'route' => 'GRU,BRC,SCL',
            'price' => 15
        ], $travelRoute->findCheapestRoute('GRU', 'SCL'));
    }
}
