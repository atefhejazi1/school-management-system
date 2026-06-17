<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\SchoolRegistration;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * لوحة تحكم منشئ المنصة الرئيسية: نظرة عامة سريعة على حالة كل المدارس المسجّلة.
     */
    public function index(): View
    {
        $stats = [
            'total_schools'     => School::query()->count(),
            'active_schools'    => School::query()->where('status', 'active')->count(),
            'suspended_schools' => School::query()->where('status', 'suspended')->count(),
            'pending_requests'  => SchoolRegistration::query()->pending()->count(),
        ];

        return view('super-admin.dashboard.index', compact('stats'));
    }
}
