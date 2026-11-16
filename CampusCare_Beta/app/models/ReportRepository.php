<?php

declare(strict_types=1);

require_once __DIR__ . '/Report.php';

// MVC - Model: repository menghubungkan aplikasi utama dengan database MySQL Laravel (campuscare).
class ReportRepository
{
    private string $filePath;
    private ?PDO $pdo = null;

    public function __construct(string $filePath = '../data/reports.json')
    {
        $this->filePath = $filePath;
        $this->pdo = $this->connectDatabase();
    }

    private function connectDatabase(): ?PDO
    {
        $config = [
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'campuscare',
            'username' => 'root',
            'password' => '',
        ];

        $envPath = __DIR__ . '/../../../CampusCare_Laravel/.env';
        if (file_exists($envPath)) {
            $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
                    continue;
                }
                [$key, $val] = explode('=', $line, 2);
                $key = trim($key);
                $val = trim($val, " \t\n\r\0\x0B\"'");
                if ($key === 'DB_HOST' && $val !== '') {
                    $config['host'] = $val;
                } elseif ($key === 'DB_PORT' && $val !== '') {
                    $config['port'] = $val;
                } elseif ($key === 'DB_DATABASE' && $val !== '') {
                    $config['database'] = $val;
                } elseif ($key === 'DB_USERNAME') {
                    $config['username'] = $val;
                } elseif ($key === 'DB_PASSWORD') {
                    $config['password'] = $val;
                }
            }
        }

        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            $config['host'],
            $config['port'],
            $config['database']
        );

        return new PDO($dsn, $config['username'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    public function getAll(): array
    {
        $sql = "
            SELECT r.id,
                   COALESCE(c.name, 'Umum') AS category,
                   r.title,
                   CONCAT_WS(', ', l.building, NULLIF(l.floor, ''), NULLIF(l.room, '')) AS location,
                   COALESCE(r.description, '') AS description,
                   r.image,
                   r.status,
                   r.reported_at AS date,
                   r.created_at AS createdAt
            FROM reports r
            LEFT JOIN categories c ON r.category_id = c.id
            LEFT JOIN locations l ON r.location_id = l.id
            ORDER BY r.id ASC
        ";

        $stmt = $this->pdo->query($sql);
        $rows = $stmt->fetchAll();

        $reports = [];
        foreach ($rows as $row) {
            $reports[] = Report::fromArray($row);
        }

        return $reports;
    }

    public function getById($id): ?Report
    {
        $sql = "
            SELECT r.id,
                   COALESCE(c.name, 'Umum') AS category,
                   r.title,
                   CONCAT_WS(', ', l.building, NULLIF(l.floor, ''), NULLIF(l.room, '')) AS location,
                   COALESCE(r.description, '') AS description,
                   r.image,
                   r.status,
                   r.reported_at AS date,
                   r.created_at AS createdAt
            FROM reports r
            LEFT JOIN categories c ON r.category_id = c.id
            LEFT JOIN locations l ON r.location_id = l.id
            WHERE r.id = :id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return is_array($row) ? Report::fromArray($row) : null;
    }

    public function save(Report $report): bool
    {
        $categoryId = $this->resolveCategoryId($report->getCategory());
        $locationId = $this->resolveLocationId($report->getLocation());

        $checkStmt = $this->pdo->prepare('SELECT id, status FROM reports WHERE id = :id LIMIT 1');
        $checkStmt->execute(['id' => $report->getId()]);
        $existing = $checkStmt->fetch();

        if ($existing) {
            $adminId = $this->resolveUserId('admin');
            $updateStmt = $this->pdo->prepare('
                UPDATE reports
                SET category_id = :category_id,
                    location_id = :location_id,
                    title = :title,
                    description = :description,
                    image = :image,
                    status = :status,
                    updated_at = NOW()
                WHERE id = :id
            ');
            $ok = $updateStmt->execute([
                'category_id' => $categoryId,
                'location_id' => $locationId,
                'title' => $report->getTitle(),
                'description' => $report->getDescription(),
                'image' => $report->getImage(),
                'status' => $report->getStatus(),
                'id' => $report->getId(),
            ]);

            if ($ok && $existing['status'] !== $report->getStatus()) {
                $this->recordHistory((int) $report->getId(), $adminId, $report->getStatus(), 'Status diperbarui melalui aplikasi utama');
            }

            return $ok;
        }

        $userId = $this->resolveUserId('mahasiswa');
        $insertStmt = $this->pdo->prepare('
            INSERT INTO reports (user_id, category_id, location_id, title, description, image, status, reported_at, created_at, updated_at)
            VALUES (:user_id, :category_id, :location_id, :title, :description, :image, :status, :reported_at, NOW(), NOW())
        ');
        $ok = $insertStmt->execute([
            'user_id' => $userId,
            'category_id' => $categoryId,
            'location_id' => $locationId,
            'title' => $report->getTitle(),
            'description' => $report->getDescription(),
            'image' => $report->getImage(),
            'status' => $report->getStatus(),
            'reported_at' => $report->getDate(),
        ]);

        if ($ok) {
            $newId = (int) $this->pdo->lastInsertId();
            $report->setId($newId);
            $this->recordHistory($newId, $userId, $report->getStatus(), 'Laporan baru dibuat melalui aplikasi utama');
        }

        return $ok;
    }

    public function delete($id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM reports WHERE id = :id');
        $stmt->execute(['id' => $id]);

        return $stmt->rowCount() > 0;
    }

    private function resolveCategoryId(string $categoryName): int
    {
        $name = trim($categoryName) !== '' ? trim($categoryName) : 'Umum';

        $stmt = $this->pdo->prepare('SELECT id FROM categories WHERE name = :name LIMIT 1');
        $stmt->execute(['name' => $name]);
        $row = $stmt->fetch();
        if ($row) {
            return (int) $row['id'];
        }

        $insert = $this->pdo->prepare('INSERT INTO categories (name, created_at, updated_at) VALUES (:name, NOW(), NOW())');
        $insert->execute(['name' => $name]);

        return (int) $this->pdo->lastInsertId();
    }

    private function resolveLocationId(string $rawLocation): int
    {
        $raw = trim($rawLocation) !== '' ? trim($rawLocation) : '-';
        $parts = array_map('trim', explode(',', $raw));
        $building = $parts[0] !== '' ? $parts[0] : '-';
        $floor = $parts[1] ?? null;
        $room = isset($parts[2]) ? implode(', ', array_slice($parts, 2)) : null;

        $stmt = $this->pdo->prepare('
            SELECT id FROM locations
            WHERE building = :building
              AND ((:floor IS NULL AND floor IS NULL) OR floor = :floor2)
              AND ((:room IS NULL AND room IS NULL) OR room = :room2)
            LIMIT 1
        ');
        $stmt->execute([
            'building' => $building,
            'floor' => $floor,
            'floor2' => $floor,
            'room' => $room,
            'room2' => $room,
        ]);
        $row = $stmt->fetch();
        if ($row) {
            return (int) $row['id'];
        }

        $insert = $this->pdo->prepare('
            INSERT INTO locations (building, floor, room, created_at, updated_at)
            VALUES (:building, :floor, :room, NOW(), NOW())
        ');
        $insert->execute([
            'building' => $building,
            'floor' => $floor,
            'room' => $room,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    private function resolveUserId(string $role): int
    {
        $stmt = $this->pdo->prepare('SELECT id FROM users WHERE role = :role ORDER BY id ASC LIMIT 1');
        $stmt->execute(['role' => $role]);
        $row = $stmt->fetch();
        if ($row) {
            return (int) $row['id'];
        }

        $fallback = $this->pdo->query('SELECT id FROM users ORDER BY id ASC LIMIT 1')->fetch();
        if ($fallback) {
            return (int) $fallback['id'];
        }

        $insert = $this->pdo->prepare('
            INSERT INTO users (name, email, password, role, created_at, updated_at)
            VALUES (:name, :email, :password, :role, NOW(), NOW())
        ');
        $insert->execute([
            'name' => $role === 'admin' ? 'Admin Sarpras' : 'Mahasiswa Demo',
            'email' => $role . '@campuscare.id',
            'password' => password_hash('password', PASSWORD_BCRYPT),
            'role' => $role,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    private function recordHistory(int $reportId, int $userId, string $status, string $note): void
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO report_histories (report_id, user_id, status, note, created_at, updated_at)
            VALUES (:report_id, :user_id, :status, :note, NOW(), NOW())
        ');
        $stmt->execute([
            'report_id' => $reportId,
            'user_id' => $userId,
            'status' => $status,
            'note' => $note,
        ]);
    }
}
