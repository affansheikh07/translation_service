<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Translation;


class TranslationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_translation(){
        
        $translation = Translation::create([
            'locale' => 'en',
            'key' => 'welcome_message',
            'content' => 'Welcome to the app',
            'tags' => ['web'],
        ]);

        $this->assertDatabaseHas('translations', [
            'locale' => 'en',
            'key' => 'welcome_message',
            'content' => 'Welcome to the app',
        ]);

        $this->assertEquals(['web'], $translation->tags);
    }

    /** @test */
    public function it_can_find_a_translation_by_key(){

        $translation = Translation::create([
            'locale' => 'en',
            'key' => 'welcome_message',
            'content' => 'Welcome to the app',
            'tags' => ['web'],
        ]);

        $foundTranslation = Translation::where('key', 'welcome_message')->first();

        $this->assertNotNull($foundTranslation);
        $this->assertEquals('en', $foundTranslation->locale);
        $this->assertEquals('Welcome to the app', $foundTranslation->content);
    }

    /** @test */
    public function it_can_update_a_translation(){

        $translation = Translation::create([
            'locale' => 'en',
            'key' => 'welcome_message',
            'content' => 'Welcome to the app',
            'tags' => ['web'],
        ]);

        $translation->update([
            'content' => 'Welcome to the updated app',
            'tags' => ['web', 'mobile'],
        ]);

        $this->assertDatabaseHas('translations', [
            'key' => 'welcome_message',
            'content' => 'Welcome to the updated app',
        ]);

        $this->assertEquals(['web', 'mobile'], $translation->tags);
    }

    /** @test */
    public function it_can_delete_a_translation(){

        $translation = Translation::create([
            'locale' => 'en',
            'key' => 'welcome_message',
            'content' => 'Welcome to the app',
            'tags' => ['web'],
        ]);

        $translation->delete();

        $this->assertDatabaseMissing('translations', [
            'key' => 'welcome_message',
        ]);
    }
}
