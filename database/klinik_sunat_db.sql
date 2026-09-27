-- ==========================================================
-- DATABASE: klinik_sunat_db
-- SISTEM INFORMASI PELAYANAN RUMAH SUNAT ELNARA (KLINIK EL MEDIKA)
-- ==========================================================

CREATE DATABASE IF NOT EXISTS `klinik_sunat_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `klinik_sunat_db`;

-- ----------------------------------------------------------
-- 1. TABEL USERS (Autentikasi Multi-Role)
-- ----------------------------------------------------------
DROP TABLE IF EXISTS `wa_logs`;
DROP TABLE IF EXISTS `rekam_medis`;
DROP TABLE IF EXISTS `pendaftaran`;
DROP TABLE IF EXISTS `pasien`;
DROP TABLE IF EXISTS `dokter`;
DROP TABLE IF EXISTS `paket_sunat`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nama` VARCHAR(100) NOT NULL,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'dokter', 'pimpinan') NOT NULL DEFAULT 'admin',
  `no_hp` VARCHAR(20) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Password hash default untuk admin: 'admin123', dokter: 'dokter123', pimpinan: 'pimpinan123'
-- Hash bcrypt PHP:
-- admin123 => $2y$10$w3UqmzJ04kGZ6DqJvO2bO.80fX8b40Xwzrqc9kZ10h4gXq09g13aG (atau didukung fallback password_verify & plain jika perlu)
INSERT INTO `users` (`id`, `nama`, `username`, `password`, `role`, `no_hp`) VALUES
(1, 'Administrator Elnara', 'admin', '$2y$10$rY2.Uo4V/P2rM2qgK/m.nOUZ.Lw/kX4a45.bFkU08yUq5eQk6O2lW', 'admin', '081234567890'),
(2, 'dr. Rizky Ramadhan, Sp.B', 'dr_rizky', '$2y$10$rY2.Uo4V/P2rM2qgK/m.nOUZ.Lw/kX4a45.bFkU08yUq5eQk6O2lW', 'dokter', '081398765432'),
(3, 'Ns. Ahmad Fauzi, S.Kep', 'ns_fauzi', '$2y$10$rY2.Uo4V/P2rM2qgK/m.nOUZ.Lw/kX4a45.bFkU08yUq5eQk6O2lW', 'dokter', '081387654321'),
(4, 'Direktur / Pimpinan Klinik', 'pimpinan', '$2y$10$rY2.Uo4V/P2rM2qgK/m.nOUZ.Lw/kX4a45.bFkU08yUq5eQk6O2lW', 'pimpinan', '081277665544');

-- ----------------------------------------------------------
-- 2. TABEL DOKTER & TENAGA MEDIS
-- ----------------------------------------------------------
CREATE TABLE `dokter` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NULL,
  `nama_dokter` VARCHAR(100) NOT NULL,
  `spesialisasi` VARCHAR(100) NOT NULL,
  `no_hp` VARCHAR(20) NOT NULL,
  `hari_praktik` VARCHAR(150) NOT NULL,
  `jam_praktik` VARCHAR(100) NOT NULL,
  `status` ENUM('aktif', 'cuti') NOT NULL DEFAULT 'aktif',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `dokter` (`id`, `user_id`, `nama_dokter`, `spesialisasi`, `no_hp`, `hari_praktik`, `jam_praktik`, `status`) VALUES
(1, 2, 'dr. Rizky Ramadhan, Sp.B', 'Dokter Spesialis Bedah Anak & Khitan Modern', '081398765432', 'Senin - Sabtu', '08.00 - 16.00 WIB', 'aktif'),
(2, 3, 'Ns. Ahmad Fauzi, S.Kep', 'Praktisi Khitan Tersertifikasi & Mahdian Trainer', '081387654321', 'Setiap Hari Termasuk Minggu', '09.00 - 20.00 WIB', 'aktif');

