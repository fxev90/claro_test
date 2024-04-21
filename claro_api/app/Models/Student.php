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

    /**
     * The rules that govern the validation of the model.
     *
     * @var array
     */
    public static $rules = [
        'nombre' => 'required|max:100',
        'apellido' => 'nullable|max:100',
        'edad' => 'required|integer|min:18',
        'cedula' => 'required|max:11',
        'email' => 'required|email|unique:estudiantes',
    ];


}
