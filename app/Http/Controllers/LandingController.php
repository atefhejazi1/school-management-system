<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        // الباقات النشطة فقط، مرتّبة من الأقل سعراً إلى الأعلى لعرضها بترتيب منطقي للزائر
        $plans = Plan::where('is_active', true)->orderBy('price')->get();

        return view('landing', compact('plans'));
    }
}
