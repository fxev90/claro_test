<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Student;

class CourseStudentController extends Controller
{
    public function enrollStudent(Request $request, Course $course, Student $student)
    {
        // Validate the request
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'student_id' => 'required|exists:students,id',
        ]);

        // Attach the student to the course
        $course->students()->syncWithoutDetaching([$student->id]);

        return response()->json(['message' => 'Estudiante matriculado'], 200);
    }
}
