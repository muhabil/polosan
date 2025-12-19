<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Mahasiswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .card-header {
            background-color: #0d6efd; /* Bootstrap primary blue */
            color: white;
        }
        .form-label {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container mt-4 mb-5 px-5">
        <div class="card shadow-sm">
            <div class="card-header text-center">
                <h1 class="h4 mb-0">Form Penilaian Mahasiswa</h1>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Masukkan Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Agus" required value="<?php echo isset($_POST['nama']) ? $_POST['nama'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="nim" class="form-label">Masukkan NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" placeholder="202332xxx" required value="<?php echo isset($_POST['nim']) ? $_POST['nim'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="kehadiran" class="form-label">Nilai Kehadiran (10%)</label>
                        <input type="number" class="form-control" id="kehadiran" name="kehadiran" placeholder="0 - 100" min="0" max="100" required value="<?php echo isset($_POST['kehadiran']) ? $_POST['kehadiran'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="tugas" class="form-label">Nilai Tugas (20%)</label>
                        <input type="number" class="form-control" id="tugas" name="tugas" placeholder="0 - 100" min="0" max="100" required value="<?php echo isset($_POST['tugas']) ? $_POST['tugas'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="uts" class="form-label">Nilai UTS (30%)</label>
                        <input type="number" class="form-control" id="uts" name="uts" placeholder="0 - 100" min="0" max="100" required value="<?php echo isset($_POST['uts']) ? $_POST['uts'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="uas" class="form-label">Nilai UAS (40%)</label>
                        <input type="number" class="form-control" id="uas" name="uas" placeholder="0 - 100" min="0" max="100" required value="<?php echo isset($_POST['uas']) ? $_POST['uas'] : ''; ?>">
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" name="proses" class="btn btn-primary">Proses</button>
                    </div>
                </form>

                <?php
                // Logika PHP dimulai di sini
                if (isset($_POST['proses'])) {
                    // 1. Ambil data dari form
                    $nama = $_POST['nama'];
                    $nim = $_POST['nim'];
                    $kehadiran = floatval($_POST['kehadiran']);
                    $tugas = floatval($_POST['tugas']);
                    $uts = floatval($_POST['uts']);
                    $uas = floatval($_POST['uas']);

                    // 2. Hitung Nilai Akhir sesuai bobot
                    // Kehadiran 10%, Tugas 20%, UTS 30%, UAS 40%
                    $nilai_akhir = ($kehadiran * 0.1) + ($tugas * 0.2) + ($uts * 0.3) + ($uas * 0.4);

                    // 3. Tentukan Grade
                    if ($nilai_akhir >= 80) {
                        $grade = "A";
                    } elseif ($nilai_akhir >= 70) {
                        $grade = "B";
                    } elseif ($nilai_akhir >= 60) {
                        $grade = "C";
                    } elseif ($nilai_akhir >= 50) {
                        $grade = "D";
                    } else {
                        $grade = "E";
                    }

                    // 4. Tentukan Status Kelulusan (Lulus jika nilai >= 60 / Grade C ke atas)
                    if ($nilai_akhir >= 60) {
                        $keterangan = "LULUS";
                        $warna_alert = "alert-success"; // Hijau
                    } else {
                        $keterangan = "TIDAK LULUS";
                        $warna_alert = "alert-danger"; // Merah
                    }

                    // 5. Tampilkan Hasil
                    echo "<div class='alert $warna_alert mt-4' role='alert'>";
                    echo "<h4 class='alert-heading'>Hasil Penilaian</h4>";
                    echo "<p class='mb-1'><strong>NIM:</strong> $nim</p>";
                    echo "<p class='mb-1'><strong>Nama:</strong> $nama</p>";
                    echo "<hr>";
                    echo "<p class='mb-1'>Nilai Akhir: <strong>" . number_format($nilai_akhir, 2) . "</strong></p>";
                    echo "<p class='mb-1'>Grade: <strong>$grade</strong></p>";
                    echo "<p class='mb-0'>Keterangan: <strong>$keterangan</strong></p>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>