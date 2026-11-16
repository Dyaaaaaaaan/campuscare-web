<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $reports = Report::with(['user', 'category', 'location'])
            ->latest()
            ->get();

        return view('reports.index', compact('reports'));
    }
}
