<?php

namespace App\Repository;

interface ExamRepositoryInterface
{
    public function index();

    public function store($request);

    public function destroy($request);
}
