<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\My_Parent;
use App\Models\School;
use App\Models\SchoolRegistration;
use App\Models\students;
use App\Models\Teachers;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * لوحة تحكم منشئ المنصة الرئيسية: نظرة عامة سريعة على حالة كل المدارس المسجّلة،
     * بالإضافة إلى عدّادات شاملة لكل المنصة (كل المدارس مجتمعة). العدّادات التالية
     * (Student/Teachers/My_Parent) تعمل بدون أي عزل على مستوى مدرسة بعينها لأن
     * SchoolScope يستثني صريحاً المستخدم الذي school_id خاصته NULL (منشئ المنصة)
     * من أي تصفية، فتعيد ::count() هنا العدد الحقيقي عبر كل المدارس مجتمعة.
     */
    public function index(): View
    {
        $stats = [
            'total_schools'     => School::query()->count(),
            'active_schools'    => School::query()->where('status', 'active')->count(),
            'suspended_schools' => School::query()->where('status', 'suspended')->count(),
            'pending_requests'  => SchoolRegistration::query()->pending()->count(),
            'total_students'    => students::query()->count(),
            'total_teachers'    => Teachers::query()->count(),
            'total_parents'     => My_Parent::query()->count(),
        ];

        return view('super-admin.dashboard.index', compact('stats'));
    }
}
