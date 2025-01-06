<?php

class Car {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }

    public function getCars() {
        $query = "SELECT * FROM vehicule"; 
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getCarById($id) {
        $query = "SELECT * FROM vehicule WHERE idVehicule = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt;
    }

    public function updateCar($id, $model, $price, $available) {
        $query = "UPDATE vehicule SET modele = :model, prix = :price, disponible = :available WHERE idVehicule = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':model', $model);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':available', $available);
        return $stmt->execute();
    }

    public function deleteCar($id) {
        $query = "DELETE FROM vehicule WHERE idVehicule = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }


}

?>


