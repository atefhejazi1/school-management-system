<?php

namespace App\Http\Requests;

use App\Models\students;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudents extends FormRequest
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
            'name_ar' => 'required',
            'name_en' => 'required',
            // البريد الإلكتروني فريد فقط ضمن نفس المدرسة، وليس عبر كل المدارس على المنصة
            'email' => [
                'required',
                'email',
                Rule::unique('students', 'email')
                    ->where('school_id', auth()->user()->school_id)
                    ->ignore($this->id),
            ],
            'password' => 'required|string|min:6|max:10',
            'gender_id' => 'required',
            'nationalitie_id' => 'required',
            'blood_id' => 'required',
            'Date_Birth' => 'required|date|date_format:Y-m-d',
            // 'exists' هنا مقيّد بـ school_id الخاص بالمستخدم الحالي، تماماً كما هو الحال أعلاه
            // مع البريد الإلكتروني — بدون هذا القيد كان بالإمكان ربط طالب بصف/فصل/قسم/ولي أمر
            // من مدرسة أخرى بالكامل بمجرد تمرير رقم تعريف (id) مختلف ضمن الطلب
            'Grade_id' => ['required', Rule::exists('Grades', 'id')->where('school_id', auth()->user()->school_id)],
            'Classroom_id' => ['required', Rule::exists('Classrooms', 'id')->where('school_id', auth()->user()->school_id)],
            'section_id' => ['required', Rule::exists('sections', 'id')->where('school_id', auth()->user()->school_id)],
            'parent_id' => ['required', Rule::exists('my__parents', 'id')->where('school_id', auth()->user()->school_id)],
            'academic_year' => 'required',
        ];
    }

    /**
     * تطبيق حد السعة (Capacity Limit) الخاص بالباقة قبل اعتماد الطالب الجديد.
     * يتم هذا الفحص فقط عند إنشاء طالب جديد (لا يوجد id في الطلب)، لأن تعديل طالب
     * موجود مسبقاً لا يزيد العدد الإجمالي للطلاب ضمن المدرسة.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            // هذا الفحص خاص فقط بإنشاء طالب جديد، وليس بتحديث بيانات طالب موجود
            if ($this->id) {
                return;
            }

            $school = auth()->user()->school;

            // لا يوجد ربط بمدرسة (مثلاً منشئ المنصة)، أو المدرسة بدون باقة محددة بعد:
            // لا يمكن تطبيق حد لا وجود له، فيتم تجاوز الفحص بأمان
            if (! $school || ! $school->plan) {
                return;
            }

            // عدد الطلاب الحالي يُحسب تلقائياً ضمن نطاق المدرسة الحالية فقط
            // عبر Global Scope المعرّف في BelongsToSchool، دون أي شرط إضافي على school_id هنا
            $currentStudentsCount = students::count();

            if ($currentStudentsCount >= $school->plan->max_students) {
                $validator->errors()->add(
                    'capacity',
                    'عذراً، لقد وصلت المدرسة إلى الحد الأقصى المسموح به من الطلاب لهذه الباقة. يرجى ترقية الاشتراك.'
                );
            }
        });
    }
}
