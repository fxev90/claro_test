<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class CreateStudentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nombre' => 'required|max:100',
            'apellido' => 'nullable|max:100',
            'edad' => 'required|integer|min:18',
            'cedula' => 'required|max:11',
            'email' => 'required|email|unique:students',
        ];
    }
}
