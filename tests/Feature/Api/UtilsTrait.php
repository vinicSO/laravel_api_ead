<?php

namespace Tests\Feature\Api;

use App\Models\User;

trait UtilsTrait
{

    public function createUser () {
        $user = User::factory()->create();

        return $user;
    }

    public function createTokenUser () {

        $user = $this->createUser();
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

