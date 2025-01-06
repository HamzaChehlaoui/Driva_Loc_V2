<?php

require_once('conn.php');
session_start();
$id_userr= $_SESSION['idUser'];
if (isset($_GET['idVehicule'])) {
    $idVehicule = $_GET['idVehicule'];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $pickup_date = $_POST['pickup_date'];
    $return_date = $_POST['return_date'];
    $pickup_location = $_POST['pickup_location'];
    $return_location = $_POST['return_location'];
    $notes = $_POST['notes'];
    $statut='Processing';
    $vehicule=   $idVehicule ;

    $database = new Database();
    
    $conn = $database->getConnection();

    if ($conn) {
        try {
            $stmt = $conn->prepare("INSERT INTO reservation ( dateDebut, dateFin, Pickup_location, Return_location, Additional_notes, statut, vehiculeId, userId) 
                                    VALUES (:pickup_date, :return_date, :pickup_location, :return_location, :notes ,:statut, :vehicule, :id_userr)");

    
            $stmt->bindParam(':pickup_date', $pickup_date);
            $stmt->bindParam(':return_date', $return_date);
            $stmt->bindParam(':pickup_location', $pickup_location);
            $stmt->bindParam(':return_location', $return_location);
            $stmt->bindParam(':notes', $notes);
            $stmt->bindParam(':statut', $statut);
            $stmt->bindParam(':vehicule', $vehicule);
            $stmt->bindParam(':id_userr', $id_userr);

            $stmt->execute();

            echo "Reservation successful! Thank you for choosing our service.";
            header('Location:showcare.php');
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Database connection failed!";
    }

    $conn = null;
} else {
    header("Location: reservationuser.php");
    exit;
}
?>