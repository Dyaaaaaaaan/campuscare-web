<?php

declare(strict_types=1);

// MVC - Controller: menyiapkan data halaman lalu memilih view yang akan dirender.
class HomeController
{
    public function index(): void
    {
        $reports = [];
        $repository = new ReportRepository(__DIR__ . '/../../data/reports.json');

        if (file_exists(__DIR__ . '/../../data/reports.json')) {
            $reports = $repository->getAll();
        }

        require __DIR__ . '/../views/home.php';
    }

    public function caraKerja(): void
    {
        require __DIR__ . '/../views/cara-kerja.php';
    }
}
