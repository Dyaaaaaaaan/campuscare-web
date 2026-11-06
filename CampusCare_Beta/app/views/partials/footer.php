<?php
$scriptDirectory = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/public/index.php')), '/');
$projectBase = rtrim((string) preg_replace('~/public$~', '', $scriptDirectory), '/');
$publicBase = $projectBase . '/public';
?>

<footer class="footer">

        <div class="footer-container">

                <div class="footer-section">
                <h4>Kontak</h4>

                <ul>
                    <li>Email: info@campuscare.id</li>
                    <li>Phone: (0341) 464-2002</li>
                    <li>Alamat: Universitas Muhammadiyah Malang</li>
                </ul>

            </div>
            <div class="footer-section">
                <h4>CampusCare</h4>
                <p>Platform pelaporan fasilitas kampus yang modern dan responsif.</p>
            </div>

            <div class="footer-section">
                <h4>Media Sosial</h4>

                <div class="social-links">
                    <a href="#">Facebook</a>
                    <a href="#">Instagram</a>
                    <a href="#">Twitter</a>
                </div>

            </div>

        </div>

        <div class="footer-bottom">
            <p>&copy; 2026 CampusCare. Semua hak dilindungi.</p>
        </div>

    </footer>

    <!-- REPORT MODAL -->
    <div class="modal" id="reportModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle" aria-hidden="true">

        <div class="modal-card">

            <button type="button" class="modal-close" aria-label="Tutup">×</button>

            <h2 id="modalTitle">Buat laporan baru</h2>

            <p class="modal-sub">
                Ceritakan kerusakannya, kami teruskan ke tim sarana dan prasarana.
            </p>

            <form id="reportForm" novalidate>

                <label class="field sel">
                    <select name="category"></select>
                    <span>Kategori</span>
                </label>

                <label class="field">
                    <input name="title" placeholder=" " maxlength="80">
                    <span>Judul laporan</span>
                </label>

                <label class="field">
                    <input name="location" placeholder=" " maxlength="80">
                    <span>Lokasi (gedung, lantai, ruang)</span>
                </label>

                <label class="field">
                    <textarea name="description" rows="4" placeholder=" " maxlength="400"></textarea>
                    <span>Deskripsi masalah</span>
                </label>

                <div class="field-file">
                    <label for="reportImage" class="flex cursor-pointer items-center justify-center gap-2 rounded-xl border-2 border-dashed border-[#e0e0e0] bg-[#f9fbff] p-3.5 text-center transition hover:border-brand hover:bg-brand-soft/40">
                        <span class="text-xl">📷</span>
                        <span class="text-sm font-semibold text-ink" id="uploadLabelText">Unggah Foto Bukti (Opsional)</span>
                        <input type="file" id="reportImage" accept="image/*" class="hidden">
                    </label>
                    <div id="imagePreviewContainer" class="relative mt-2 hidden">
                        <img id="imagePreview" class="h-44 w-full rounded-xl object-cover border border-solid border-[#e0e0e0] shadow-sm" src="" alt="Pratinjau Bukti">
                        <button type="button" id="removeImageBtn" class="absolute right-2 top-2 rounded-full bg-red-600/90 px-3 py-1 text-xs font-bold text-white shadow hover:bg-red-700 backdrop-blur-sm">Hapus Foto</button>
                    </div>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-secondary modal-cancel">
                        Batal
                    </button>

                    <button type="submit" class="btn-primary">
                        Kirim laporan
                    </button>
                </div>

            </form>

        </div>

    </div>

    <!-- LOGIN MODAL -->
    <div id="loginModal" class="fixed inset-0 z-[400] hidden items-center justify-center bg-[#06122e]/55 p-5 backdrop-blur-sm" role="dialog" aria-modal="true" aria-labelledby="loginTitle" aria-hidden="true">
        <div class="relative w-full max-w-md rounded-3xl bg-white p-8 shadow-2xl">

            <button type="button" id="loginClose" aria-label="Tutup" class="absolute right-4 top-4 grid h-9 w-9 place-items-center rounded-full bg-[#f5f5f5] text-2xl leading-none text-ink hover:bg-brand-soft">&times;</button>

            <h2 id="loginTitle" class="font-display text-2xl font-bold text-ink">Masuk ke CampusCare</h2>
            <p class="mb-6 mt-1 text-sm text-[#5b6b86]">Pilih peran, lalu masukkan akun kamu.</p>

            <div class="mb-5 grid grid-cols-2 gap-1 rounded-xl bg-[#f0f4fb] p-1">
                <button type="button" data-role="mahasiswa" class="role-tab rounded-lg py-2 text-sm font-semibold">Mahasiswa</button>
                <button type="button" data-role="admin" class="role-tab rounded-lg py-2 text-sm font-semibold">Admin</button>
            </div>

            <form id="loginForm" class="grid gap-4" novalidate>
                <label class="grid gap-1.5 text-sm font-semibold text-ink">
                    <span id="idLabel">NIM</span>
                    <input name="username" autocomplete="username" class="w-full rounded-xl border-[1.5px] border-solid border-[#e0e0e0] px-3.5 py-3 font-normal outline-none focus:border-brand focus:ring-4 focus:ring-brand/15">
                </label>

                <label class="grid gap-1.5 text-sm font-semibold text-ink">
                    <span>Kata sandi</span>
                    <input type="password" name="password" autocomplete="current-password" class="w-full rounded-xl border-[1.5px] border-solid border-[#e0e0e0] px-3.5 py-3 font-normal outline-none focus:border-brand focus:ring-4 focus:ring-brand/15">
                </label>

                <p id="loginError" role="alert" class="hidden rounded-lg bg-red-50 px-3 py-2 text-sm text-red-700"></p>

                <button type="submit" class="btn-primary">Masuk</button>
                <p id="loginHint" class="text-center text-xs text-[#5b6b86]"></p>
            </form>

        </div>
    </div>

    

    <script>
        window.CAMPUSCARE_API_URL = <?= json_encode(
            $publicBase . '/index.php?route=api/reports',
            JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
        ) ?>;
        window.CAMPUSCARE_LOGO_URL = <?= json_encode(
            $projectBase . '/img/campuscare-logo.png',
            JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
        ) ?>;
    </script>
    <script src="<?= htmlspecialchars($projectBase, ENT_QUOTES, 'UTF-8') ?>/script.js"></script>

</body>
</html>
