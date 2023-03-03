<?php

namespace App\Repositories;

use App\Models\ReplySupport;
use App\Models\Support;
use App\Repositories\Traits\TraitRepository;

class ReplySupportRepository {

    use TraitRepository;

    protected $entity;

    public function __construct(ReplySupport $model) {
        $this->entity = $model;
    }

    public function createReplyToSupport(array $data) {

        $user = $this->getUserAuth();

        $reply = $this->entity->create([
            'support_id' => $data['support'],
            'description' => $data['description'],
            'user_id' => $user->id
        ]);

        return $reply;
    }

}