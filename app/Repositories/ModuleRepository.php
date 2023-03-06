<?php

namespace App\Repositories;

use App\Models\Module;

class ModuleRepository {

    protected $entity;

    public function __construct(Module $model) {
        $this->entity = $model;
    }

    public function getModulesByCourseId(string $identifyCourse) {
        return $this->entity
            ->with('lessons.views')
            ->where('course_id', $identifyCourse)->get();
    }

}
