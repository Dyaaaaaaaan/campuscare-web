<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Location;
use App\Models\Report;
use App\Models\ReportHistory;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    // READ
    public function index(): View
    {
        $reports = Report::with(['user', 'category', 'location'])
            ->latest('id')
            ->get();

        return view('reports.index', compact('reports'));
    }

    // FORM CREATE
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        $locations = Location::orderBy('building')->get();
        $users = User::orderBy('name')->get();

        return view('reports.create', compact('categories', 'locations', 'users'));
    }

    // CREATE
    public function store(Request $request): RedirectResponse
    {
        $report = Report::create([
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
            'location_id' => $request->location_id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status ?? 'Menunggu',
            'reported_at' => $request->reported_at ?? now()->toDateString(),
        ]);

        ReportHistory::create([
            'report_id' => $report->id,
            'user_id' => $report->user_id,
            'status' => $report->status,
            'note' => 'Laporan dibuat melalui form CRUD Laravel',
        ]);

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil ditambahkan.');
    }

    // FORM EDIT
    public function edit($id): View
    {
        $report = Report::findOrFail($id);
        $categories = Category::orderBy('name')->get();
        $locations = Location::orderBy('building')->get();
        $users = User::orderBy('name')->get();

        return view('reports.edit', compact('report', 'categories', 'locations', 'users'));
    }

    // UPDATE
    public function update(Request $request, $id): RedirectResponse
    {
        $report = Report::findOrFail($id);
        $oldStatus = $report->status;

        $report->update([
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
            'location_id' => $request->location_id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'reported_at' => $request->reported_at,
        ]);

        if ($oldStatus !== $report->status) {
            ReportHistory::create([
                'report_id' => $report->id,
                'user_id' => $report->user_id,
                'status' => $report->status,
                'note' => 'Status diubah melalui form Edit Laravel',
            ]);
        }

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    // DELETE
    public function destroy($id): RedirectResponse
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
