<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\ReportHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportApiController extends Controller
{
    public function index(): JsonResponse
    {
        $reports = Report::with(['user:id,name,email,role', 'category:id,name', 'location:id,building,floor,room'])
            ->latest('id')
            ->get();

        return response()->json([
            'data' => $reports,
            'message' => 'success',
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'status' => 'sometimes|in:Menunggu,Diajukan,Diverifikasi,Diproses,Selesai',
            'reported_at' => 'sometimes|date',
        ]);

        $userId = $request->user()->id;

        $report = Report::create([
            'user_id' => $userId,
            'category_id' => $validated['category_id'],
            'location_id' => $validated['location_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'] ?? 'Menunggu',
            'reported_at' => $validated['reported_at'] ?? now()->toDateString(),
        ]);

        ReportHistory::create([
            'report_id' => $report->id,
            'user_id' => $userId,
            'status' => $report->status,
            'note' => 'Laporan dibuat melalui REST API',
        ]);

        return response()->json([
            'message' => 'Berhasil',
            'data' => $report->load(['user:id,name,email,role', 'category:id,name', 'location:id,building,floor,room']),
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $report = Report::with(['user:id,name,email,role', 'category:id,name', 'location:id,building,floor,room'])
            ->find($id);

        if (!$report) {
            return response()->json([
                'message' => 'Laporan tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'data' => $report,
        ], 200);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $report = Report::find($id);

        if (!$report) {
            return response()->json([
                'message' => 'Laporan tidak ditemukan.',
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'category_id' => 'sometimes|exists:categories,id',
            'location_id' => 'sometimes|exists:locations,id',
            'status' => 'sometimes|in:Menunggu,Diajukan,Diverifikasi,Diproses,Selesai',
            'reported_at' => 'sometimes|date',
        ]);

        $oldStatus = $report->status;
        $report->update($validated);

        if ($oldStatus !== $report->status) {
            ReportHistory::create([
                'report_id' => $report->id,
                'user_id' => $request->user()->id,
                'status' => $report->status,
                'note' => 'Status diperbarui melalui REST API',
            ]);
        }

        return response()->json([
            'message' => 'Berhasil',
            'data' => $report->load(['user:id,name,email,role', 'category:id,name', 'location:id,building,floor,room']),
        ], 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $report = Report::find($id);

        if (!$report) {
            return response()->json([
                'message' => 'Laporan tidak ditemukan.',
            ], 404);
        }

        $report->delete();

        return response()->json([
            'message' => 'Laporan berhasil dihapus.',
        ], 200);
    }
}
