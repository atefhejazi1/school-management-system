<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\School;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * صفحة اختيار/تجديد باقة الاشتراك لمدرسة محددة، عبر بطاقات (Cards) بدلاً من
 * القائمة المنسدلة القديمة. الوصول مقيَّد تلقائياً لمنشئ المنصة فقط عبر middleware
 * "role.redirect" المطبَّق على كل مسارات مجموعة /super-admin.
 */
class PlanSelectionController extends Controller
{
    public function index(School $school): View
    {
        $plans = Plan::where('is_active', true)->orderBy('price')->get();

        return view('super-admin.plans.select', compact('school', 'plans'));
    }

    /**
     * تفعيل الباقة المختارة على المدرسة: تحديث plan_id، حساب تاريخ الانتهاء الجديد
     * بدءاً من لحظة التفعيل (now()->addMonths)، وإعادة تفعيل المدرسة تلقائياً إن كانت معلّقة.
     */
    public function store(Request $request, School $school): RedirectResponse
    {
        $validated = $request->validate(
            [
                'plan_id' => ['required', Rule::exists('plans', 'id')->where('is_active', true)],
                'months'  => 'required|integer|min:1|max:36',
            ],
            [
                'plan_id.required' => 'يرجى اختيار باقة الاشتراك.',
                'plan_id.exists'   => 'الباقة المختارة غير متاحة حالياً.',
                'months.required'  => 'يرجى تحديد عدد أشهر التجديد.',
                'months.integer'   => 'عدد الأشهر يجب أن يكون رقماً صحيحاً.',
                'months.min'       => 'يجب أن يكون التجديد لشهر واحد على الأقل.',
                'months.max'       => 'لا يمكن التجديد لأكثر من 36 شهراً دفعة واحدة.',
            ]
        );

        $plan = Plan::findOrFail($validated['plan_id']);

        $school->update([
            'plan_id'                 => $plan->id,
            'subscription_expires_at' => now()->addMonths((int) $validated['months']),
            'status'                  => 'active',
        ]);

        return redirect()
            ->route('super-admin.school-requests.index')
            ->with('success', 'تم تفعيل باقة "' . $plan->name . '" لمدرسة "' . $school->name . '" بنجاح.');
    }
}
