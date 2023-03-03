<?php

namespace App\Repositories;

use App\Models\Support;
use App\Models\User;

class SupportRepository {

    protected $entity;

    public function __construct(Support $model) {
        $this->entity = $model;
    }

    public function getSupports (array $filters = []) {
        return $this->getUserAuth()->supports()->where(function ($query) use($filters) {
            if(isset($filters['lesson'])) {
                $query->where('lesson_id', $filters['lesson']);
            }

            if(isset($filters['status'])) {
                $query->where('status', $filters['status']);
            }

            if(isset($filters['filter'])) {

                $filter = $filters['filter'];

                $query->where('description', 'LIKE', "%{$filter}%");
            }
        })->get();
    }

    public function getUserAuth (): User {
        // return auth()->user();

        return User::first();
    }

    public function getSupport (string $identifySupport) {
        return $this->entity->findOrFail($identifySupport);
    }

    public function createNewSupport (array $data): Support {
        $new_support = $this->getUserAuth()->supports()->create([
            'lesson_id' => $data['lesson'],
            'description' => $data['description'],
            'status' => $data['status']
        ]);

        return $new_support;
    }

    public function createReplyToSupport(string $supportId, array $data) {

        $user = $this->getUserAuth();

        $reply = $this->getSupport($supportId)->replies()->create([
            'description' => $data['description'],
            'user_id' => $user->id
        ]);

        return $reply;
    }

}