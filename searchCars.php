<?php
require('actionAddVehicles.php');
require('care.php');

$db = new Database();
$connection = $db->getConnection();  
$car = new Car($connection);

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

$carsPerPage = 3;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $carsPerPage;

$query = $connection->prepare("SELECT * FROM vehicule WHERE modele LIKE :searchQuery LIMIT :offset, :carsPerPage");
$query->bindValue(':searchQuery', '%' . $searchQuery . '%', PDO::PARAM_STR);
$query->bindValue(':offset', $offset, PDO::PARAM_INT);
$query->bindValue(':carsPerPage', $carsPerPage, PDO::PARAM_INT);
$query->execute();

$cars = $query;

$totalCarsQuery = $connection->prepare("SELECT COUNT(*) AS total FROM vehicule WHERE modele LIKE :searchQuery");
$totalCarsQuery->bindValue(':searchQuery', '%' . $searchQuery . '%', PDO::PARAM_STR);
$totalCarsQuery->execute();
$totalCars = $totalCarsQuery->fetch(PDO::FETCH_ASSOC)['total'];

$totalPages = ceil($totalCars / $carsPerPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Car Search Results</title>
</head>
<body class="bg-black text-[#fff]">
<nav class="bg-black text-white py-4">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center">
                <!-- Logo or Brand Name -->
                <div class="text-2xl font-bold">
                    <a href="#">MyWebsite</a>
                </div>
                
                <!-- Navbar Links -->
                <div>
                    <ul class="flex space-x-6">
                        <li><a href="user.php" class="hover:bg-gray-700 px-4 py-2 rounded">Home</a></li>
                        <li><a href="showcare.php" class="hover:bg-gray-700 px-4 py-2 rounded">Explore Cars</a></li>
                        <li><a href="#" class="hover:bg-gray-700 px-4 py-2 rounded">
    <!-- Filter Category -->
    <select id="categoryFilter" name="category" class="bg-black">
        <option value="" disabled selected>Category</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category['idCategorie']; ?>"><?php echo $category['nom']; ?></option>
        <?php endforeach; ?>
    </select>
</a></li>
<li><a href="showReserv.php" class="hover:bg-gray-700 px-4 py-2 rounded">Reservation</a></li>
                    </ul>
                </div>
            </div>
           
        </div>
<br>
  <form action="searchCars.php" method="GET" class="flex items-center space-x-4">
    <input 
      type="text" 
      name="search" 
      placeholder="Search cars..." 
      class="px-4 py-2 rounded bg-gray-800 text-white placeholder-gray-400" 
      required
    />
    <button type="submit" class="bg-blue-600 px-4 py-2 rounded text-white hover:bg-blue-700">
      Search
    </button>
  </form>


    </nav>
<div id="carResults" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
<?php
if ($cars->rowCount() > 0) {
    while ($row = $cars->fetch(PDO::FETCH_ASSOC)) {
        echo '
        <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg transform transition duration-300 hover:scale-105 hover:shadow-2xl cursor-pointer car-card" onclick="toggleInfo(this)">
            <img src="' . $row['img'] . '" alt="Car image" class="w-full h-60 object-cover">
            <div class="p-4">
                <h3 class="text-xl font-semibold mb-2">' . $row['modele'] . '</h3>
                <div class="info-section hidden">
                    <p class="text-gray-400 mb-4">Prix : ' . $row['prix'] . '</p>
                    <p class="text-gray-400 mb-4">Disponible : ' . $row['disponible'] . '</p>
                </div>
                <a href="reservationuser.php?idVehicule=' . htmlspecialchars($row['idVehicule']) . '">
                    <div class="mt-4 flex justify-center">
                        <svg class="bg-[#fff] opacity-60" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 19.5C10 20.3284 9.32843 21 8.5 21C7.67157 21 7 20.3284 7 19.5C7 18.6716 7.67157 18 8.5 18C9.32843 18 10 18.6716 10 19.5Z" stroke="black"></path>
                            <path d="M18 19.5C18 20.3284 17.3284 21 16.5 21C15.6716 21 15 20.3284 15 19.5C15 18.6716 15.6716 18 16.5 18C17.3284 18 18 18.6716 18 19.5Z" stroke="black"></path>
                            <path d="M21 15H11C8.17157 15 6.75736 15 5.87868 14.1213C5 13.2426 5 11.8284 5 9V5C5 3.89543 4.10457 3 3 3" stroke="black" stroke-linecap="round"></path>
                        </svg> 
                    </div>
                </a>
            </div>
        </div>';
    }
} else {
    echo '<p class="text-white">No cars found for "' . htmlspecialchars($searchQuery) . '"</p>';
}

echo '<div class="pagination">';
if ($page > 1) {
    echo '<a href="?search=' . urlencode($searchQuery) . '&page=' . ($page - 1) . '" class="prev">&laquo; Previous</a>';
}

if ($page < $totalPages) {
    echo '<a href="?search=' . urlencode($searchQuery) . '&page=' . ($page + 1) . '" class="next">Next &raquo;</a>';
}
echo '</div>';
?>
</div>



<script>
 document.getElementById('categoryFilter').addEventListener('change', function() {
    var categoryId = this.value;

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'getCarsByCategory.php?category=' + categoryId, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            
            document.getElementById('carResults').innerHTML = xhr.responseText;
            
          
            document.querySelectorAll('.car-card').forEach(function(card) {
                card.addEventListener('click', function() {
                    toggleInfo(card);
                });
            });
        }
    };
    xhr.send();
});

function toggleInfo(card) {
    let infoSection = card.querySelector('.info-section');
    console.log('hamza');
    infoSection.classList.toggle('hidden'); 
}

</script>
<!-- Footer Section -->
<footer class="bg-gray-800 py-6 mt-16 text-center  bottom-0 w-full">
    <p>&copy; 2024 Car Rental. All rights reserved.</p>
</footer>
</body>
</html>
