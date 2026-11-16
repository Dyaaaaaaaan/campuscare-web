<?php

namespace App\Http\Controllers;

use App\Models\ReportHistory;
use Illuminate\View\View;

class ReportHistoryController extends Controller
{
    public function index(): View
    {
        $histories = ReportHistory::with(['report', 'user'])
            ->latest()
            ->get();

        return view('report_histories.index', compact('histories'));
    }
}

