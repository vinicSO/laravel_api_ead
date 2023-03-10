<?php

namespace App\Repositories;

use App\Models\Support;
use App\Repositories\Traits\TraitRepository;

class SupportRepository {

    use TraitRepository;

    protected $entity;

    public function __construct(Support $model) {
        $this->entity = $model;
    }

    public function getMySupports (array $filters = []) {

        $filters['user'] = true;

        return $this->getSupports($filters);
    }

    public function getSupports (array $filters = []) {
        return $this->entity->where(function ($query) use($filters) {
            if (isset($filters['lesson'])) {
                $query->where('lesson_id', $filters['lesson']);
            }

            if (isset($filters['status'])) {
                $query->where('status', $filters['status']);
            }

            if (isset($filters['filter'])) {

                $filter = $filters['filter'];

                $query->where('description', 'LIKE', "%{$filter}%");
            }

            if (isset($filters['user'])) {
                $user = $this->getUserAuth();

                $query->where('user_id', $user->id);
            }
        })
            ->with('replies')
            ->orderBy('updated_at')->paginate(5);
    }


    private function getSupport (string $identifySupport) {
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
