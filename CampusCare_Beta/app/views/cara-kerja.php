<?php
$currentPage = 'cara-kerja';
require_once __DIR__ . '/partials/header.php';
?>

<!-- MVC - View: markup presentasi halaman Cara Kerja. -->
<main>

        <!-- CATEGORIES SECTION -->
        <section id="kategori" class="categories-section">

            <div class="section-header">
                <h2>Kategori Fasilitas Kampus</h2>
                <p>Pilih kategori fasilitas yang mengalami kerusakan atau membutuhkan perbaikan</p>
            </div>

            <div class="categories-container">

                <div class="category-card">
                    <div class="card-icon">🪑</div>
                    <h3>Ruang Kelas</h3>
                    <p>Laporkan kerusakan meja, kursi, papan tulis, proyektor, dan fasilitas kelas lainnya.</p>
                    <button class="btn-card">Lapor Sekarang</button>
                </div>

                <div class="category-card">
                    <div class="card-icon">💡</div>
                    <h3>Listrik & Penerangan</h3>
                    <p>Laporkan lampu mati, stop kontak rusak, saklar bermasalah, atau gangguan listrik lainnya.</p>
                    <button class="btn-card">Lapor Sekarang</button>
                </div>

                <div class="category-card">
                    <div class="card-icon">🚿</div>
                    <h3>Fasilitas Air</h3>
                    <p>Laporkan keran rusak, toilet bermasalah, air tidak mengalir, atau fasilitas air lainnya.</p>
                    <button class="btn-card">Lapor Sekarang</button>
                </div>

                <div class="category-card">
                    <div class="card-icon">❄️</div>
                    <h3>AC & Pendingin</h3>
                    <p>Laporkan AC tidak dingin, AC mati, kipas rusak, atau masalah pendinginan lainnya.</p>
                    <button class="btn-card">Lapor Sekarang</button>
                </div>

                <div class="category-card">
                    <div class="card-icon">🖥️</div>
                    <h3>Peralatan IT</h3>
                    <p>Laporkan komputer tidak menyala, monitor, keyboard, mouse, atau perangkat IT lainnya.</p>
                    <button class="btn-card">Lapor Sekarang</button>
                </div>

                <div class="category-card">
                    <div class="card-icon">📶</div>
                    <h3>Jaringan Wi-Fi</h3>
                    <p>Laporkan koneksi Wi-Fi bermasalah, sinyal lemah, atau jaringan yang tidak tersedia.</p>
                    <button class="btn-card">Lapor Sekarang</button>
                </div>

                <div class="category-card">
                    <div class="card-icon">🚪</div>
                    <h3>Pintu & Jendela</h3>
                    <p>Laporkan pintu, kunci, jendela, atau fasilitas sejenis yang mengalami kerusakan.</p>
                    <button class="btn-card">Lapor Sekarang</button>
                </div>

                <div class="category-card">
                    <div class="card-icon">🏢</div>
                    <h3>Struktur Bangunan</h3>
                    <p>Laporkan kerusakan lantai, dinding, plafon, atau bagian bangunan kampus lainnya.</p>
                    <button class="btn-card">Lapor Sekarang</button>
                </div>

                <div class="category-card">
                    <div class="card-icon">🗑️</div>
                    <h3>Kebersihan</h3>
                    <p>Laporkan ruangan kotor, tempat sampah penuh, atau fasilitas kebersihan yang bermasalah.</p>
                    <button class="btn-card">Lapor Sekarang</button>
                </div>

            </div>
        </section>

        <!-- HOW IT WORKS SECTION -->
        <section id="cara-kerja" class="how-it-works">

            <div class="section-header">
                <h2>Bagaimana Cara Kerjanya?</h2>
                <p>Tiga langkah mudah untuk melaporkan fasilitas kampus yang bermasalah</p>
            </div>

            <div class="steps-container">

                <div class="step-card" id="langkah-1">
                    <div class="step-number">1</div>
                    <h3>Pilih Kategori</h3>
                    <p>Pilih kategori fasilitas yang bermasalah dari daftar yang tersedia.</p>
                    <div class="step-icon">📋</div>
                </div>

                <div class="step-arrow">→</div>

                <div class="step-card" id="langkah-2">
                    <div class="step-number">2</div>
                    <h3>Isi Detail</h3>
                    <p>Berikan deskripsi detail tentang masalah dan lokasi fasilitas yang rusak.</p>
                    <div class="step-icon">✍️</div>
                </div>

                <div class="step-arrow">→</div>

                <div class="step-card" id="langkah-3">
                    <div class="step-number">3</div>
                    <h3>Pantau Status</h3>
                    <p>Pantau progress perbaikan fasilitas Anda secara real-time.</p>
                    <div class="step-icon">📊</div>
                </div>

            </div>

        </section>

    </main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
