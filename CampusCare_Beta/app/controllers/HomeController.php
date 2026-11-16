<?php

declare(strict_types=1);

// MVC - Controller: menyiapkan data halaman dari database MySQL Laravel lalu merender view.
class HomeController
{
    public function index(): void
    {
        $repository = new ReportRepository(__DIR__ . '/../../data/reports.json');
        $reports = $repository->getAll();

        require __DIR__ . '/../views/home.php';
    }

    public function caraKerja(): void
    {
        require __DIR__ . '/../views/cara-kerja.php';
    }
}
