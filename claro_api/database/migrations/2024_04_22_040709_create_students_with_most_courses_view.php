<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateStudentsWithMostCoursesView extends Migration
{
    public function up()
    {
        DB::statement("
            CREATE OR REPLACE VIEW students_with_most_courses AS
            SELECT s.id AS student_id, s.nombre AS student_name, COUNT(cs.course_id) AS course_count
            FROM students s
            LEFT JOIN course_student cs ON s.id = cs.student_id
            WHERE s.deleted_at IS NULL
            GROUP BY s.id
            ORDER BY course_count DESC;
        ");
    }

    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS students_with_most_courses");
    }
}