<?php
include('conn.php');
include('Care.php');

$db = new Database();
$connection = $db->getConnection();

$car = new Car($connection);

$carId = isset($_GET['id']) ? $_GET['id'] : die('Car ID not provided');

$stmt = $car->getCarById($carId);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $model = $_POST['model'];
    $price = $_POST['price'];
    $available = $_POST['available'];
    
    if ($car->updateCar($carId, $model, $price, $available)) {
        echo "Car updated successfully!";
        header('Location:admin.php');
    } else {
        echo "Failed to update car.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Car</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white">

    <div class="container mx-auto py-10">
        <h2 class="text-3xl font-semibold mb-6">Edit Car Details</h2>
        
        <form method="POST" action="editcare.php?id=<?php echo $carId; ?>" class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <div class="mb-4">
                <label for="model" class="block text-lg font-semibold">Car Model</label>
                <input type="text" name="model" id="model" value="<?php echo htmlspecialchars($row['modele']); ?>" class="w-full p-3 bg-gray-700 text-white rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="price" class="block text-lg font-semibold">Price</label>
                <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($row['prix']); ?>" class="w-full p-3 bg-gray-700 text-white rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="available" class="block text-lg font-semibold">Availability</label>
                <select name="available" class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-600 bg-gray-900 text-white focus:ring-indigo-500 focus:border-indigo-500" required>
                <option value="available">Available</option>
                <option value="unavailable">Unavailable</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-lg">Update Car</button>
        </form>
    </div>
    
</body>
</html>
