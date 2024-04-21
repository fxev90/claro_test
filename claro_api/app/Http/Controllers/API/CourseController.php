<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Http\Requests\Course\CreateCourseRequest;

use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Essa\APIToolKit\Api\ApiResponse;

class CourseController extends Controller
{
    use ApiResponse;
    public function __construct()
    {

    }

    public function index()
    {
        $courses = Course::dynamicPaginate();

        return $courses;
    }

    public function store(CreateCourseRequest $request): JsonResponse
    {
        $course = Course::create($request->validated());

        return $this->responseCreated('Course created successfully', $course);
    }

    public function show(Course $course): JsonResponse
    {
        return $this->responseSuccess(null, $course);
    }

    public function update(UpdateCourseRequest $request, Course $course): JsonResponse
    {
        $course->update($request->validated());

        return $this->responseSuccess('Course updated Successfully', $course);
    }

    public function destroy(Course $course): JsonResponse
    {
        $course->delete();

        return $this->responseDeleted();
    }

   public function restore($id): JsonResponse
    {
        $course = Course::onlyTrashed()->findOrFail($id);

        $course->restore();

        return $this->responseSuccess('Course restored Successfully.');
    }

    public function permanentDelete($id): JsonResponse
    {
        $course = Course::withTrashed()->findOrFail($id);

        $course->forceDelete();

        return $this->responseDeleted();
    }
}
