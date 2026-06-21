<?php

namespace App\Repository;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditLogRepository implements AuditLogRepositoryInterface
{
    public function index()
    {
        // هذا المسار يقع ضمن مجموعة مسارات المدير العادي (auth:web)، وليس ضمن مسارات
        // منشئ المنصة فقط — لذا يجب تقييد السجلات بمدرسة المستخدم الحالي، وإلا يمكن لأي
        // مدير مدرسة قراءة سجل تدقيق كل المدارس الأخرى على المنصة. منشئ المنصة (Super Admin)
        // فقط يرى كل السجلات دون أي تقييد
        $auditLogs = AuditLog::with('user')
            ->when(! Auth::user()->isSuperAdmin(), function ($query) {
                $query->where('school_id', Auth::user()->school_id);
            })
            ->latest()
            ->paginate(30);
        return view('pages.AuditLogs.index', compact('auditLogs'));
    }
}
