<?php
class Kendaraan {
    private $conn;
    private $table_name = "kendaraan";
    
    public $id;
    public $tipe_kendaraan;
    public $nama_kendaraan;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Read all kendaraan
    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    // Read one kendaraan
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->tipe_kendaraan = $row['tipe_kendaraan'];
        $this->nama_kendaraan = $row['nama_kendaraan'];
    }
    
    // Create kendaraan
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET tipe_kendaraan=:tipe_kendaraan, nama_kendaraan=:nama_kendaraan";
        $stmt = $this->conn->prepare($query);
        
        // Sanitize
        $this->tipe_kendaraan = htmlspecialchars(strip_tags($this->tipe_kendaraan));
        $this->nama_kendaraan = htmlspecialchars(strip_tags($this->nama_kendaraan));
        
        // Bind values
        $stmt->bindParam(":tipe_kendaraan", $this->tipe_kendaraan);
        $stmt->bindParam(":nama_kendaraan", $this->nama_kendaraan);
        
        // Execute
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // Update kendaraan
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET tipe_kendaraan=:tipe_kendaraan, nama_kendaraan=:nama_kendaraan WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        
        // Sanitize
        $this->tipe_kendaraan = htmlspecialchars(strip_tags($this->tipe_kendaraan));
        $this->nama_kendaraan = htmlspecialchars(strip_tags($this->nama_kendaraan));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Bind values
        $stmt->bindParam(":tipe_kendaraan", $this->tipe_kendaraan);
        $stmt->bindParam(":nama_kendaraan", $this->nama_kendaraan);
        $stmt->bindParam(":id", $this->id);
        
        // Execute
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // Delete kendaraan
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