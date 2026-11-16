<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/models/Report.php';
require_once __DIR__ . '/../app/models/ReportRepository.php';
require_once __DIR__ . '/../app/controllers/ReportController.php';

$method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    http_response_code(200);
    exit;
}

$controller = new ReportController();

if ($method === 'GET') {
    $controller->index();
    exit;
}

if ($method === 'POST') {
    $payload = json_decode((string) file_get_contents('php://input'), true);
    if (is_array($payload) && ($payload['action'] ?? '') === 'update_status') {
        $controller->updateStatus($payload);
        exit;
    }
    $controller->store(is_array($payload) ? $payload : null);
    exit;
}

if ($method === 'DELETE') {
    $payload = json_decode((string) file_get_contents('php://input'), true);
    $data = is_array($payload) ? $payload : [];
    $controller->destroy($_GET['id'] ?? $data['id'] ?? null);
    exit;
}
