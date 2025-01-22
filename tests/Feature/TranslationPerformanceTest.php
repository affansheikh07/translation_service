<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class TranslationPerformanceTest extends TestCase
{
    private function getAuthToken(){
        
        $user = User::factory()->create(); 

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password', 
        ]);

        return $response->json('token'); 
    }


    public function test_all_endpoints_performance(){

        $token = $this->getAuthToken();

        $endpoints = [
            '/api/translations',
            '/api/translations/cache',
            '/api/translations/export?locale=en', 
        ];

        foreach ($endpoints as $endpoint) {
            $startTime = microtime(true); 

            $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->getJson($endpoint);

            $response->assertStatus(200);

            $responseTime = microtime(true) - $startTime;

            $this->assertLessThan(0.2, $responseTime, "Endpoint $endpoint response time exceeded 200ms");
        }
    }

    public function test_export_translations_performance(){

        $token = $this->getAuthToken();

        $startTime = microtime(true);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/translations/export?locale=en');

        $response->assertStatus(200);

        $responseTime = microtime(true) - $startTime;

        $this->assertLessThan(0.5, $responseTime, 'JSON export endpoint response time exceeded 500ms');
    }


    public function test_cache_translations_performance(){

        $token = $this->getAuthToken();

        $startTime = microtime(true);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/translations/cache');

        $response->assertStatus(200);

        $responseTime = microtime(true) - $startTime; 

        $this->assertLessThan(0.2, $responseTime, 'Cache endpoint response time exceeded 200ms');
    }
}
