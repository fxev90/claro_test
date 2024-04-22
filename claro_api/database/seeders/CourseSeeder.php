<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use App\Models\Student;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $courses = Course::factory(50)->create();
        $students = Student::all();
        foreach ($courses as $course) {
            $student = $students->random(rand(1, 10));
            $course->students()->sync($student->pluck('id'));
        }
    }
}
