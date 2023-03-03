<?php

namespace App\Repositories\Traits;

use App\Models\User;

trait TraitRepository {

    private function getUserAuth (): User {
        return User::first();
    }
}