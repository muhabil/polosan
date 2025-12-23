<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Mahasiswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body { background-color: #f8f9fa; }
        .card-header-form { background-color: #0d6efd; color: white; }
        
        .card-result { border: 1px solid #ddd; border-radius: 5px; margin-top: 20px; overflow: hidden; background: white;}
        .header-lulus { background-color: #198754; color: white; padding: 10px 15px; font-weight: bold; }
        .header-gagal { background-color: #dc3545; color: white; padding: 10px 15px; font-weight: bold; }
        .btn-lulus { background-color: #198754; color: white; border: none; }
        .btn-lulus:hover { background-color: #157347; color: white; }
        .btn-gagal { background-color: #dc3545; color: white; border: none; }
        .btn-gagal:hover { background-color: #bb2d3b; color: white; }
    </style>
</head>

<body>
    <div class="container mt-4 mb-5 px-5">
        <div class="card shadow-sm">
            <div class="card-header card-header-form text-center">
                <h1 class="h4 mb-0">Form Penilaian Mahasiswa</h1>
            </div>
            <div class="card-body">
                <form method="post" id="formPenilaian">
                    <div class="mb-3">
                        <label class="form-label">Masukkan Nama</label>
                        <input type="text" class="form-control" name="nama" value="<?php echo $_POST['nama'] ?? ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Masukkan NIM</label>
                        <input type="text" class="form-control" name="nim" value="<?php echo $_POST['nim'] ?? ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nilai Kehadiran (10%)</label>
                        <input type="number" class="form-control" name="kehadiran" placeholder="0 - 100" value="<?php echo $_POST['kehadiran'] ?? ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nilai Tugas (20%)</label>
                        <input type="number" class="form-control" name="tugas" placeholder="0 - 100" value="<?php echo $_POST['tugas'] ?? ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nilai UTS (30%)</label>
                        <input type="number" class="form-control" name="uts" placeholder="0 - 100" value="<?php echo $_POST['uts'] ?? ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nilai UAS (40%)</label>
                        <input type="number" class="form-control" name="uas" placeholder="0 - 100" value="<?php echo $_POST['uas'] ?? ''; ?>">
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" name="proses" class="btn btn-primary">Proses</button>
                    </div>
                </form>

                <?php
                if (isset($_POST['proses'])) {
                    
                    if (trim($_POST['nama']) == "" || trim($_POST['nim']) == "" || $_POST['kehadiran'] == "" || $_POST['tugas'] == "" || $_POST['uts'] == "" || $_POST['uas'] == "") {
                        echo "
                        <div class='alert alert-danger mt-3' role='alert'>
                            Semua kolom harus diisi!
                        </div>";
                    } else {
                        $nama = $_POST['nama'];
                        $nim = $_POST['nim'];
                        $absen = floatval($_POST['kehadiran']);
                        $tugas = floatval($_POST['tugas']);
                        $uts = floatval($_POST['uts']);
                        $uas = floatval($_POST['uas']);

                        $nilai_akhir = ($absen * 0.1) + ($tugas * 0.2) + ($uts * 0.3) + ($uas * 0.4);

                        if ($nilai_akhir >= 80) $grade = "A";
                        elseif ($nilai_akhir >= 70) $grade = "B";
                        elseif ($nilai_akhir >= 60) $grade = "C";
                        elseif ($nilai_akhir >= 50) $grade = "D";
                        else $grade = "E";

                        $lulus = true;
                        if ($nilai_akhir < 60) $lulus = false;
                        if ($absen <= 70) $lulus = false; 
                        if ($tugas < 40 || $uts < 40 || $uas < 40) $lulus = false;

                        if ($lulus) {
                            $status_text = "LULUS";
                            $status_color = "text-success";
                            $header_class = "header-lulus";
                            $btn_class = "btn-lulus";
                        } else {
                            $status_text = "TIDAK LULUS";
                            $status_color = "text-danger";
                            $header_class = "header-gagal";
                            $btn_class = "btn-gagal";
                        }

                        echo "
                        <div class='card-result'>
                            <div class='$header_class'>
                                Hasil Penilaian
                            </div>
                            <div class='p-3'>
                                <div class='row mb-3'>
                                    <div class='col-md-6 text-center'>
                                        <h4>Nama: $nama</h4>
                                    </div>
                                    <div class='col-md-6 text-center'>
                                        <h4>NIM: $nim</h4>
                                    </div>
                                </div>

                                <p class='mb-1'><strong>Nilai Kehadiran:</strong> {$absen}%</p>
                                <p class='mb-1'><strong>Nilai Tugas:</strong> $tugas</p>
                                <p class='mb-1'><strong>Nilai UTS:</strong> $uts</p>
                                <p class='mb-1'><strong>Nilai UAS:</strong> $uas</p>
                                <br>
                                <p class='mb-1'><strong>Nilai Akhir:</strong> " . number_format($nilai_akhir, 2) . "</p>
                                <p class='mb-1'><strong>Grade:</strong> $grade</p>
                                <p class='mb-1'><strong>Status:</strong> <span class='$status_color fw-bold'>$status_text</span></p>
                            </div>
                            <div class='d-grid gap-2 p-3'>
                                <button onclick='resetForm()' class='btn $btn_class'>Selesai</button>
                            </div>
                        </div>
                        ";
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }

        function resetForm() {
            window.location.href = window.location.pathname;
        }
    </script>
</body>
</html>
