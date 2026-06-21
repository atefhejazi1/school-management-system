<?php

namespace App\Repository;

interface ReportCardRepositoryInterface
{
    public function index($request);

    public function generateReportCardPdf($studentId, $examId);
}