-- ----------------------------------------------------------
-- 3. TABEL PAKET & METODE SUNAT
-- ----------------------------------------------------------
CREATE TABLE `paket_sunat` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nama_paket` VARCHAR(150) NOT NULL,
  `kategori_layanan` ENUM('anak', 'rumah', 'bayi', 'dewasa', 'premium') NOT NULL,
  `metode_sunat` ENUM('circum_pen', 'mahdian_klem', 'gun_stapler', 'konvensional_laser') NOT NULL,
  `harga` DECIMAL(12,2) NOT NULL,
  `deskripsi` TEXT NOT NULL,
  `keunggulan` TEXT NOT NULL,
  `fasilitas_include` TEXT NOT NULL,
  `gambar` VARCHAR(255) NULL,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `paket_sunat` (`id`, `nama_paket`, `kategori_layanan`, `metode_sunat`, `harga`, `deskripsi`, `keunggulan`, `fasilitas_include`, `gambar`, `is_active`) VALUES
(1, 'Sunat Anak - Mahdian Klem', 'anak', 'mahdian_klem', 1350000.00, 
 'Metode klem inovatif nomor 1 di Indonesia khusus anak. Tabung klem sekali pakai higienis tanpa jarum jahit dan perban.', 
 'Tanpa perban, tanpa jahitan, langsung bisa mandi kena air, minim rasa nyeri, anak bisa langsung bermain santai.', 
 '1 Set Mahdian Klem steril, Bius ramah anak tanpa jarum suntik, Obat pereda nyeri & antibiotik paten, 2 pcs Celana Sunat, Kontrol gratis sampai sembuh, Piagam & Medali Keberanian', 
 'mahdian_klem.jpg', 1),

(2, 'Sunat Anak - Circum Pen Super', 'anak', 'circum_pen', 1500000.00, 
 'Metode cauter generasi terbaru menggunakan electric sealer pen canggih berpresisi mikron. Memotong dan menghentikan perdarahan secara instan.', 
 'Proses tindakan kilat (10-15 menit), perdarahan minimal, hasil potongan presisi & estetik, proses penyembuhan cepat.', 
 'Tindakan Circum Pen Super, Bius lokal nyaman tanpa jarum suntik, Paket obat lengkap (analgesik, antibiotik, salep), 2 pcs Celana Sunat, Kontrol pasca tindakan gratis, Sertifikat Keberanian', 
 'circum_pen.jpg', 1),

(3, 'Sunat Di Rumah (Home Care) - Mahdian Klem', 'rumah', 'mahdian_klem', 1850000.00, 
 'Layanan istimewa sirkumsisi langsung di kediaman Anda oleh tim dokter & perawat profesional. Memberikan kenyamanan maksimal tanpa anak harus bepergian.', 
 'Anak merasa tenang di rumah sendiri, privasi keluarga terjaga penuh, tim medis datang dengan peralatan steril lengkap, tanpa antre di klinik.', 
 'Kunjungan tim dokter & paramedis ke rumah, 1 Set Mahdian Klem disposabel, Bius nyaman tanpa jarum, Paket obat lengkap pasca tindakan, 2 pcs Celana Sunat, Free konsultasi & pendampingan WA 24 jam', 
 'home_care.jpg', 1),

(4, 'Sunat Di Rumah (Home Care) - Circum Pen Super', 'rumah', 'circum_pen', 1950000.00, 
 'Layanan Home Visit tindakan sunat modern circum pen super di rumah. Cepat, bersih, dan higienis tanpa perlu keluar rumah.', 
 'Tim medis datang membawa perangkat Circum Pen steril, penanganan ramah anak, luka cepat kering dan tanpa risiko kontak di ruang tunggu.', 
 'Kunjungan tim medis ke rumah, Bius nyaman, Alat Circum Pen Super steril, Paket obat lengkap, 2 pcs Celana Sunat, Kontrol ke rumah / klinik bebas biaya', 
 'home_circum.jpg', 1),

(5, 'Sunat Premium VIP - Gun Stapler', 'premium', 'gun_stapler', 2850000.00, 
 'Paket eksklusif bintang lima menggunakan instrumen bedah Gun Stapler mutakhir. Dirancang untuk hasil sirkumsisi paling simetris, presisi tinggi, dan penyembuhan terdepan.', 
 'Alat Gun Stapler disposabel sekali pakai, potongan dan staples terpasang simultan dalam 1 detik, luka langsung tertutup rapat sempurna, waktu tindakan sangat singkat (7-10 menit), hasil estetik tingkat tinggi.', 
 'Alat Disposable Gun Stapler orisinal, Bius ekstra nyaman bebas nyeri, Goodie Bag eksklusif & mainan anak, Paket obat premium paten impor, 3 pcs Celana Sunat, Bebas kontrol tanpa batas hingga pulih sempurna, Pendampingan dokter via WhatsApp VIP', 
 'gun_stapler.jpg', 1),

(6, 'Sunat Dewasa - Gun Stapler Premium', 'dewasa', 'gun_stapler', 2500000.00, 
 'Solusi sirkumsisi dewasa paling modern dan nyaman. Mengutamakan privasi tinggi, hasil estetik rapi, dan waktu pemulihan sangat cepat.', 
 'Jaminan privasi 100%, dikerjakan dokter spesialis, tidak mengganggu aktivitas kerja, staples lepas mandiri secara alami seiring pemulihan.', 
 'Instrumen Gun Stapler steril, Bius lokal anestesi optimal, Paket obat dewasa lengkap, Konsultasi privasi khusus, Celana pelindung dewasa, Kontrol berkala hingga tuntas', 
 'dewasa_stapler.jpg', 1),

(7, 'Sunat Dewasa - Circum Pen Presisi', 'dewasa', 'circum_pen', 2100000.00, 
 'Sirkumsisi dewasa dengan teknologi pen cauter modern. Solusi ekonomis dengan kualitas estetik terjaga dan higienis.', 
 'Penanganan profesional dokter pria, minim pendarahan, jahitan estetik rapi dengan benang yang dapat diserap tubuh (absorbable).', 
 'Tindakan Circum Pen, Paket obat pasca tindakan lengkap, Kontrol gratis, Celana sunat dewasa', 
 'dewasa_pen.jpg', 1),

(8, 'Sunat Bayi - Mahdian Klem Baby Care', 'bayi', 'mahdian_klem', 1400000.00, 
 'Penanganan sirkumsisi khusus bayi usia 0-12 bulan. Menggunakan klem mini berukuran anatomis khusus bayi dengan teknik super lembut.', 
 'Proses sangat cepat (5-7 menit), regenerasi sel bayi sangat pesat sehingga pulih dalam 3-5 hari, bayi tetap bisa memakai popok/diaper dengan nyaman.', 
 '1 Set Mahdian Klem Baby steril, Anestesi topikal & infiltrasi lembut, Paket salep & obat tetes bayi, Kassa & perban steril cadangan, Pemantauan khusus oleh tim medis', 
 'bayi_klem.jpg', 1);

-- ----------------------------------------------------------
-- 4. TABEL DATA MASTER PASIEN
-- ----------------------------------------------------------
CREATE TABLE `pasien` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `no_rm` VARCHAR(30) NOT NULL UNIQUE,
  `nik` VARCHAR(30) NULL,
  `nama_pasien` VARCHAR(100) NOT NULL,
  `tanggal_lahir` DATE NOT NULL,
  `usia_tahun` INT NOT NULL DEFAULT 0,
  `usia_bulan` INT NOT NULL DEFAULT 0,
  `jenis_kelamin` ENUM('L', 'P') NOT NULL DEFAULT 'L',
  `nama_ortu_wali` VARCHAR(100) NOT NULL,
  `no_wa` VARCHAR(25) NOT NULL,
  `alamat_lengkap` TEXT NOT NULL,
  `catatan_riwayat_penyakit` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `pasien` (`id`, `no_rm`, `nik`, `nama_pasien`, `tanggal_lahir`, `usia_tahun`, `usia_bulan`, `jenis_kelamin`, `nama_ortu_wali`, `no_wa`, `alamat_lengkap`, `catatan_riwayat_penyakit`) VALUES
(1, 'RM-2026-0001', '1871012345670001', 'Muhammad Fatih Al-Ghifari', '2018-05-14', 8, 4, 'L', 'Bpk. Hendra Gunawan', '081234567801', 'Jl. Raden Intan No. 45, Enggal, Bandar Lampung', 'Tidak ada riwayat alergi obat'),
(2, 'RM-2026-0002', '1871012345670002', 'Kenzo Putra Pratama', '2019-11-20', 6, 10, 'L', 'Ibu Ratna Dewi', '081234567802', 'Perumahan Way Halim Permai Blok B2 No. 12, Bandar Lampung', 'Alergi dingin ringan'),
(3, 'RM-2026-0003', '1871012345670003', 'Arkan Danendra', '2026-01-10', 0, 8, 'L', 'Bpk. Aditya Firmansyah', '081234567803', 'Jl. Teuku Umar No. 88, Kedaton, Bandar Lampung', 'Sehat, bayi cukup bulan');

-- ----------------------------------------------------------
-- 5. TABEL PENDAFTARAN & ANTREAN
-- ----------------------------------------------------------
CREATE TABLE `pendaftaran` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `no_registrasi` VARCHAR(35) NOT NULL UNIQUE,
  `no_antrean` VARCHAR(20) NOT NULL,
  `id_pasien` INT NOT NULL,
  `id_paket` INT NOT NULL,
  `id_dokter` INT NOT NULL,
  `jenis_layanan` ENUM('klinik', 'home_care') NOT NULL DEFAULT 'klinik',
  `alamat_home_care` TEXT NULL,
  `tanggal_kunjungan` DATE NOT NULL,
  `jam_kunjungan` TIME NOT NULL,
  `keluhan_awal` TEXT NULL,
  `total_biaya` DECIMAL(12,2) NOT NULL,
  `status_pelayanan` ENUM('menunggu', 'terkonfirmasi', 'tindakan', 'selesai', 'batal') NOT NULL DEFAULT 'menunggu',
  `status_pembayaran` ENUM('belum_bayar', 'lunas') NOT NULL DEFAULT 'belum_bayar',
  `catatan_admin` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_pasien`) REFERENCES `pasien`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`id_paket`) REFERENCES `paket_sunat`(`id`),
  FOREIGN KEY (`id_dokter`) REFERENCES `dokter`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `pendaftaran` (`id`, `no_registrasi`, `no_antrean`, `id_pasien`, `id_paket`, `id_dokter`, `jenis_layanan`, `alamat_home_care`, `tanggal_kunjungan`, `jam_kunjungan`, `keluhan_awal`, `total_biaya`, `status_pelayanan`, `status_pembayaran`, `catatan_admin`) VALUES
