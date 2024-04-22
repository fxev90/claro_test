<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\UpdateStudentRequest;
use App\Http\Requests\Student\CreateStudentRequest;

use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Essa\APIToolKit\Api\ApiResponse;
class StudentController extends Controller
{
    use ApiResponse;
    public function __construct()
    {

    }

    public function index()
    {
        $students = Student::with('courses')->dynamicPaginate();

        return $students;
    }

    public function store(CreateStudentRequest $request): JsonResponse
    {
        $student = Student::create($request->validated());

        return $this->responseCreated('Student created successfully', $student);
    }

    public function show(Student $student): JsonResponse
    {
        return $this->responseSuccess(null, $student);
    }

    public function update(UpdateStudentRequest $request, Student $student): JsonResponse
    {
        $student->update($request->validated());

        return $this->responseSuccess('Student updated Successfully', $student);
    }

    public function destroy(Student $student): JsonResponse
    {
        $student->delete();

        return $this->responseDeleted();
    }

   public function restore($id): JsonResponse
    {
        $student = Student::onlyTrashed()->findOrFail($id);

        $student->restore();

        return $this->responseSuccess('Student restored Successfully.');
    }

    public function permanentDelete($id): JsonResponse
    {
        $student = Student::withTrashed()->findOrFail($id);

        $student->forceDelete();

        return $this->responseDeleted();
    }
}
