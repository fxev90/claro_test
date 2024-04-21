<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nombre' => 'sometimes|max:100',
            'apellido' => 'sometimes|nullable|max:100',
            'edad' => 'sometimes|integer|min:18',
            'cedula' => 'sometimes|max:11',
            'email' => 'sometimes|email|unique:students,email,' . $this->route('student')->id,
        ];
    }
}
