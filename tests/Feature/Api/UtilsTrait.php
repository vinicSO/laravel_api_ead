<?php

namespace Tests\Feature\Api;

use App\Models\User;

trait UtilsTrait
{

    public function createTokenUser () {

        $user = User::factory()->create();
        $token = $user->createToken('teste')->plainTextToken;

        return $token;
    }

    public function defaultAuthorizedHeaders () {

        $token = $this->createTokenUser();

        return [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ];
    }

    public function defaultUnauthorizedHeaders () {

        return [
            'Accept' => 'application/json'
        ];
    }
}

