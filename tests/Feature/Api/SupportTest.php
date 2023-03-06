<?php

namespace Tests\Feature\Api;

use App\Models\Lesson;
use App\Models\Support;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SupportTest extends TestCase
{

    use UtilsTrait;

    public function test_get_fail_my_supports_unauthorized ()
    {

        $response = $this->getJson('/supports/my', $this->defaultUnauthorizedHeaders());

        $response->assertStatus(401);
    }

    public function test_get_my_supports ()
    {

        $user = $this->createUser();
        $token = $user->createToken('teste')->plainTextToken;

        Support::factory()->count(50)->create([
            'user_id' => $user->id
        ]);

        Support::factory()->count(50)->create();

        $response = $this->getJson('/supports/my', [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(200)
            ->assertJsonCount(50, 'data');
    }

    public function test_get_fail_supports_unauthenticated ()
    {

        $response = $this->getJson('/supports', $this->defaultUnauthorizedHeaders());

        $response->assertStatus(401);
    }

    public function test_get_supports ()
    {

        Support::factory()->count(50)->create();

        $response = $this->getJson('/supports', $this->defaultAuthorizedHeaders());

        $response->assertStatus(200)
            ->assertJsonCount(50, 'data');
    }

    public function test_get_supports_filtered_by_lesson ()
    {

        $lesson = Lesson::factory()->create();

        Support::factory()->count(50)->create();
        Support::factory()->count(10)->create([
            'lesson_id' => $lesson->id
        ]);

        $response = $this->json('GET', '/supports', [
            'lesson' => $lesson->id
        ], $this->defaultAuthorizedHeaders());

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data');
    }

    public function test_fail_create_support_unauthenticated ()
    {

        $response = $this->postJson('/supports', [], $this->defaultUnauthorizedHeaders());

        $response->assertStatus(401);
    }

    public function test_fail_create_support_error_validations ()
    {

        $response = $this->postJson('/supports', [], $this->defaultAuthorizedHeaders());

        $response->assertStatus(422);
    }

    public function test_create_support ()
    {

        $lesson = Lesson::factory()->create();

        $response = $this->postJson('/supports', [
            'lesson' => $lesson->id,
            'status' => 'A',
            'description' => 'Lorem ipsu'
        ], $this->defaultAuthorizedHeaders());

        $response->assertStatus(201);
    }
}
