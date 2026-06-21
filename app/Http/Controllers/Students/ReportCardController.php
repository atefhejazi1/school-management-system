<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Repository\ReportCardRepositoryInterface;
use Illuminate\Http\Request;

class ReportCardController extends Controller
{
    protected $ReportCards;

    public function __construct(ReportCardRepositoryInterface $ReportCards)
    {
        $this->ReportCards = $ReportCards;
    }

    public function index(Request $request)
    {
        return $this->ReportCards->index($request);
    }

    public function generateReportCardPdf($studentId, $examId)
    {
        return $this->ReportCards->generateReportCardPdf($studentId, $examId);
    }
}
