<?php 
include "../config/koneksi.php"; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Mitra</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Poppins', sans-serif;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .card-header {
            background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 20px;
        }
        .btn-primary-custom {
            background: linear-gradient(135deg, #0f2027 0%, #203a43 100%);
            color: white;
            border: none;
        }
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
        .badge-mitra {
            background-color: #e3f2fd;
            color: #0d47a1;
            border: 1px solid #bbdefb;
        }
    </style>
</head>
<body>

<div class="container mt-5 mb-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold"><i class="bi bi-building-fill me-2"></i> Data Mitra Kerjasama</h4>
            <a href="../index.php" class="btn btn-outline-light btn-sm"><i class="bi bi-arrow-left me-1"></i> Dashboard</a>
        </div>
        
        <div class="card-body p-4">
            <div class="d-flex justify-content-between mb-3">
                <a href="create.php" class="btn btn-primary-custom px-4 rounded-pill">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Mitra
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th width="25%">Nama Mitra</th>
                            <th width="15%">Jenis</th>
                            <th width="25%">Kontak Person (PIC)</th>
                            <th width="20%">Wilayah Operasional</th>
                            <th class="text-center" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php
                    $no = 1;
                    $query = mysqli_query($conn, "SELECT * FROM MITRA ORDER BY mitra_id DESC");
                    while($row = mysqli_fetch_assoc($query)){
                    ?>
                        <tr>
                            <td class="text-center fw-bold text-secondary"><?= $no++ ?></td>
                            <td>
                                <div class="fw-bold text-dark"><?= $row['nama_mitra'] ?></div>
                                <small class="text-muted"><i class="bi bi-geo-alt"></i> <?= $row['alamat_mitra'] ?></small>
                            </td>
                            <td><span class="badge badge-mitra rounded-pill"><?= $row['jenis_mitra'] ?></span></td>
                            <td>
                                <div class="fw-medium"><?= $row['kontak_person'] ?></div>
                                <small class="text-success"><i class="bi bi-whatsapp me-1"></i><?= $row['no_hp'] ?></small>
                            </td>
                            <td>
                                <span class="text-secondary"><i class="bi bi-map me-1"></i><?= $row['wilayah_operasional'] ?></span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="update.php?id=<?= $row['mitra_id'] ?>" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a onclick="return confirm('Hapus data mitra ini?')" href="delete.php?id=<?= $row['mitra_id'] ?>" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>

                    </tbody>
                </table>
            </div>
            
            <?php if(mysqli_num_rows($query) == 0): ?>
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-building-slash fs-1 d-block mb-2"></i>
                    Belum ada data mitra.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>