<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    
    public function index (Request $request) {
        $courses = Course::get();

        return CourseResource::collection($courses);
    }

    public function find (Request $request) {

        $courseId = $request->id;

        $course = Course::findOrFail($courseId);

        return new CourseResource($course);
    }

}
