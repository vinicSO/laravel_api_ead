<?php

namespace Tests\Feature\Api;

use App\Models\Lesson;
use Tests\TestCase;

class ViewTest extends TestCase
{

    use UtilsTrait;

    public function test_make_viewed_unauthenticated()
    {

        $lesson = Lesson::factory()->create();

        $response = $this->postJson('/lessons/viewed', [
            'lesson' => $lesson->id
        ], $this->defaultUnauthorizedHeaders());

        $response->assertStatus(401);
    }

    public function test_make_viewed_error_validator()
    {

        $response = $this->postJson('/lessons/viewed', [], $this->defaultAuthorizedHeaders());

        $response->assertStatus(422);
    }

    public function test_make_viewed_invalid_lesson()
    {

        $response = $this->postJson('/lessons/viewed', [
            'lesson' => 'fake_id'
        ], $this->defaultAuthorizedHeaders());

        $response->assertStatus(422);
    }

    public function test_make_viewed()
    {

        $lesson = Lesson::factory()->create();

        $response = $this->postJson('/lessons/viewed', [
            'lesson' => $lesson->id
        ], $this->defaultAuthorizedHeaders());

        $response->assertStatus(200);
    }
}
