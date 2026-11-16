<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Location;
use App\Models\Report;
use App\Models\ReportHistory;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@campuscare.id'],
            [
                'name' => 'Admin Sarpras',
                'password' => 'admin123',
                'role' => 'admin',
            ]
        );

        $mahasiswa = User::updateOrCreate(
            ['email' => '2024001@student.umm.ac.id'],
            [
                'name' => 'Mahasiswa Demo',
                'password' => 'mahasiswa123',
                'role' => 'mahasiswa',
            ]
        );

        $categoryList = [
            'Ruang Kelas' => 'Kerusakan meja, kursi, papan tulis, proyektor, dan fasilitas kelas lainnya.',
            'Listrik & Penerangan' => 'Lampu mati, stop kontak rusak, saklar bermasalah, atau gangguan listrik lainnya.',
            'Fasilitas Air' => 'Keran rusak, toilet bermasalah, air tidak mengalir, atau fasilitas air lainnya.',
            'AC & Pendingin' => 'AC tidak dingin, AC mati, kipas rusak, atau masalah pendinginan lainnya.',
            'Peralatan IT' => 'Komputer tidak menyala, monitor, keyboard, mouse, atau perangkat IT lainnya.',
            'Jaringan Wi-Fi' => 'Koneksi Wi-Fi bermasalah, sinyal lemah, atau jaringan yang tidak tersedia.',
            'Pintu & Jendela' => 'Pintu, kunci, jendela, atau fasilitas sejenis yang mengalami kerusakan.',
            'Struktur Bangunan' => 'Kerusakan lantai, dinding, plafon, atau bagian bangunan kampus lainnya.',
            'Kebersihan' => 'Ruangan kotor, tempat sampah penuh, atau fasilitas kebersihan yang bermasalah.',
        ];

        $categories = [];
        foreach ($categoryList as $name => $description) {
            $categories[$name] = Category::updateOrCreate(
                ['name' => $name],
                ['description' => $description]
            );
        }

        $jsonPath = base_path('../CampusCare_Beta/data/reports.json');
        if (file_exists($jsonPath)) {
            $items = json_decode((string) file_get_contents($jsonPath), true) ?? [];
            foreach ($items as $item) {
                $catName = trim((string) ($item['category'] ?? 'Ruang Kelas'));
                $category = $categories[$catName] ?? Category::firstOrCreate(['name' => $catName]);

                $rawLocation = trim((string) ($item['location'] ?? '-'));
                $parts = array_map('trim', explode(',', $rawLocation));
                $building = $parts[0] !== '' ? $parts[0] : '-';
                $floor = $parts[1] ?? null;
                $room = isset($parts[2]) ? implode(', ', array_slice($parts, 2)) : null;

                $location = Location::firstOrCreate([
                    'building' => $building,
                    'floor' => $floor,
                    'room' => $room,
                ]);

                $status = $item['status'] ?? 'Menunggu';
                if (!in_array($status, ['Menunggu', 'Diajukan', 'Diverifikasi', 'Diproses', 'Selesai'], true)) {
                    $status = 'Menunggu';
                }

                $report = Report::updateOrCreate(
                    [
                        'title' => (string) ($item['title'] ?? 'Laporan'),
                        'reported_at' => $item['date'] ?? now()->toDateString(),
                    ],
                    [
                        'user_id' => $mahasiswa->id,
                        'category_id' => $category->id,
                        'location_id' => $location->id,
                        'description' => (string) ($item['description'] ?? ''),
                        'image' => $item['image'] ?? null,
                        'status' => $status,
                    ]
                );

                ReportHistory::firstOrCreate(
                    [
                        'report_id' => $report->id,
                        'status' => $status,
                    ],
                    [
                        'user_id' => $status === 'Menunggu' ? $mahasiswa->id : $admin->id,
                        'note' => 'Data awal diimpor dari reports.json',
                    ]
                );
            }
        }
    }
}
