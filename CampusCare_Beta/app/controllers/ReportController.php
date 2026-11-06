<?php

declare(strict_types=1);

// MVC - Controller: menangani request API dan menggunakan model untuk data laporan.
class ReportController
{
    private ReportRepository $reportRepository;

    public function __construct(?ReportRepository $reportRepository = null)
    {
        $this->reportRepository = $reportRepository ?? new ReportRepository(__DIR__ . '/../../data/reports.json');
    }

    public function index(): void
    {
        $this->setJsonHeaders();

        $reports = $this->reportRepository->getAll();
        $payload = [];

        foreach ($reports as $report) {
            $payload[] = $report->toArray();
        }

        http_response_code(200);
        echo json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    public function store(?array $input = null): void
    {
        $this->setJsonHeaders();

        $data = $input ?? $this->readJsonInput();

        if (!is_array($data) || empty($data['title']) || empty($data['description'])) {
            http_response_code(400);
            echo json_encode([
                'message' => 'Judul dan deskripsi wajib diisi!',
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            return;
        }

        $report = Report::fromArray([
            'id' => time(),
            'category' => htmlspecialchars((string) ($data['category'] ?? 'Umum')),
            'title' => htmlspecialchars((string) $data['title']),
            'location' => htmlspecialchars((string) ($data['location'] ?? '-')),
            'description' => htmlspecialchars((string) $data['description']),
            'image' => $data['image'] ?? null,
            'status' => 'Menunggu',
            'date' => date('Y-m-d'),
            'createdAt' => date('Y-m-d H:i:s'),
        ]);

        $saved = $this->reportRepository->save($report);
        if (!$saved) {
            http_response_code(500);
            echo json_encode([
                'message' => 'Gagal menyimpan data ke server.',
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            return;
        }

        http_response_code(201);
        echo json_encode([
            'message' => 'Laporan berhasil disimpan!',
            'report' => $report->toArray(),
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    public function updateStatus(array $input): void
    {
        $this->setJsonHeaders();

        $id = $input['id'] ?? null;
        $newStatus = $input['status'] ?? null;

        if (!$id || !$newStatus) {
            http_response_code(400);
            echo json_encode([
                'message' => 'ID dan status wajib diisi!',
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            return;
        }

        $report = $this->reportRepository->getById($id);
        if ($report === null) {
            http_response_code(404);
            echo json_encode([
                'message' => 'Laporan tidak ditemukan.',
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            return;
        }

        $report->setStatus((string) $newStatus);

        $updated = $this->reportRepository->save($report);
        if (!$updated) {
            http_response_code(500);
            echo json_encode([
                'message' => 'Gagal memperbarui status di server.',
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            return;
        }

        http_response_code(200);
        echo json_encode([
            'message' => 'Status berhasil diperbarui!',
            'report' => $report->toArray(),
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    public function destroy($id = null): void
    {
        $this->setJsonHeaders();

        $targetId = $id;
        if ($targetId === null) {
            $payload = $this->readJsonInput();
            $targetId = $payload['id'] ?? null;
        }

        if ($targetId === null || $targetId === '') {
            http_response_code(400);
            echo json_encode([
                'message' => 'ID laporan tidak ditemukan!',
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            return;
        }

        $deleted = $this->reportRepository->delete($targetId);
        if (!$deleted) {
            http_response_code(404);
            echo json_encode([
                'message' => 'Laporan dengan ID tersebut tidak ditemukan.',
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            return;
        }

        http_response_code(200);
        echo json_encode([
            'message' => 'Laporan berhasil dihapus!',
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    private function readJsonInput(): array
    {
        $rawInput = file_get_contents('php://input');
        if ($rawInput === false || trim((string) $rawInput) === '') {
            return [];
        }

        $decoded = json_decode((string) $rawInput, true);
        return is_array($decoded) ? $decoded : [];
    }

    private function setJsonHeaders(): void
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
    }
}
