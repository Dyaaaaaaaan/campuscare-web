<?php

declare(strict_types=1);

require_once __DIR__ . '/Report.php';

// MVC - Model: repository memisahkan persistence JSON dari controller dan view.
class ReportRepository
{
    private string $filePath;

    public function __construct(string $filePath = '../data/reports.json')
    {
        $this->filePath = $filePath;
    }

    public function getAll(): array
    {
        if (!file_exists($this->filePath)) {
            return [];
        }

        $contents = file_get_contents($this->filePath);
        if ($contents === false) {
            return [];
        }

        $trimmed = trim($contents);
        if ($trimmed === '') {
            return [];
        }

        $data = json_decode($trimmed, true);
        if (!is_array($data)) {
            return [];
        }

        $reports = [];
        foreach ($data as $item) {
            if (!is_array($item)) {
                continue;
            }

            $reports[] = Report::fromArray($item);
        }

        return $reports;
    }

    public function getById($id): ?Report
    {
        foreach ($this->getAll() as $report) {
            if ((string) $report->getId() === (string) $id) {
                return $report;
            }
        }

        return null;
    }

    public function save(Report $report): bool
    {
        $reports = $this->getAll();
        $index = null;

        foreach ($reports as $i => $existingReport) {
            if ((string) $existingReport->getId() === (string) $report->getId()) {
                $index = $i;
                break;
            }
        }

        if ($index === null) {
            $reports[] = $report;
        } else {
            $reports[$index] = $report;
        }

        return $this->writeReports($reports);
    }

    public function delete($id): bool
    {
        $reports = $this->getAll();
        $filteredReports = [];
        $deleted = false;

        foreach ($reports as $report) {
            if ((string) $report->getId() === (string) $id) {
                $deleted = true;
                continue;
            }

            $filteredReports[] = $report;
        }

        if (!$deleted) {
            return false;
        }

        return $this->writeReports($filteredReports);
    }

    private function writeReports(array $reports): bool
    {
        $payload = [];
        foreach ($reports as $report) {
            if ($report instanceof Report) {
                $payload[] = $report->toArray();
            }
        }

        $encoded = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        if ($encoded === false) {
            return false;
        }

        $directory = dirname($this->filePath);
        if ($directory !== '' && !is_dir($directory)) {
            if (!mkdir($directory, 0777, true) && !is_dir($directory)) {
                return false;
            }
        }

        $result = file_put_contents($this->filePath, $encoded . PHP_EOL);
        return $result !== false;
    }
}
