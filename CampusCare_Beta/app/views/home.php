<?php
$currentPage = 'home';
require_once __DIR__ . '/partials/header.php';
?>

<!-- MVC - View: menampilkan konten dan data laporan yang disiapkan controller. -->
<!-- MAIN CONTENT -->
    <main>

        <!-- HERO SECTION -->
        <section id="beranda" class="hero">
            <div class="hero-content">

                <div class="hero-badge">
                    <span class="badge-icon">✓</span>
                    <span class="badge-text">Lapor Fasilitas Kampus</span>
                </div>

                <h1 class="hero-title">
                    Laporkan Fasilitas Kampus yang Rusak dengan Mudah
                </h1>

                <p class="hero-subtitle">
                    Platform terpercaya untuk melaporkan kerusakan fasilitas kampus. Respons cepat dan solusi efektif untuk kenyamanan belajar Anda.
                </p>

                <div class="flex flex-wrap items-center gap-3">
                    <button class="btn-hero">
                        <span>🚀 Mulai Laporan</span>
                </button>

                 <a href="#reportList" class="inline-flex items-center gap-2 rounded-xl border-[1.5px] border-solid border-brand/40 bg-white/70 px-5 py-3 text-sm font-medium text-brand transition duration-300 hover:-translate-y-0.5 hover:border-brand hover:bg-brand-soft sm:px-7 sm:py-3.5 sm:text-base">
                        Cek Status Laporan <span aria-hidden="true">→</span>
                </a>
            </div>

         </div>

            <div class="hero-image">

                <div class="chip-float c1">
                    <i class="dot Selesai"></i>
                    <div>
                        <b>Lampu koridor Gedung A</b>
                        <small>Selesai · 2 jam lalu</small>
                    </div>
                </div>

                <div class="chip-float c2">
                    <i class="dot Diproses"></i>
                    <div>
                        <b>AC Ruang 301</b>
                        <small>Sedang ditangani teknisi</small>
                    </div>
                </div>

                <div class="image-placeholder">
                    <img src="<?= htmlspecialchars($projectBase, ENT_QUOTES, 'UTF-8') ?>/img/campus image.webp" alt="Gedung kampus Universitas Muhammadiyah Malang"
                        class="h-full w-full object-cover">
                        <div class="absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-[#f5f8ff] to-transparent"></div>
                    </div>
                </div>

        </section>

        <!-- SEARCH & FILTER SECTION -->
        <section id="laporan" class="search-section">
            <div class="search-container">

                <div class="search-box">
                    <input type="text" class="search-input" placeholder="Cari kategori fasilitas...">
                    <button class="search-btn">🔍</button>
                </div>

                <div class="filter-buttons">
                    <button class="filter-btn active">Semua</button>
                    <button class="filter-btn">Menunggu</button>
                    <button class="filter-btn">Diproses</button>
                    <button class="filter-btn">Selesai</button>
                </div>
                <div id="reportList" class="report-list" aria-live="polite">
                    <?php if (empty($reports)): ?>
                        <p>Belum ada laporan yang tersedia.</p>
                    <?php else: ?>
                        <?php foreach ($reports as $report): ?>
                            <article class="report-card">
                                <h3><?= htmlspecialchars($report->getTitle(), ENT_QUOTES, 'UTF-8') ?></h3>
                                <p><?= htmlspecialchars($report->getDescription(), ENT_QUOTES, 'UTF-8') ?></p>
                                <p><?= htmlspecialchars($report->getCategory(), ENT_QUOTES, 'UTF-8') ?> ? <?= htmlspecialchars($report->getLocation(), ENT_QUOTES, 'UTF-8') ?></p>
                                <span class="badge"><?= htmlspecialchars($report->getStatus(), ENT_QUOTES, 'UTF-8') ?></span>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
        </section>

        <!-- WELCOME SECTION -->
