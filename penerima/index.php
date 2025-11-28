<?php 
include "../config/koneksi.php"; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Penerima</title>
    
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
        .status-badge {
            font-size: 0.85em;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="container mt-5 mb-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold"><i class="bi bi-people-fill me-2"></i> Data Penerima Bantuan</h4>
            <a href="../index.php" class="btn btn-outline-light btn-sm"><i class="bi bi-arrow-left me-1"></i> Dashboard</a>
        </div>
        
        <div class="card-body p-4">
            <div class="d-flex justify-content-between mb-3">
                <a href="create.php" class="btn btn-primary-custom px-4 rounded-pill">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Penerima
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th width="20%">Nama Lengkap</th>
                            <th width="25%">Alamat</th>
                            <th width="15%">Kategori</th>
                            <th width="15%">Penghasilan</th>
                            <th class="text-center" width="10%">Tanggungan</th> 
                            <th class="text-center" width="10%">Status</th>
                            <th class="text-center" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php
                    $no = 1;
                    $query = mysqli_query($conn, "SELECT * FROM PENERIMA ORDER BY penerima_id DESC");
                    while($row = mysqli_fetch_assoc($query)){
                    ?>
                        <tr>
                            <td class="text-center fw-bold text-secondary"><?= $no++ ?></td>
                            <td>
                                <div class="fw-bold text-dark"><?= $row['nama_lengkap'] ?></div>
                                <small class="text-muted"><i class="bi bi-person-badge"></i> ID: <?= $row['penerima_id'] ?></small>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 200px;"><?= $row['alamat'] ?></div>
                                <small class="text-muted"><?= $row['kelurahan'] ?>, <?= $row['kecamatan'] ?></small>
                            </td>
                            <td><span class="badge bg-light text-dark border"><?= $row['kategori_penerima'] ?></span></td>
                            <td class="fw-medium text-success">Rp <?= number_format($row['penghasilan_bulanan'],0,',','.') ?></td>
                            
                            <td class="text-center">
                                <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary">
                                    <i class="bi bi-people me-1"></i><?= $row['jumlah_tanggungan'] ?>
                                </span>
                            </td>
                            
                            <td class="text-center">
                                <?php 
                                if($row['status_validasi'] == 'Valid'){
                                    echo '<span class="badge bg-success status-badge"><i class="bi bi-check-circle me-1"></i>Valid</span>';
                                } elseif($row['status_validasi'] == 'Tidak Valid'){
                                    echo '<span class="badge bg-danger status-badge"><i class="bi bi-x-circle me-1"></i>Ditolak</span>';
                                } else {
                                    echo '<span class="badge bg-warning text-dark status-badge"><i class="bi bi-hourglass-split me-1"></i>Proses</span>';
                                }
                                ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="update.php?id=<?= $row['penerima_id'] ?>" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a onclick="return confirm('Hapus data penerima ini?')" href="delete.php?id=<?= $row['penerima_id'] ?>" class="btn btn-sm btn-outline-danger" title="Hapus">
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
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    Belum ada data penerima.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>