<?php
session_start();

if (!isset($_SESSION['idUser'])) {
    die("You must be logged in to rate a car.");
}

$user_id = $_SESSION['idUser'];

$reservation_id = $_POST['reservation_id'];
$car_id = $_POST['car_id'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];

include('conn.php');  

$database = new Database();
$conn = $database->getConnection();  

if ($conn === null) {
    die("Connection failed. Could not establish a database connection.");
}

$current_date = date('Y-m-d');

$query = "INSERT INTO Avis (note, commentaire, dateAvis, vehiculeId, userId) 
          VALUES (:note, :commentaire, :dateAvis, :vehiculeId, :userId)";
$stmt = $conn->prepare($query);

$stmt->bindParam(':note', $rating);
$stmt->bindParam(':commentaire', $comment);
$stmt->bindParam(':dateAvis', $current_date);
$stmt->bindParam(':vehiculeId', $car_id);
$stmt->bindParam(':userId', $user_id, PDO::PARAM_INT);  

if ($stmt->execute()) {
    echo "<p class='text-green-400'>Thank you for your rating!</p>";
    header('Location:user.php');
} else {
    echo "<p class='text-red-400'>Failed to submit your rating. Please try again.</p>";
}
?>
