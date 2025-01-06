<?php
include('conn.php');
session_start();

$user_id = $_SESSION['idUser'];  

$database = new Database();
$conn = $database->getConnection();  

if (isset($_GET['id'])) {
    $reservationId = $_GET['id'];

    $query = "SELECT * FROM `reservation` WHERE `idReservation` = :id AND `userId` = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $reservationId);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$reservation) {
        echo "You do not have the authority to modify this reservation.";
        exit;
    }
    if($reservation['statut']=='acceptable'){
        echo "You do not have the authority to modify this reservation.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update reservation
    $dateDebut = $_POST['dateDebut'];
    $dateFin = $_POST['dateFin'];
    $statut = 'Processing';
    $pickupLocation = $_POST['pickupLocation'];
    $returnLocation = $_POST['returnLocation'];

    $updateQuery = "UPDATE `reservation` SET `dateDebut` = :dateDebut, `dateFin` = :dateFin, 
                    `statut` = :statut, `Pickup_Location` = :pickupLocation, `Return_Location` = :returnLocation 
                    WHERE `idReservation` = :id";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bindParam(':dateDebut', $dateDebut);
    $stmt->bindParam(':dateFin', $dateFin);
    $stmt->bindParam(':statut', $statut);
    $stmt->bindParam(':pickupLocation', $pickupLocation);
    $stmt->bindParam(':returnLocation', $returnLocation);
    $stmt->bindParam(':id', $reservationId);

    if ($stmt->execute()) {
        echo "<div class='text-green-500'>valid</div>";
        header("Location: showReserv.php");
    } else {
        echo "<div class='text-red-500'>invalid</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white">

    <div class="max-w-6xl mx-auto my-12 p-6 bg-gray-800 rounded-lg shadow-lg">
        <h2 class="text-3xl font-bold text-center text-indigo-400 mb-6">Edit Reservation</h2>

        <form method="POST" action="">
            <div class="mb-6">
                <label for="dateDebut" class="block text-sm">Reservation Start Date</label>
                <input type="date" name="dateDebut" value="<?= htmlspecialchars($reservation['dateDebut']); ?>" class="w-full px-4 py-2 bg-gray-700 rounded-lg" required>
            </div>

            <div class="mb-6">
                <label for="dateFin" class="block text-sm">Reservation End Date</label>
                <input type="date" name="dateFin" value="<?= htmlspecialchars($reservation['dateFin']); ?>" class="w-full px-4 py-2 bg-gray-700 rounded-lg" required>
            </div>

            <div class="mb-6">
                <label for="pickupLocation" class="block text-sm">status</label>
                <input type="text" name="pickupLocation" value="<?= htmlspecialchars($reservation['Pickup_Location']); ?>" class="w-full px-4 py-2 bg-gray-700 rounded-lg" required>
            </div>

            <div class="mb-6">
                <label for="pickupLocation" class="block text-sm">Statut</label>
                <input disabled type="text" name="pickupLocation" value="<?= $reservation['statut']; ?>" class="w-full px-4 py-2 bg-gray-700 rounded-lg" required>
            </div>

            <div class="mb-6">
                <label for="returnLocation" class="block text-sm">Return Location</label>
                <input type="text" name="returnLocation" value="<?= htmlspecialchars($reservation['Return_Location']); ?>" class="w-full px-4 py-2 bg-gray-700 rounded-lg" required>
            </div>

            <button type="submit" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white py-2 px-4 rounded-lg">Update Reservation</button>
        </form>
    </div>
</body>
</html>
