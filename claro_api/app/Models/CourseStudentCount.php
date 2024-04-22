<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseStudentCount extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'courses_with_most_students';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

}