<?php

namespace App\Livewire;

use App\Mail\RegistrationReceived;
use App\Models\SchoolRegistration as SchoolRegistrationModel;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class SchoolRegistration extends Component
{
    public string $school_name   = '';
    public string $contact_name  = '';
    public string $email         = '';
    public string $phone         = '';
    public string $city          = '';
    public string $student_count = '';
    public string $message       = '';
    public bool   $terms         = false;
    public bool   $submitted     = false;

    protected function rules(): array
    {
        return [
            'school_name'   => 'required|min:3',
            'contact_name'  => 'required|min:3',
            'email'         => 'required|email|unique:school_registrations,email',
            'phone'         => 'required|min:9',
            'city'          => 'required',
            'student_count' => 'required',
            'message'       => 'nullable|string|max:1000',
            'terms'         => 'accepted',
        ];
    }

    protected function messages(): array
    {
        return [
            'school_name.required'   => 'اسم المدرسة مطلوب.',
            'school_name.min'        => 'اسم المدرسة يجب أن يحتوي على 3 أحرف على الأقل.',
            'contact_name.required'  => 'اسم المسؤول مطلوب.',
            'contact_name.min'       => 'اسم المسؤول يجب أن يحتوي على 3 أحرف على الأقل.',
            'email.required'         => 'البريد الإلكتروني مطلوب.',
            'email.email'            => 'صيغة البريد الإلكتروني غير صحيحة.',
            'email.unique'           => 'هذا البريد الإلكتروني مسجّل مسبقاً.',
            'phone.required'         => 'رقم الهاتف مطلوب.',
            'phone.min'              => 'رقم الهاتف يجب أن يحتوي على 9 أرقام على الأقل.',
            'city.required'          => 'اسم المدينة مطلوب.',
            'student_count.required' => 'يرجى تحديد عدد الطلاب المتوقع.',
            'terms.accepted'         => 'يجب الموافقة على الشروط والأحكام للمتابعة.',
        ];
    }

    public function submit(): void
    {
        $this->validate();

        $registration = SchoolRegistrationModel::create([
            'school_name'   => $this->school_name,
            'contact_name'  => $this->contact_name,
            'email'         => $this->email,
            'phone'         => $this->phone,
            'city'          => $this->city,
            'student_count' => $this->student_count,
            'message'       => $this->message ?: null,
        ]);

        try {
            Mail::to($this->email)->send(new RegistrationReceived($registration));
        } catch (\Exception) {
            // Mail failure should not block the submission
        }

        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.school-registration');
    }
}
