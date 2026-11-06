<?php
$scriptDirectory = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/public/index.php')), '/');
$projectBase = preg_replace('~/public$~', '', $scriptDirectory);
$projectBase = rtrim($projectBase, '/');
$publicBase = $projectBase . '/public';
$currentPage = $currentPage ?? 'home';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <script>if (sessionStorage.getItem('ccWipe')) document.documentElement.classList.add('wipe-pending');</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $currentPage === 'cara-kerja' ? 'Cara Kerja - CampusCare' : 'CampusCare - Sistem Pelaporan Fasilitas Kampus' ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" href="<?= htmlspecialchars($projectBase, ENT_QUOTES, 'UTF-8') ?>/img/campuscare-logo.png">

    <!-- Tailwind CSS (CDN). preflight dimatikan supaya style.css lama tidak berubah -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            corePlugins: { preflight: false },
            theme: {
                extend: {
                    colors: {
                        brand: { DEFAULT: '#1663e8', dark: '#0f4bc4', soft: '#e6efff' },
                        ink: '#0b1f44'
                    },
                    fontFamily: {
                        sans: ['Poppins', 'Segoe UI', 'sans-serif'],
                        display: ['"Poppins"', 'Segoe UI', 'sans-serif']
                    }
                }
            }
        };
    </script>

    <link rel="stylesheet" href="<?= htmlspecialchars($projectBase, ENT_QUOTES, 'UTF-8') ?>/style.css">
</head>

<body>

    <div class="progress-bar"></div>

    <!-- NAVBAR -->
    <header class="navbar">
        <nav class="nav-container">

            <!-- LOGO CAMPUSCARE -->
            <a href="<?= $currentPage === 'home' ? '#beranda' : htmlspecialchars($publicBase, ENT_QUOTES, 'UTF-8') . '/index.php#beranda' ?>" class="brand" aria-label="Kembali ke Beranda">
            <div class="brand">
                <div class="brand-icon">
                    <img src="<?= htmlspecialchars($projectBase, ENT_QUOTES, 'UTF-8') ?>/img/campuscare-logo.png" alt="CampusCare Logo">
                </div>
                <span class="brand-name">CampusCare</span>
            </div>
            </a>

      <ul class="nav-menu">
    <li><a href="<?= $currentPage === 'home' ? '#beranda' : htmlspecialchars($publicBase, ENT_QUOTES, 'UTF-8') . '/index.php#beranda' ?>" class="nav-link">Beranda</a></li>
    <li><a href="<?= $currentPage === 'home' ? '#laporan' : htmlspecialchars($publicBase, ENT_QUOTES, 'UTF-8') . '/index.php#laporan' ?>" class="nav-link">Laporan</a></li>

    <!-- CARA KERJA: mega menu menuju halaman cara-kerja.html -->
    <li class="has-mega">
        <a href="<?= htmlspecialchars($publicBase, ENT_QUOTES, 'UTF-8') ?>/index.php?route=cara-kerja" class="nav-link">Cara Kerja</a>
        <div class="mega">
            <div class="mega-panel">
                <div class="mega-list">
                    <a href="<?= htmlspecialchars($publicBase, ENT_QUOTES, 'UTF-8') ?>/index.php?route=cara-kerja#kategori" class="mega-item">
                        <span class="mega-ico">🗂️</span>
                        <span><b>Kategori Fasilitas</b><small>Pilih fasilitas yang ingin dilaporkan.</small></span>
                    </a>
                    <a href="<?= htmlspecialchars($publicBase, ENT_QUOTES, 'UTF-8') ?>/index.php?route=cara-kerja#langkah-1" class="mega-item">
                        <span class="mega-ico">📋</span>
                        <span><b>Pilih Kategori</b><small>Tentukan fasilitas yang bermasalah.</small></span>
                    </a>
                    <a href="<?= htmlspecialchars($publicBase, ENT_QUOTES, 'UTF-8') ?>/index.php?route=cara-kerja#langkah-2" class="mega-item">
                        <span class="mega-ico">✍️</span>
                        <span><b>Isi Detail</b><small>Lokasi, deskripsi, dan foto bukti.</small></span>
                    </a>
                    <a href="<?= htmlspecialchars($publicBase, ENT_QUOTES, 'UTF-8') ?>/index.php?route=cara-kerja#langkah-3" class="mega-item">
                        <span class="mega-ico">📊</span>
                        <span><b>Pantau Status</b><small>Menunggu, diproses, selesai.</small></span>
                    </a>
                </div>
                <a href="#" data-action="report" class="mega-card c-blue">
                    <b>Mulai Lapor</b><small>Buat laporan baru sekarang</small>
                </a>
                <a href="<?= htmlspecialchars($publicBase, ENT_QUOTES, 'UTF-8') ?>/index.php#laporan" class="mega-card c-green">
                    <b>Cek Status</b><small>Pantau progres laporanmu</small>
                </a>
            </div>
        </div>
    </li>

    <li><a href="<?= $currentPage === 'home' ? '#tentang' : htmlspecialchars($publicBase, ENT_QUOTES, 'UTF-8') . '/index.php#tentang' ?>" class="nav-link">Tentang</a></li>
</ul>

            <div class="flex items-center gap-3">
                <button type="button" id="loginBtn" class="rounded-full border border-solid border-[#e0e0e0] bg-white px-4 py-2 text-sm font-semibold text-ink transition hover:border-brand hover:text-brand">Masuk</button>

                <div id="userChip" class="hidden items-center gap-2 rounded-full border border-solid border-[#e0e0e0] bg-white py-1 pl-4 pr-1">
                    <div class="leading-tight">
                        <b id="userName" class="block text-[13px] text-ink"></b>
                        <small id="userRole" class="text-xs text-[#5b6b86]"></small>
                    </div>
                    <button type="button" id="logoutBtn" class="rounded-full bg-brand-soft px-3 py-1.5 text-xs font-semibold text-brand hover:bg-brand hover:text-white">Keluar</button>
                </div>

                <button class="btn-primary">Buat Laporan</button>
            </div>

            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>

        </nav>
    </header>
