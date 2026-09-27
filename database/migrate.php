<?php
// Script Import Database klinik_sunat_db
$host = '127.0.0.1';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    echo "Koneksi MySQL Berhasil!\n";

    $sqlFile = __DIR__ . '/klinik_sunat_db.sql';
    if (!file_exists($sqlFile)) {
        die("File SQL tidak ditemukan: $sqlFile\n");
    }

    $sql = file_get_contents($sqlFile);

    // Eksekusi skema
    $pdo->exec($sql);
    echo "Database `klinik_sunat_db` dan seluruh tabel berhasil dibuat & diisi seeder!\n";

    // Verifikasi tabel
    $pdo->exec("USE `klinik_sunat_db`");
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Daftar Tabel Terbentuk (" . count($tables) . "):\n";
    foreach ($tables as $t) {
        echo "- $t\n";
    }
} catch (PDOException $e) {
    echo "Gagal: " . $e->getMessage() . "\n";
    exit(1);
}