(1, 'REG-20260921-001', 'A-01', 1, 1, 1, 'klinik', NULL, '2026-09-21', '09:00:00', 'Fimosis ringan, anak minta disunat saat libur sekolah', 1350000.00, 'selesai', 'lunas', 'Pasien kooperatif dan tindakan berjalan lancar'),
(2, 'REG-20260921-002', 'H-01', 2, 3, 2, 'home_care', 'Perumahan Way Halim Permai Blok B2 No. 12, Bandar Lampung (Dekat Masjid Al-Ikhlas)', '2026-09-21', '13:30:00', 'Ingin sunat di rumah agar anak tidak cemas', 1850000.00, 'tindakan', 'lunas', 'Tim medis dalam perjalanan menuju lokasi rumah'),
(3, 'REG-20260921-003', 'A-02', 3, 8, 1, 'klinik', NULL, '2026-09-21', '15:00:00', 'Sunat bayi sesuai anjuran medis', 1400000.00, 'terkonfirmasi', 'belum_bayar', 'Sudah diverifikasi via WA, orang tua konfirmasi hadir');

-- ----------------------------------------------------------
-- 6. TABEL REKAM MEDIS DIGITAL
-- ----------------------------------------------------------
CREATE TABLE `rekam_medis` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_pendaftaran` INT NOT NULL,
  `id_pasien` INT NOT NULL,
  `id_dokter` INT NOT NULL,
  `tanggal_tindakan` DATETIME NOT NULL,
  `berat_badan` DECIMAL(5,2) NOT NULL DEFAULT 0.00,
  `tensi_darah` VARCHAR(20) DEFAULT '110/70',
  `riwayat_alergi_obat` TEXT NULL,
  `kondisi_anatomis` TEXT NULL,
  `metode_digunakan` VARCHAR(100) NOT NULL,
  `catatan_tindakan` TEXT NOT NULL,
  `resep_obat` TEXT NOT NULL,
  `instruksi_pasca_sunat` TEXT NOT NULL,
  `tanggal_kontrol_ulang` DATE NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`id_pasien`) REFERENCES `pasien`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`id_dokter`) REFERENCES `dokter`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `rekam_medis` (`id`, `id_pendaftaran`, `id_pasien`, `id_dokter`, `tanggal_tindakan`, `berat_badan`, `tensi_darah`, `riwayat_alergi_obat`, `kondisi_anatomis`, `metode_digunakan`, `catatan_tindakan`, `resep_obat`, `instruksi_pasca_sunat`, `tanggal_kontrol_ulang`) VALUES
(1, 1, 1, 1, '2026-09-21 09:30:00', 25.50, '105/70', 'Tidak ada alergi', 'Preputium normal, perlengketan smegma minimal', 'Mahdian Klem No. 16', 
 'Tindakan desinfeksi aseptik, anestesi tanpa jarum (Comfort-in Free Needle), pelepasan smegma, pemasangan tabung Mahdian Klem No. 16. Klem terpasang kuat, hemostasis baik.', 
 '1. Paracetamol sirup 250mg 3x1 cth\n2. Amoxicillin sirup 250mg 3x1 cth\n3. Minyak tetes klem herbal 3x2 tetes', 
 'Klem boleh kena air setelah 6 jam. Mandi air biasa diperbolehkan. Hindari aktivitas bersepeda dan benturan selama 5 hari. Gunakan celana sunat pelindung.', '2026-09-26');

-- ----------------------------------------------------------
-- 7. TABEL LOG NOTIFIKASI WHATSAPP
-- ----------------------------------------------------------
CREATE TABLE `wa_logs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `id_pendaftaran` INT NULL,
  `no_wa_tujuan` VARCHAR(30) NOT NULL,
  `jenis_notifikasi` ENUM('konfirmasi_daftar', 'pengingat_jadwal', 'status_antrean', 'jadwal_kontrol', 'pesan_manual') NOT NULL,
  `isi_pesan` TEXT NOT NULL,
  `status_kirim` ENUM('terkirim', 'pending', 'gagal') NOT NULL DEFAULT 'terkirim',
  `sent_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `wa_logs` (`id`, `id_pendaftaran`, `no_wa_tujuan`, `jenis_notifikasi`, `isi_pesan`, `status_kirim`) VALUES
(1, 1, '081234567801', 'konfirmasi_daftar', 
 'Halo Bpk. Hendra Gunawan, pendaftaran sunat untuk ananda Muhammad Fatih Al-Ghifari di Rumah Sunat Elnara telah BERHASIL diverifikasi.\nNo Registrasi: REG-20260921-001\nNo Antrean: A-01\nPaket: Sunat Anak - Mahdian Klem\nJadwal: 21 September 2026 pukul 09:00 WIB di Klinik El Medika.\nTerima kasih!', 'terkirim'),
(2, 2, '081234567802', 'konfirmasi_daftar', 
 'Halo Ibu Ratna Dewi, reservasi Layanan Sunat Di Rumah (Home Care) ananda Kenzo Putra Pratama telah TERKONFIRMASI.\nNo Registrasi: REG-20260921-002\nNo Antrean: H-01\nPaket: Sunat Di Rumah - Mahdian Klem\nJadwal Kunjungan Tim Medis: 21 September 2026 pukul 13:30 WIB.\nAlamat: Perumahan Way Halim Permai Blok B2 No. 12, Bandar Lampung.\nTim medis kami akan menghubungi 30 menit sebelum kedatangan.', 'terkirim');

