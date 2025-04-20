<?php
class Antrian {
    private $conn;
    private $table_name = "list_antrian";
    
    public $id;
    public $id_pelanggan;
    public $tanggal_antri;
    public $tipe_servis;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Read all antrian with pelanggan details
    public function read() {
        $query = "SELECT a.id, a.id_pelanggan, a.tanggal_antri, a.tipe_servis,
                  p.nama_pelanggan, p.no_telepon,
                  k.tipe_kendaraan, k.nama_kendaraan
                  FROM " . $this->table_name . " a
                  LEFT JOIN pelanggan p ON a.id_pelanggan = p.id
                  LEFT JOIN kendaraan k ON p.id_kendaraan = k.id
                  ORDER BY a.tanggal_antri DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    // Read one antrian
    public function readOne() {
        $query = "SELECT a.id, a.id_pelanggan, a.tanggal_antri, a.tipe_servis,
                  p.nama_pelanggan, p.no_telepon,
                  k.tipe_kendaraan, k.nama_kendaraan
                  FROM " . $this->table_name . " a
                  LEFT JOIN pelanggan p ON a.id_pelanggan = p.id
                  LEFT JOIN kendaraan k ON p.id_kendaraan = k.id
                  WHERE a.id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->id_pelanggan = $row['id_pelanggan'];
        $this->tanggal_antri = $row['tanggal_antri'];
        $this->tipe_servis = $row['tipe_servis'];
    }
    
    // Create antrian
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET id_pelanggan=:id_pelanggan, 
                      tanggal_antri=:tanggal_antri, 
                      tipe_servis=:tipe_servis";
        $stmt = $this->conn->prepare($query);
        
        // Sanitize
        $this->id_pelanggan = htmlspecialchars(strip_tags($this->id_pelanggan));
        $this->tanggal_antri = htmlspecialchars(strip_tags($this->tanggal_antri));
        $this->tipe_servis = htmlspecialchars(strip_tags($this->tipe_servis));
        
        // Bind values
        $stmt->bindParam(":id_pelanggan", $this->id_pelanggan);
        $stmt->bindParam(":tanggal_antri", $this->tanggal_antri);
        $stmt->bindParam(":tipe_servis", $this->tipe_servis);
        
        // Execute
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // Update antrian
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET id_pelanggan=:id_pelanggan, 
                      tanggal_antri=:tanggal_antri, 
                      tipe_servis=:tipe_servis 
                  WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        
        // Sanitize
        $this->id_pelanggan = htmlspecialchars(strip_tags($this->id_pelanggan));
        $this->tanggal_antri = htmlspecialchars(strip_tags($this->tanggal_antri));
        $this->tipe_servis = htmlspecialchars(strip_tags($this->tipe_servis));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Bind values
        $stmt->bindParam(":id_pelanggan", $this->id_pelanggan);
        $stmt->bindParam(":tanggal_antri", $this->tanggal_antri);
        $stmt->bindParam(":tipe_servis", $this->tipe_servis);
        $stmt->bindParam(":id", $this->id);
        
        // Execute
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // Delete antrian
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        
        // Sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Bind id
        $stmt->bindParam(1, $this->id);
        
        // Execute
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
