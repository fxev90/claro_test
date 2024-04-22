<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCoursesWithMostStudentsView extends Migration
{
    public function up()
    {
        DB::statement("
            DROP VIEW IF EXISTS courses_with_most_students;
            CREATE VIEW courses_with_most_students AS
            SELECT c.id AS course_id, c.nombre AS course_name, COUNT(cs.student_id) AS student_count
            FROM courses c
            INNER JOIN course_student cs ON c.id = cs.course_id
            WHERE cs.created_at >= NOW() - INTERVAL 6 MONTH
            GROUP BY c.id
            ORDER BY student_count DESC;
        ");
    }

    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS courses_with_most_students");
    }
}
