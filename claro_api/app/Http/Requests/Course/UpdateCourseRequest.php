<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nombre' => 'nullable|string|max:50',
            'horario' => 'nullable|in:Mañana,Tarde,Noche',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'tipo' => 'nullable|in:Presencial,Virtual',
        ];
    }
}
