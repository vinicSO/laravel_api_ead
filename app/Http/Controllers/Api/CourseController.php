<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Repositories\CourseRepository;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    protected $repository;

    public function __construct(CourseRepository $courseRepository) {
        $this->repository = $courseRepository;
    }

    public function index (Request $request) {

        $courses = $this->repository->getAllCourses();

        return CourseResource($courses);
    }

    public function find (Request $request) {

        $courseId = $request->id;

        $course = $this->repository->getCourse($courseId);

        return new CourseResource($course);
    }

}
