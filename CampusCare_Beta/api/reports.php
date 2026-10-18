<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$filePath = '../data/reports.json';

$method = $_SERVER['REQUEST_METHOD'];

// 1. HANDLER OPTIONS (Preflight)
if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// 2. HANDLER GET (Mengambil Data Laporan)
if ($method === 'GET') {
    if (file_exists($filePath)) {
        $jsonData = file_get_contents($filePath);
        echo $jsonData;
    } else {
        echo json_encode([]);
    }
    exit;
}

// 3. HANDLER POST (Tambah Laporan Baru ATAU Update Status Admin)
if ($method === 'POST') {
    $rawInput = file_get_contents('php://input');
    $data = json_decode($rawInput, true);

    // Baca isi file reports.json
    $reports = [];
    if (file_exists($filePath)) {
        $existingContent = file_get_contents($filePath);
        $reports = json_decode($existingContent, true) ?? [];
    }

    // A. FITUR UPDATE STATUS ADMIN
    if (isset($data['action']) && $data['action'] === 'update_status') {
        $id = $data['id'] ?? null;
        $newStatus = $data['status'] ?? null;

        if (!$id || !$newStatus) {
            http_response_code(400);
            echo json_encode(['message' => 'ID dan status wajib diisi!']);
            exit;
        }

        $updated = false;
        foreach ($reports as &$report) {
            if ((string)($report['id'] ?? '') === (string)$id) {
                $report['status'] = htmlspecialchars($newStatus);
                $updated = true;
                break;
            }
        }

        if ($updated && file_put_contents($filePath, json_encode($reports, JSON_PRETTY_PRINT))) {
            http_response_code(200);
            echo json_encode(['message' => 'Status berhasil diperbarui!']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Gagal memperbarui status di server.']);
        }
        exit;
    }

    // B. FITUR TAMBAH LAPORAN BARU (FORM MAHASISWA)
    if (!$data || empty($data['title']) || empty($data['description'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Judul dan deskripsi wajib diisi!']);
        exit;
    }

    $newReport = [
        'id' => time(),
        'category' => htmlspecialchars($data['category'] ?? 'Umum'),
        'title' => htmlspecialchars($data['title']),
        'location' => htmlspecialchars($data['location'] ?? '-'),
        'description' => htmlspecialchars($data['description']),
        'image' => $data['image'] ?? null,
        'status' => 'Menunggu',
        'date' => date('Y-m-d'),
        'createdAt' => date('Y-m-d H:i:s')
    ];

    array_push($reports, $newReport);

    if (file_put_contents($filePath, json_encode($reports, JSON_PRETTY_PRINT))) {
        http_response_code(201);
        echo json_encode([
            'message' => 'Laporan berhasil disimpan!',
            'report' => $newReport
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Gagal menyimpan data ke server.']);
    }
    exit;
}

// 4. HANDLER DELETE (Hapus Laporan Admin)
if ($method === 'DELETE') {
    $id = $_GET['id'] ?? null;

    if (!$id) {
        $rawInput = file_get_contents('php://input');
        $data = json_decode($rawInput, true);
        $id = $data['id'] ?? null;
    }

    if (!$id) {
        http_response_code(400);
        echo json_encode(['message' => 'ID laporan tidak ditemukan!']);
        exit;
    }

    if (!file_exists($filePath)) {
        http_response_code(404);
        echo json_encode(['message' => 'Data laporan kosong.']);
        exit;
    }

    $existingContent = file_get_contents($filePath);
    $reports = json_decode($existingContent, true) ?? [];

    $initialCount = count($reports);
    $filteredReports = array_filter($reports, function ($report) use ($id) {
        return (string)($report['id'] ?? '') !== (string)$id;
    });

    if (count($reports) === count($filteredReports)) {
        http_response_code(404);
        echo json_encode(['message' => 'Laporan dengan ID tersebut tidak ditemukan.']);
        exit;
    }

    $reindexedReports = array_values($filteredReports);

    if (file_put_contents($filePath, json_encode($reindexedReports, JSON_PRETTY_PRINT))) {
        http_response_code(200);
        echo json_encode(['message' => 'Laporan berhasil dihapus!']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Gagal memperbarui data di server.']);
    }
    exit;
}