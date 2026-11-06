<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/models/Report.php';
require_once __DIR__ . '/../app/models/ReportRepository.php';
require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/controllers/ReportController.php';

// MVC - Front Controller: satu entry point yang mengarahkan request ke controller.
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';

$basePath = dirname($scriptName);
$basePath = $basePath === '/' ? '' : $basePath;

$route = $_GET['route'] ?? null;
$path = is_string($route)
    ? '/' . trim($route, '/')
    : (parse_url($requestUri, PHP_URL_PATH) ?? '/');

if ($path === '') {
    $path = '/';
}

if ($basePath !== '' && str_starts_with($path, $basePath)) {
    $path = substr($path, strlen($basePath));
}

if ($path === '') {
    $path = '/';
}

$method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

$homeController = new HomeController();
$reportController = new ReportController();

switch ($path) {
    case '/':
        if ($method === 'GET') {
            $homeController->index();
            return;
        }
        break;

    case '/index.php':
        if ($method === 'GET') {
            $homeController->index();
            return;
        }
        break;

    case '/cara-kerja':
        if ($method === 'GET') {
            $homeController->caraKerja();
            return;
        }
        break;

    case '/api/reports':
        if ($method === 'GET') {
            $reportController->index();
            return;
        }

        if ($method === 'POST') {
            $payload = json_decode((string) file_get_contents('php://input'), true);

            if (isset($payload['action']) && $payload['action'] === 'update_status') {
                $reportController->updateStatus($payload);
                return;
            }

            $reportController->store($payload);
            return;
        }

        if ($method === 'DELETE') {
            $payload = json_decode((string) file_get_contents('php://input'), true);
            $data = is_array($payload) ? $payload : [];
            $reportController->destroy($_GET['id'] ?? $data['id'] ?? null);
            return;
        }
        break;
}

http_response_code(404);
header('Content-Type: application/json');
echo json_encode([
    'message' => 'Route not found.',
    'path' => $path,
    'method' => $method,
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