<section id="tentang" class="welcome-section">

    <!-- Judul -->
      
    <div class="mx-auto mb-10 max-w-[620px] text-center">
        <span class="mb-3 inline-block rounded-full bg-brand-soft px-3 py-1 text-xs font-bold tracking-wide text-brand">Kenapa CampusCare</span>
        <h2 class="mb-3 font-display text-[1.6rem] font-bold leading-[1.15] text-ink sm:text-4xl">Mengapa Memilih CampusCare?</h2>
        <p class="text-base leading-[1.7] text-[#666]">
            Platform modern untuk melaporkan masalah fasilitas kampus. Transparan, responsif, dan setiap laporan ditangani dengan cepat.
        </p>
    </div>

    <!-- Showcase: kartu kiri + panel visual kanan -->
    <div data-why class="welcome-container !grid-cols-1 !items-stretch !gap-4 lg:!grid-cols-[minmax(0,4fr)_minmax(0,7fr)] lg:!gap-6">

        <!-- KIRI: kartu accordion -->
        <div class="flex flex-col gap-3 lg:h-[460px]">

            <!-- Kartu 1 -->
            <div data-why-card data-active="true" style="--c:#1663e8"
                 class="group relative flex flex-[0_0_auto] flex-col overflow-hidden rounded-3xl bg-[color:var(--c)] text-white transition-[flex-grow,transform,filter] duration-500 hover:brightness-110 data-[active=true]:flex-[1_1_auto] data-[active=true]:-rotate-1">
                <button type="button" aria-expanded="true"
                        class="flex w-full cursor-pointer items-center gap-3 bg-transparent px-6 py-4 text-left text-white">
                    <span class="text-sm opacity-0 transition-opacity duration-300 group-data-[active=true]:opacity-100">▶</span>
                    <span class="-ml-6 font-display text-base font-bold transition-all duration-300 group-data-[active=true]:ml-0 group-data-[active=true]:text-2xl">Lapor sekali klik</span>
                </button>
                <div class="grid grid-rows-[0fr] px-6 opacity-0 transition-[grid-template-rows,opacity] duration-500 group-data-[active=true]:grid-rows-[1fr] group-data-[active=true]:opacity-100">
                    <div class="min-h-0 overflow-hidden">
                        <p class="pb-5 text-[15px] leading-relaxed text-white/90">Isi form singkat lalu kirim. Laporan langsung masuk ke tim sarana dan prasarana, tanpa antre dan tanpa bolak-balik.</p>
                    </div>
                </div>
                <span class="pointer-events-none absolute bottom-1 right-5 hidden font-display text-7xl font-extrabold leading-none text-white/15 opacity-0 transition-opacity duration-500 group-data-[active=true]:opacity-100 lg:block">01</span>
            </div>

            <!-- Kartu 2 -->
            <div data-why-card data-active="false" style="--c:#0f8a63"
                 class="group relative flex flex-[0_0_auto] flex-col overflow-hidden rounded-3xl bg-[color:var(--c)] text-white transition-[flex-grow,transform,filter] duration-500 hover:brightness-110 data-[active=true]:flex-[1_1_auto] data-[active=true]:-rotate-1">
                <button type="button" aria-expanded="false"
                        class="flex w-full cursor-pointer items-center gap-3 bg-transparent px-6 py-4 text-left text-white">
                    <span class="text-sm opacity-0 transition-opacity duration-300 group-data-[active=true]:opacity-100">▶</span>
                    <span class="-ml-6 font-display text-base font-bold transition-all duration-300 group-data-[active=true]:ml-0 group-data-[active=true]:text-2xl">Status real-time</span>
                </button>
                <div class="grid grid-rows-[0fr] px-6 opacity-0 transition-[grid-template-rows,opacity] duration-500 group-data-[active=true]:grid-rows-[1fr] group-data-[active=true]:opacity-100">
                    <div class="min-h-0 overflow-hidden">
                        <p class="pb-5 text-[15px] leading-relaxed text-white/90">Pantau laporanmu dari menunggu, diproses, sampai selesai. Setiap progres transparan dan bisa dilihat kapan saja.</p>
                    </div>
                </div>
                <span class="pointer-events-none absolute bottom-1 right-5 hidden font-display text-7xl font-extrabold leading-none text-white/15 opacity-0 transition-opacity duration-500 group-data-[active=true]:opacity-100 lg:block">02</span>
            </div>

            <!-- Kartu 3 -->
            <div data-why-card data-active="false" style="--c:#0b2a6f"
                 class="group relative flex flex-[0_0_auto] flex-col overflow-hidden rounded-3xl bg-[color:var(--c)] text-white transition-[flex-grow,transform,filter] duration-500 hover:brightness-125 data-[active=true]:flex-[1_1_auto] data-[active=true]:-rotate-1">
                <button type="button" aria-expanded="false"
                        class="flex w-full cursor-pointer items-center gap-3 bg-transparent px-6 py-4 text-left text-white">
                    <span class="text-sm opacity-0 transition-opacity duration-300 group-data-[active=true]:opacity-100">▶</span>
                    <span class="-ml-6 font-display text-base font-bold transition-all duration-300 group-data-[active=true]:ml-0 group-data-[active=true]:text-2xl">Lokasi jelas</span>
                </button>
                <div class="grid grid-rows-[0fr] px-6 opacity-0 transition-[grid-template-rows,opacity] duration-500 group-data-[active=true]:grid-rows-[1fr] group-data-[active=true]:opacity-100">
                    <div class="min-h-0 overflow-hidden">
                        <p class="pb-5 text-[15px] leading-relaxed text-white/90">Sertakan gedung, lantai, dan ruang agar teknisi langsung tahu harus ke mana dan perbaikan bisa lebih cepat.</p>
                    </div>
                </div>
                <span class="pointer-events-none absolute bottom-1 right-5 hidden font-display text-7xl font-extrabold leading-none text-white/15 opacity-0 transition-opacity duration-500 group-data-[active=true]:opacity-100 lg:block">03</span>
            </div>
            
            <div data-why-card data-active="false" style="--c:#0b2a6f"
                 class="group relative flex flex-[0_0_auto] flex-col overflow-hidden rounded-3xl bg-[color:var(--c)] text-white transition-[flex-grow,transform,filter] duration-500 hover:brightness-125 data-[active=true]:flex-[1_1_auto] data-[active=true]:-rotate-1">
                <button type="button" aria-expanded="false"
                        class="flex w-full cursor-pointer items-center gap-3 bg-transparent px-6 py-4 text-left text-white">
                    <span class="text-sm opacity-0 transition-opacity duration-300 group-data-[active=true]:opacity-100">▶</span>
                    <span class="-ml-6 font-display text-base font-bold transition-all duration-300 group-data-[active=true]:ml-0 group-data-[active=true]:text-2xl">Tentang CampusCare</span>
                </button>
                <div class="grid grid-rows-[0fr] px-6 opacity-0 transition-[grid-template-rows,opacity] duration-500 group-data-[active=true]:grid-rows-[1fr] group-data-[active=true]:opacity-100">
                    <div class="min-h-0 overflow-hidden">
                        <p class="pb-5 text-[15px] leading-relaxed text-white/90">CampusCare.</p>
                    </div>
                </div>
                <span class="pointer-events-none absolute bottom-1 right-5 hidden font-display text-7xl font-extrabold leading-none text-white/15 opacity-0 transition-opacity duration-500 group-data-[active=true]:opacity-100 lg:block">03</span>
            </div>
            
        </div>

        <!-- KANAN: panel visual -->
        <div class="relative min-h-[440px] overflow-hidden rounded-3xl bg-gradient-to-br from-[#143a85] to-[#0b1f44] shadow-[0_24px_48px_rgba(11,31,68,.25)] lg:min-h-0">

            <!-- Slide 1: form -->
            <div data-why-slide data-active="true" aria-hidden="false"
                 class="pointer-events-none absolute inset-0 flex translate-y-3 items-center justify-center p-5 pb-12 opacity-0 transition-all duration-500 data-[active=true]:pointer-events-auto data-[active=true]:translate-y-0 data-[active=true]:opacity-100 sm:p-8 sm:pb-12">
                <div class="w-full max-w-[380px] rounded-2xl bg-white p-5 shadow-[0_18px_40px_rgba(0,0,0,.3)]">
                    <p class="mb-3 font-display text-[15px] font-bold text-ink">Buat laporan baru</p>
                    <div class="grid gap-2.5">
                        <div class="rounded-xl border border-solid border-[#e0e0e0] px-3 py-2">
                            <small class="block text-[11px] font-semibold text-brand">Kategori</small>
                            <span class="text-sm text-ink">Listrik &amp; Penerangan</span>
                        </div>
                        <div class="rounded-xl border border-solid border-[#e0e0e0] px-3 py-2">
                            <small class="block text-[11px] font-semibold text-brand">Judul laporan</small>
                            <span class="text-sm text-ink">Lampu koridor mati</span>
                        </div>
                        <div class="rounded-xl border border-solid border-[#e0e0e0] px-3 py-2">
                            <small class="block text-[11px] font-semibold text-brand">Lokasi</small>
                            <span class="text-sm text-ink">Gedung A, Lantai 2</span>
                        </div>
                    </div>
                    <div class="mt-3.5 rounded-full bg-gradient-to-br from-[#2b7bff] to-[#0f4bc4] py-2.5 text-center text-sm font-semibold text-white">Kirim laporan</div>
                </div>
            </div>

            <!-- Slide 2: status -->
            <div data-why-slide data-active="false" aria-hidden="true"
                 class="pointer-events-none absolute inset-0 flex translate-y-3 items-center justify-center p-5 pb-12 opacity-0 transition-all duration-500 data-[active=true]:pointer-events-auto data-[active=true]:translate-y-0 data-[active=true]:opacity-100 sm:p-8 sm:pb-12">
                <div class="w-full max-w-[380px] rounded-2xl bg-white p-5 shadow-[0_18px_40px_rgba(0,0,0,.3)]">
                    <p class="mb-3 font-display text-[15px] font-bold text-ink">Status laporan</p>
                    <ul class="m-0 grid list-none gap-2.5 p-0">
                        <li class="grid grid-cols-[auto_1fr_auto] items-center gap-3 rounded-[14px] border border-solid border-[#e0e0e0] bg-white px-3.5 py-3">
                            <i class="dot Diproses"></i>
                            <div>
                                <b class="block text-sm leading-tight text-ink">AC Ruang 301</b>
                                <small class="text-xs text-[#5b6b86]">Ditangani teknisi</small>
                            </div>
                            <span class="status Diproses">Diproses</span>
                        </li>
                        <li class="grid grid-cols-[auto_1fr_auto] items-center gap-3 rounded-[14px] border border-solid border-[#e0e0e0] bg-white px-3.5 py-3">
                            <i class="dot Selesai"></i>
                            <div>
                                <b class="block text-sm leading-tight text-ink">Lampu koridor Gedung A</b>
                                <small class="text-xs text-[#5b6b86]">2 jam lalu</small>
                            </div>
                            <span class="status Selesai">Selesai</span>
                        </li>
                        <li class="grid grid-cols-[auto_1fr_auto] items-center gap-3 rounded-[14px] border border-solid border-[#e0e0e0] bg-white px-3.5 py-3">
                            <i class="dot Menunggu"></i>
                            <div>
                                <b class="block text-sm leading-tight text-ink">Keran toilet lantai 2</b>
                                <small class="text-xs text-[#5b6b86]">Baru masuk</small>
                            </div>
                            <span class="status Menunggu">Menunggu</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Slide 3: lokasi -->
            <div data-why-slide data-active="false" aria-hidden="true"
                 class="pointer-events-none absolute inset-0 flex translate-y-3 items-center justify-center p-5 pb-12 opacity-0 transition-all duration-500 data-[active=true]:pointer-events-auto data-[active=true]:translate-y-0 data-[active=true]:opacity-100 sm:p-8 sm:pb-12">
                <div class="w-full max-w-[380px] rounded-2xl bg-white p-5 shadow-[0_18px_40px_rgba(0,0,0,.3)]">
                    <p class="mb-3 font-display text-[15px] font-bold text-ink">Lokasi laporan</p>
                    <div class="mb-3 flex flex-wrap items-center gap-1.5 text-xs font-semibold text-ink">
                        <span class="rounded-full bg-[#f3f7ff] px-2.5 py-1">Gedung A</span>
                        <span class="text-[#5b6b86]">›</span>
                        <span class="rounded-full bg-[#f3f7ff] px-2.5 py-1">Lantai 3</span>
                        <span class="text-[#5b6b86]">›</span>
                        <span class="rounded-full bg-brand px-2.5 py-1 text-white">Ruang 301</span>
                    </div>
                    <div class="grid grid-cols-4 gap-1.5 rounded-xl bg-[#f3f7ff] p-3">
                        <span class="h-11 rounded-lg bg-white"></span>
                        <span class="h-11 rounded-lg bg-white"></span>
                        <span class="h-11 rounded-lg bg-white"></span>
                        <span class="h-11 rounded-lg bg-white"></span>
                        <span class="h-11 rounded-lg bg-white"></span>
                        <span class="grid h-11 place-items-center rounded-lg bg-brand-soft text-lg ring-2 ring-brand">📍</span>
                        <span class="h-11 rounded-lg bg-white"></span>
                        <span class="h-11 rounded-lg bg-white"></span>
                    </div>
                    <div class="mt-3 flex items-center gap-2.5 rounded-xl border border-solid border-[#e0e0e0] p-2.5">
                        <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-brand-soft text-sm">🔧</span>
                        <div>
                            <b class="block text-[13px] leading-tight text-ink">Teknisi ditugaskan</b>
                            <small class="text-xs text-[#5b6b86]">Menuju lokasi laporan</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SLide 4-->
            <div data-why-slide data-active="false" aria-hidden="true"
                 class="pointer-events-none absolute inset-0 flex translate-y-3 items-center justify-center p-5 pb-12 opacity-0 transition-all duration-500 data-[active=true]:pointer-events-auto data-[active=true]:translate-y-0 data-[active=true]:opacity-100 sm:p-8 sm:pb-12">
                <div class="w-full max-w-[380px] rounded-2xl bg-white p-5 shadow-[0_18px_40px_rgba(0,0,0,.3)]">
                    <p class="mb-3 font-display text-[15px] font-bold text-ink">Tentang CampusCare</p>
                    <p class="text-sm text-[#5b6b86]">CampusCare adalah inisiatif dari Universitas Muhammadiyah Malang untuk meningkatkan kualitas hidup akademik melalui sistem pelaporan fasilitas yang transparan dan responsif. Kami percaya bahwa setiap mahasiswa berhak mendapatkan lingkungan belajar yang optimal</p>
                </div>

            <!-- Indikator -->
            <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2">
                <button type="button" data-why-dot data-active="true" aria-label="Tampilkan: Lapor sekali klik"
                        class="h-2 w-2 rounded-full bg-white/40 p-0 transition-all duration-300 data-[active=true]:w-6 data-[active=true]:bg-white"></button>
                <button type="button" data-why-dot data-active="false" aria-label="Tampilkan: Status real-time"
                        class="h-2 w-2 rounded-full bg-white/40 p-0 transition-all duration-300 data-[active=true]:w-6 data-[active=true]:bg-white"></button>
                <button type="button" data-why-dot data-active="false" aria-label="Tampilkan: Lokasi jelas"
                        class="h-2 w-2 rounded-full bg-white/40 p-0 transition-all duration-300 data-[active=true]:w-6 data-[active=true]:bg-white"></button>
                <button type="button" data-why-dot data-active="false" aria-label="Tampilkan: Lokasi jelas"
                        class="h-2 w-2 rounded-full bg-white/40 p-0 transition-all duration-300 data-[active=true]:w-6 data-[active=true]:bg-white"></button>
            </div>
        </div>
     </div>

    </div>

    <div class="mt-10 flex justify-center">
        <button class="btn-secondary">
            Pelajari Lebih Lanjut
        </button>
    </div>

</section>

       

        <!-- CTA SECTION -->
        <section class="cta-section">

            <div class="cta-content">
                <h2>Siap Membuat Kampus Lebih Baik?</h2>
                <p>Laporkan sekarang dan bantu kami menjaga fasilitas kampus tetap dalam kondisi optimal</p>
                <button class="btn-cta">Buat Laporan Pertama Anda</button>
            </div>

        </section>

    </main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
