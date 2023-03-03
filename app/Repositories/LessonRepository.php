<?php

namespace App\Repositories;

use App\Models\Lesson;

class LessonRepository {

    protected $entity;

    public function __construct(Lesson $model) {
        $this->entity = $model;
    }

    public function getLessonsByModuleId(string $identifyModule) {
        return $this->entity->where('module_id', $identifyModule)->get();
    }

    public function getLesson(string $identify) {
        return $this->entity->findOrFail($identify);
    }

}