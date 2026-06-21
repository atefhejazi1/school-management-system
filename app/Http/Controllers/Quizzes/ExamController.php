<?php

namespace App\Http\Controllers\Quizzes;

use App\Http\Controllers\Controller;
use App\Repository\ExamRepositoryInterface;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    protected $Exams;

    public function __construct(ExamRepositoryInterface $Exams)
    {
        $this->Exams = $Exams;
    }

    public function index()
    {
        return $this->Exams->index();
    }

    public function store(Request $request)
    {
        return $this->Exams->store($request);
    }

    public function destroy(Request $request)
    {
        return $this->Exams->destroy($request);
    }
}
