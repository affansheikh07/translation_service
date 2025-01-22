<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Translation;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

class TranslationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_export_translations(){
        
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    Translation::factory()->create([
        'locale' => 'en',
        'key' => 'welcome_message',
        'content' => 'Welcome to the app',
        'tags' => ['web'],
    ]);

    $response = $this->getJson('/api/translations/export?locale=en');

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'current_page',
        'data' => [
            '*' => ['id', 'tags', 'locale', 'key', 'content'],
        ],
        'first_page_url',
        'from',
        'last_page',
        'last_page_url',
        'links',
        'next_page_url',
        'path',
        'per_page',
        'prev_page_url',
        'to',
        'total',
    ]);

    }
}
