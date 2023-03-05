<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreView;
use App\Http\Resources\LessonResource;
use App\Repositories\LessonRepository;
use Illuminate\Http\Request;

class LessonController extends Controller
{

    protected $repository;

    public function __construct(LessonRepository $lessonRepository) {
        
        $this->repository = $lessonRepository;
    }
    
    public function index (Request $request) {

        $moduleId = $request->id;

        $lessons = $this->repository->getLessonsByModuleId($moduleId);

        return LessonResource::collection($lessons);
    }

    public function show (Request $request) {
        
        $id = $request->id;

        $lesson = $this->repository->getLesson($id);

        return new LessonResource($lesson);
    }

    public function viewed (StoreView $request) {

        $id = $request->lesson;

        $this->repository->markLessonViewed($id);

        return response()->json(['success' => true]);
    }
}
