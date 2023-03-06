<?php

namespace Tests\Feature\Api;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LessonTest extends TestCase
{

    use UtilsTrait;

    public function test_fail_get_all_lessons_unauthenticated ()
    {

        $module = Module::factory()->create();

        $response = $this->get('/modules/' . $module->id . '/lessons', $this->defaultUnauthorizedHeaders());

        $response->assertStatus(401);
    }

    public function test_fail_get_all_lessons_not_found ()
    {

        $response = $this->get('/modules/fake_id/lessons', $this->defaultAuthorizedHeaders());

        $response->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }

    public function test_get_all_lessons ()
    {

        $course = Course::factory()->create();

        $response = $this->get("/modules/{$course->id}/lessons", $this->defaultAuthorizedHeaders());

        $response->assertStatus(200);
    }

    public function test_get_all_lessons_of_module_total ()
    {

        $module = Module::factory()->create();

        Lesson::factory()->count(10)->create([
            'module_id' => $module->id
        ]);

        $response = $this->get("/modules/{$module->id}/lessons", $this->defaultAuthorizedHeaders());

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data');
    }

    public function test_fail_get_single_lesson_unauthenticated ()
    {

        $lesson = Lesson::factory()->create();

        $response = $this->get("/lessons/{$lesson->id}", $this->defaultUnauthorizedHeaders());

        $response->assertStatus(401);
    }

    public function test_fail_get_single_lesson_not_found ()
    {

        $response = $this->get("/lessons/fake_id", $this->defaultAuthorizedHeaders());

        $response->assertStatus(404);
    }

    public function test_get_single_lesson ()
    {

        $lesson = Lesson::factory()->create();

        $response = $this->get("/lessons/{$lesson->id}", $this->defaultAuthorizedHeaders());

        $response->assertStatus(200);
    }
}
