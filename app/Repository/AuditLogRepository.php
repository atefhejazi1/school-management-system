<?php

namespace App\Repository;

use App\Models\AuditLog;

class AuditLogRepository implements AuditLogRepositoryInterface
{
    public function index()
    {
        $auditLogs = AuditLog::with('user')->latest()->paginate(30);
        return view('pages.AuditLogs.index', compact('auditLogs'));
    }
}
