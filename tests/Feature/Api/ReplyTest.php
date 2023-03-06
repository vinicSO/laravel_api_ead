<?php

namespace Tests\Feature\Api;

use App\Models\Support;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReplyTest extends TestCase
{

    use UtilsTrait;

    public function test_fail_create_reply_to_support_unauthorized ()
    {

        $support = Support::factory()->create();

        $response = $this->postJson('/replies', [
            'description' => 'Lorem ipsu',
            'support' => $support->id
        ], $this->defaultUnauthorizedHeaders());

        $response->assertStatus(401);
    }

    public function test_fail_create_reply_to_support_error_validations ()
    {

        $response = $this->postJson('/replies', [], $this->defaultAuthorizedHeaders());

        $response->assertStatus(422);
    }

    public function test_create_reply_to_support ()
    {

        $support = Support::factory()->create();

        $response = $this->postJson('/replies', [
            'description' => 'Lorem ipsu',
            'support' => $support->id
        ], $this->defaultAuthorizedHeaders());

        $response->assertStatus(201);
    }
}
