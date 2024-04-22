<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    

    protected $fillable = [
        'nombre',
        'apellido',
        'edad',
        'cedula',
        'email',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'edad' => 'integer',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
        // Override the route key name for route model binding
        public function resolveRouteBinding($value, $field = null)
        {
            // Try to find a student by email
            $student = $this->where('id', $value)->first();
    
            // If no student is found by email, try to find by cedula
            if (!$student) {
                $student = $this->where('cedula', $value)->first();
            }
    
            // Return the found student or null
            return $student;
        }


}
