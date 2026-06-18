<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGrades extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // معايا ال id بتاع ال grade اللى بعمل عليه update
            // اسم المرحلة الدراسية فريد فقط ضمن نفس المدرسة، وليس عبر كل المدارس على المنصة
            'Name' => [
                'required',
                Rule::unique('Grades', 'name->ar')
                    ->where('school_id', auth()->user()->school_id)
                    ->ignore($this->id),
            ],
            'Name_en' => [
                'required',
                Rule::unique('Grades', 'name->en')
                    ->where('school_id', auth()->user()->school_id)
                    ->ignore($this->id),
            ],
        ];
    }

    public function messages()
    {
        return [
            'Name.required' => trans('validation.required'),
            'Name.unique' => trans('validation.unique'),
            'Name_en.required' => trans('validation.required'),
            'Name_en.unique' => trans('validation.unique'),
        ];
    }
}
