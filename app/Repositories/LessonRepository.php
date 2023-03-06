<?php

namespace App\Repositories;

use App\Models\Lesson;
use App\Repositories\Traits\TraitRepository;

class LessonRepository {

    use TraitRepository;

    protected $entity;

    public function __construct (Lesson $model) {
        $this->entity = $model;
    }

    public function getLessonsByModuleId (string $identifyModule) {
        return $this->entity
            ->with('supports.replies')
            ->where('module_id', $identifyModule)->get();
    }

    public function getLesson (string $identify) {
        return $this->entity->findOrFail($identify);
    }

    public function markLessonViewed (string $identify) {

        $user = $this->getUserAuth();

        $view = $user->views()->where('lesson_id', $identify)->first();

        if ($view) {
            return $view->update([
                'qty' => $view->qty + 1
            ]);
        }

        return $user->views()->create([
            'lesson_id' => $identify
        ]);
    }

}
