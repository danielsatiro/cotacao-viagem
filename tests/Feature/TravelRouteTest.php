<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Generator;
use Tests\TestCase;

class TravelRouteTest extends TestCase
{
    /**
     * @dataProvider getDataRoutes
     * @small
     */
    public function testPostRoute(array $data, int $statusCode, array $responseTest)
    {
        $response = $this->postJson('/api/route', $data);

        $response->assertStatus($statusCode)
                ->assertExactJson($responseTest);
    }

    public function getDataRoutes(): Generator
    {
        yield from $this->getData('valid_route');
        yield from $this->getData('invalid_route');
    }

    private function getData(string $file): array
    {
        $data = json_decode(file_get_contents(__DIR__ . "/data/{$file}.json"), true);

        return [
            "data/{$file}.json" => [
                'data' => $data['request']['body'],
                'statusCode' => $data['response']['statusCode'],
                'responseBody' => $data['response']['body'],
            ],
        ];
    }

    public function testGetQuote()
    {
        $response = $this->getJson('/api/quote/GRU/BRC');

        $response->assertStatus(200)
                ->assertExactJson([
                    'route' => 'GRU,BRC',
                    'price' => 10
                ]);
    }
    public function testGetQuoteNotFound()
    {
        $response = $this->getJson('/api/quote/GRU/ZZZ');

        $response->assertStatus(404);
    }
}
