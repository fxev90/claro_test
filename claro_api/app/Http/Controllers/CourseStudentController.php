<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Student;

class CourseStudentController extends Controller
{
    public function enrollStudent(Request $request, Course $course, Student $student)
    {

        // Attach the student to the course
        $course->students()->sync([$student->id => ['created_at' => now(), 'updated_at' => now()]], false);

        return response()->json(['message' => 'Estudiante matriculado'], 200);
    }
}
