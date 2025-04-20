<?php
// Include database and object files
require_once "config/db.php";
require_once "class/kendaraan.php";

// Database connection
$database = new Database();
$db = $database->getConnection();

// Initialize object
$kendaraan = new Kendaraan($db);

// Process form submission
$message = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['create'])) {
        // Create operation
        $kendaraan->tipe_kendaraan = $_POST['tipe_kendaraan'];
        $kendaraan->nama_kendaraan = $_POST['nama_kendaraan'];
        
        if($kendaraan->create()) {
            $message = "<div class='alert alert-success'>Kendaraan berhasil ditambahkan.</div>";
        } else {
            $message = "<div class='alert alert-danger'>Gagal menambahkan kendaraan.</div>";
        }
    } else if(isset($_POST['update'])) {
        // Update operation
        $kendaraan->id = $_POST['id'];
        $kendaraan->tipe_kendaraan = $_POST['tipe_kendaraan'];
        $kendaraan->nama_kendaraan = $_POST['nama_kendaraan'];
        
        if($kendaraan->update()) {
            $message = "<div class='alert alert-success'>Kendaraan berhasil diperbarui.</div>";
        } else {
            $message = "<div class='alert alert-danger'>Gagal memperbarui kendaraan.</div>";
        }
    } else if(isset($_POST['delete'])) {
        // Delete operation
        $kendaraan->id = $_POST['id'];
        
        if($kendaraan->delete()) {
            $message = "<div class='alert alert-success'>Kendaraan berhasil dihapus.</div>";
        } else {
            $message = "<div class='alert alert-danger'>Gagal menghapus kendaraan.</div>";
        }
    }
}

// Read all kendaraan
$result = $kendaraan->read();
$num = $result->rowCount();

include_once "view/header.php";
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Daftar Kendaraan</h2>
        </div>
        <div class="col-md-6 text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus"></i> Tambah Kendaraan
            </button>
        </div>
    </div>

    <?php echo $message; ?>

    <div class="card shadow mb-4">
        <div class="card-body">
            <?php if($num > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tipe Kendaraan</th>
                            <th>Nama Kendaraan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['tipe_kendaraan']; ?></td>
                            <td><?php echo $row['nama_kendaraan']; ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#updateModal<?php echo $row['id']; ?>">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row['id']; ?>">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                        
                        <!-- Update Modal -->
                        <div class="modal fade" id="updateModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateModalLabel">Edit Kendaraan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="POST">
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <div class="mb-3">
                                                <label for="tipe_kendaraan" class="form-label">Tipe Kendaraan</label>
                                                <input type="text" class="form-control" id="tipe_kendaraan" name="tipe_kendaraan" value="<?php echo $row['tipe_kendaraan']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nama_kendaraan" class="form-label">Nama Kendaraan</label>
                                                <input type="text" class="form-control" id="nama_kendaraan" name="nama_kendaraan" value="<?php echo $row['nama_kendaraan']; ?>" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" name="update" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Hapus Kendaraan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="POST">
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <p>Apakah Anda yakin ingin menghapus kendaraan <?php echo $row['nama_kendaraan']; ?>?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" name="delete" class="btn btn-danger">Hapus</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <p>Tidak ada data kendaraan.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Tambah Kendaraan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tipe_kendaraan" class="form-label">Tipe Kendaraan</label>
                        <input type="text" class="form-control" id="tipe_kendaraan" name="tipe_kendaraan" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_kendaraan" class="form-label">Nama Kendaraan</label>
                        <input type="text" class="form-control" id="nama_kendaraan" name="nama_kendaraan" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="create" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once "view/footer.php"; ?>