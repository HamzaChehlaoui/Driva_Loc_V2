<?php
require_once 'conn.php';

class Category {
    private $conn;
    private $table_name = "categorie";  // Name of the table


    public $nom;
    public $description;


    public function __construct($db) {
        $this->conn = $db;
    }

 
    public function addCategory() {
        $query = "INSERT INTO " . $this->table_name . " (nom, description) VALUES (:nom, :description)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':description', $this->description);

        // Execute the query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
