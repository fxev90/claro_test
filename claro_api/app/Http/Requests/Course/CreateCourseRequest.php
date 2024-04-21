<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class CreateCourseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:50',
            'horario' => 'nullable|in:Mañana,Tarde,Noche',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'tipo' => 'required|in:Presencial,Virtual',
        ];
    }
}
