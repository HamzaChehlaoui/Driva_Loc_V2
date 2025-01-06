<?php
class Statistics {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getTotalReservations() {
        $query = "SELECT COUNT(*) AS total_reservations FROM Reservation";
        $result = $this->conn->query($query);
        if ($result) {
            return $result->fetch(PDO::FETCH_ASSOC)['total_reservations'];
        } else {
            return "erour";
        }
    }

    public function getTotalVehicules() {
        $query = "SELECT COUNT(*) AS total_vehicules FROM Vehicule";
        $result = $this->conn->query($query);
        if ($result) {
            return $result->fetch(PDO::FETCH_ASSOC)['total_vehicules'];
        } else {
            return "erour";
        }
    }

    public function getTotalAvis() {
        $query = "SELECT COUNT(*) AS total_avis FROM Avis";
        $result = $this->conn->query($query);
        if ($result) {
            return $result->fetch(PDO::FETCH_ASSOC)['total_avis'];
        } else {
            return "erour";
        }
    }
    public function getavis() {
        $query = "SELECT * FROM Avis";
        $result = $this->conn->query($query);
        if($result) {
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return "error";
        }
    }
    
}
?>
