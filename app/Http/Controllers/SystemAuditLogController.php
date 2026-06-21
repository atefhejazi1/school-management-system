<?php

namespace App\Http\Controllers;

use App\Repository\AuditLogRepositoryInterface;

class SystemAuditLogController extends Controller
{
    protected $AuditLogs;

    public function __construct(AuditLogRepositoryInterface $AuditLogs)
    {
        $this->AuditLogs = $AuditLogs;
    }

    public function index()
    {
        return $this->AuditLogs->index();
    }
}
