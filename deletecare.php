<?php
require('conn.php');
require('Care.php');

$db = new Database();
$connection = $db->getConnection();

$car = new Car($connection);

$carId = isset($_GET['id']) ? $_GET['id'] : die('Car ID not provided');

if ($car->deleteCar($carId)) {
    echo "Car deleted successfully!";
    header("Location: admin.php"); 
    exit();
} else {
    echo "Failed to delete car.";
}
?>
