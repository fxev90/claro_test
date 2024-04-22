<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentCourseCount extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'students_with_most_courses';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

}