<?php
class Pelanggan {
    private $conn;
    private $table_name = "pelanggan";
    
    public $id;
    public $nama_pelanggan;
    public $id_kendaraan;
    public $no_telepon;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Read all pelanggan with kendaraan details
    public function read() {
        $query = "SELECT p.id, p.nama_pelanggan, p.id_kendaraan, p.no_telepon, 
                  k.tipe_kendaraan, k.nama_kendaraan
                  FROM " . $this->table_name . " p
                  LEFT JOIN kendaraan k ON p.id_kendaraan = k.id
                  ORDER BY p.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    // Read one pelanggan
    public function readOne() {
        $query = "SELECT p.id, p.nama_pelanggan, p.id_kendaraan, p.no_telepon, 
                  k.tipe_kendaraan, k.nama_kendaraan
                  FROM " . $this->table_name . " p
                  LEFT JOIN kendaraan k ON p.id_kendaraan = k.id
                  WHERE p.id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->nama_pelanggan = $row['nama_pelanggan'];
        $this->id_kendaraan = $row['id_kendaraan'];
        $this->no_telepon = $row['no_telepon'];
    }
    
    // Create pelanggan
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET nama_pelanggan=:nama_pelanggan, 
                      id_kendaraan=:id_kendaraan, 
                      no_telepon=:no_telepon";
        $stmt = $this->conn->prepare($query);
        
        // Sanitize
        $this->nama_pelanggan = htmlspecialchars(strip_tags($this->nama_pelanggan));
        $this->id_kendaraan = htmlspecialchars(strip_tags($this->id_kendaraan));
        $this->no_telepon = htmlspecialchars(strip_tags($this->no_telepon));
        
        // Bind values
        $stmt->bindParam(":nama_pelanggan", $this->nama_pelanggan);
        $stmt->bindParam(":id_kendaraan", $this->id_kendaraan);
        $stmt->bindParam(":no_telepon", $this->no_telepon);
        
        // Execute
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // Update pelanggan
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nama_pelanggan=:nama_pelanggan, 
                      id_kendaraan=:id_kendaraan, 
                      no_telepon=:no_telepon 
                  WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        
        // Sanitize
        $this->nama_pelanggan = htmlspecialchars(strip_tags($this->nama_pelanggan));
        $this->id_kendaraan = htmlspecialchars(strip_tags($this->id_kendaraan));
        $this->no_telepon = htmlspecialchars(strip_tags($this->no_telepon));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Bind values
        $stmt->bindParam(":nama_pelanggan", $this->nama_pelanggan);
        $stmt->bindParam(":id_kendaraan", $this->id_kendaraan);
        $stmt->bindParam(":no_telepon", $this->no_telepon);
        $stmt->bindParam(":id", $this->id);
        
        // Execute
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // Delete pelanggan
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
