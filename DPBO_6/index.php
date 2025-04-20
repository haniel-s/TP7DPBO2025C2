<?php
// Include database and object files
require_once "config/db.php";
require_once "class/kendaraan.php";
require_once "class/pelanggan.php";
require_once "class/list_antrian.php";

// Database connection
$database = new Database();
$db = $database->getConnection();

// Initialize objects
$kendaraan = new Kendaraan($db);
$pelanggan = new Pelanggan($db);
$antrian = new Antrian($db);

// Read data for dashboard counts
$kendaraan_stmt = $kendaraan->read();
$kendaraan_count = $kendaraan_stmt->rowCount();

$pelanggan_stmt = $pelanggan->read();
$pelanggan_count = $pelanggan_stmt->rowCount();

$antrian_stmt = $antrian->read();
$antrian_count = $antrian_stmt->rowCount();

// Page title
$page_title = "Dashboard";
include_once "view/header.php";
?>

<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Kendaraan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $kendaraan_count; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-car fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Pelanggan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $pelanggan_count; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Antrian Servis</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $antrian_count; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Antrian Servis Terbaru</h6>
                <a href="antrian.php" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <?php if($antrian_count > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Pelanggan</th>
                                <th>Kendaraan</th>
                                <th>Tipe Servis</th>
                                <th>Tanggal Antri</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Limit to 5 latest entries
                            $counter = 0;
                            while($row = $antrian_stmt->fetch(PDO::FETCH_ASSOC)) {
                                if($counter >= 5) break;
                                $counter++;
                            ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['nama_pelanggan']; ?></td>
                                <td><?php echo $row['nama_kendaraan'] . " (" . $row['tipe_kendaraan'] . ")"; ?></td>
                                <td><?php echo $row['tipe_servis']; ?></td>
                                <td><?php echo $row['tanggal_antri']; ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p>Tidak ada antrian servis saat ini.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include_once "view/footer.php"; ?>
