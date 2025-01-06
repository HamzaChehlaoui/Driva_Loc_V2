<?php 
if (isset($_GET['idVehicule'])) {
    $idVehicule = $_GET['idVehicule'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reservation Page</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    
    document.addEventListener("DOMContentLoaded", function () {
      var today = new Date();
      var dd = String(today.getDate()).padStart(2, '0');
      var mm = String(today.getMonth() + 1).padStart(2, '0'); 
      var yyyy = today.getFullYear();

      today = yyyy + '-' + mm + '-' + dd;

     
      document.getElementById("pickup_date").setAttribute("min", today);

     
      document.getElementById("return_date").setAttribute("min", today);
    });

    
    function updateReturnDate() {
      var pickupDate = document.getElementById("pickup_date").value;
      document.getElementById("return_date").setAttribute("min", pickupDate);
    }
  </script>
</head>
<body class="bg-black text-white font-sans leading-tight tracking-tight">
   <!-- Navbar -->
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
                        <li><a href="#" class="hover:bg-gray-700 px-4 py-2 rounded">Services</a></li>
                        <li><a href="showReserv.php" class="hover:bg-gray-700 px-4 py-2 rounded">Reservation</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
  <!-- Container for the reservation form -->
  <div class="max-w-4xl mx-auto my-12 p-6 bg-gray-800 rounded-lg shadow-lg">
    <h2 class="text-3xl font-bold text-center text-indigo-400 mb-6">Reserve Your Spot</h2>

    <!-- Reservation Form -->
    <form action="reservation_action_user.php?idVehicule=<?php echo $idVehicule; ?>" method="POST">

      <!-- Customer Info Section -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
        <div>
          <label for="name" class="block text-lg font-medium text-gray-300">Full Name</label>
          <input type="text" id="name" name="name" class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-600 bg-gray-900 text-white focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter your full name" required>
        </div>
         
        <div>
          <label for="email" class="block text-lg font-medium text-gray-300">Email Address</label>
          <input type="email" id="email" name="email" class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-600 bg-gray-900 text-white focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter your email" required>
        </div>
      </div>

      <!-- Pickup and Return Date Section -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
        <div>
          <label for="pickup_date" class="block text-lg font-medium text-gray-300">Pickup Date</label>
          <input type="date" id="pickup_date" name="pickup_date" class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-600 bg-gray-900 text-white focus:ring-indigo-500 focus:border-indigo-500" required onchange="updateReturnDate()">
        </div>
        <div>
          <label for="return_date" class="block text-lg font-medium text-gray-300">Return Date</label>
          <input type="date" id="return_date" name="return_date" class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-600 bg-gray-900 text-white focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>
      </div>

      <!-- Pickup and Return Locations Section -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
        <div>
          <label for="pickup_location" class="block text-lg font-medium text-gray-300">Pickup Location</label>
          <input type="text" id="pickup_location" name="pickup_location" class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-600 bg-gray-900 text-white focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter pickup location" required>
        </div>
        <div>
          <label for="return_location" class="block text-lg font-medium text-gray-300">Return Location</label>
          <input type="text" id="return_location" name="return_location" class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-600 bg-gray-900 text-white focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter return location" required>
        </div>
      </div>

      <!-- Additional Notes Section -->
      <div class="mb-6">
        <label for="notes" class="block text-lg font-medium text-gray-300">Additional Notes</label>
        <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-600 bg-gray-900 text-white focus:ring-indigo-500 focus:border-indigo-500" placeholder="Add any special requests or preferences"></textarea>
      </div>

      <!-- Submit Button -->
      <div class="flex justify-center">
        <button type="submit" name="submit" class="w-full sm:w-auto px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
          Reserve Now
        </button>
      </div>
    </form>
  </div>

    <!-- Footer Section -->
    <footer class="bg-gray-800 py-6 mt-16 text-center">
        <p>&copy; 2024 Car Rental. All rights reserved.</p>
    </footer>
</body>
</html>
