<?php

namespace Tests\Feature;

use App\Http\Requests\CarAveragePriceRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_car_average_price()
    {

        $response = $this->json('get', 'api/get-car-average-price', ['mark' => 96, 'model' => 12, 'year' => 2012]);

        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'mark_alias',
                'model_alias',
                'nbTotal',
                'price',
                'title'
            ]
        ]);
    }
}
