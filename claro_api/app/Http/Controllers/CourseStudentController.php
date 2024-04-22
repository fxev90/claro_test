<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Student;
use Essa\APIToolKit\Api\ApiResponse;
use App\Models\CourseStudentCount;
use App\Models\StudentCourseCount;

class CourseStudentController extends Controller
{
    use ApiResponse;
    public function enrollStudent(Request $request, Course $course, Student $student)
    {

        // Attach the student to the course
        $course->students()->sync([$student->id => ['created_at' => now(), 'updated_at' => now()]], false);

        return response()->json(['message' => 'Estudiante matriculado'], 200);
    }

    public function topCourses() 
    {  $courses = CourseStudentCount::dynamicPaginate();
        return $courses;
    }

    public function topStudents()
    {
        $students = StudentCourseCount::dynamicPaginate();
        return $students;
    }
}
