<?php

namespace Tests\Feature\Api;

use App\Models\Course;
use App\Models\Module;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ModuleTest extends TestCase
{

    use UtilsTrait;

    public function test_fail_get_all_modules_unauthenticated ()
    {

        $course = Course::factory()->create();

        $response = $this->get('/courses/' . $course->id . '/modules', $this->defaultUnauthorizedHeaders());

        $response->assertStatus(401);
    }

    public function test_fail_get_all_modules_not_found ()
    {

        $response = $this->get('/courses/fake_id/modules', $this->defaultAuthorizedHeaders());

        $response->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }

    public function test_get_all_modules ()
    {

        $course = Course::factory()->create();

        $response = $this->get("/courses/{$course->id}/modules", $this->defaultAuthorizedHeaders());

        $response->assertStatus(200);
    }

    public function test_create_modules_to_course ()
    {

        $course = Course::factory()->create();

        Module::factory()->count(10)->create([
            'course_id' => $course->id
        ]);

        $response = $this->get("/courses/{$course->id}/modules", $this->defaultAuthorizedHeaders());

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data');
    }
}
