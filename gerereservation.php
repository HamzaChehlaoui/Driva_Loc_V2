<?php
class ReservationManager {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getReservations() {
        $query = "SELECT r.*, u.emeil AS user_email, v.modele AS vehicule_modele 
                  FROM Reservation r
                  LEFT JOIN User u ON r.userId = u.idUser
                  LEFT JOIN Vehicule v ON r.vehiculeId = v.idVehicule";
        $result = $this->conn->query($query);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function acceptReservation($reservationId) {
        $query = "UPDATE Reservation SET statut = 'acceptable' WHERE idReservation = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $reservationId);
        return $stmt->execute();
    }

    public function rejectReservation($reservationId) {
        $query = "UPDATE Reservation SET statut = 'unacceptable' WHERE idReservation = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $reservationId);
        return $stmt->execute();
    }
}
?>
