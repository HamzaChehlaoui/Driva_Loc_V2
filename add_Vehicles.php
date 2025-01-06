<?php
require('actionAddVehicles.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<script>

function addVehicleField() {
  var container = document.getElementById("vehicle-fields-container");

  var newField = document.createElement("div");
  newField.classList.add("grid", "grid-cols-1", "sm:grid-cols-2", "gap-6", "mb-6");

  newField.innerHTML = `
    <div>
      <label for="vehicle-model" class="block text-lg font-medium text-gray-300">Vehicle Model</label>
      <input type="text" name="vehicle-model[]" class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-600 bg-gray-900 text-white focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter vehicle model" required>
    </div>
    <div>
        <label for="vehicle-img" class="block text-lg font-medium text-gray-300">Img Url</label>
        <input type="text" name="vehicle-img[]" class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-600 bg-gray-900 text-white focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter vehicle model" required>
      </div>
   <!-- Dynamic Category Dropdown -->
       <div>
        <label for="vehicle-category" class="block text-lg font-medium text-gray-300">Category</label>
        <select name="vehicle-category[]" class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-600 bg-gray-900 text-white focus:ring-indigo-500 focus:border-indigo-500" required>
          <option value="" disabled selected>Select category</option>
          <?php foreach ($categories as $category): ?>
              <option value="<?php echo $category['idCategorie']; ?>"><?php echo $category['nom']; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    <div>
      <label for="vehicle-price" class="block text-lg font-medium text-gray-300">Price</label>
      <input type="number" name="vehicle-price[]" class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-600 bg-gray-900 text-white focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter vehicle price" required>
    </div>
    <div>
      <label for="vehicle-availability" class="block text-lg font-medium text-gray-300">Availability</label>
      <select name="vehicle-disponible[]" class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-600 bg-gray-900 text-white focus:ring-indigo-500 focus:border-indigo-500" required>
        <option value="available">Available</option>
        <option value="unavailable">Unavailable</option>
      </select>
    </div>
  `;

  container.appendChild(newField);
}
</script>
<body class="bg-black text-[#fff]">
 
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
                        <li><a href="admin.php" class="hover:bg-gray-700 px-4 py-2 rounded">Home</a></li>
                        <li><a href="add_Vehicles.php" class="hover:bg-gray-700 px-4 py-2 rounded">Add Vehicles</a></li>
                        <li><a href="#" class="hover:bg-gray-700 px-4 py-2 rounded"> Reservations</a></li>
                        <li><a href="Add_Category.php" class="hover:bg-gray-700 px-4 py-2 rounded">Add Category </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

<div class="max-w-4xl mx-auto my-12 p-6 bg-gray-800 rounded-lg shadow-lg">
    <h2 class="text-3xl font-bold text-center text-indigo-400 mb-6">Add Multiple Vehicles</h2>

    <form action="actionAddVehicles.php" method="POST">
      <div id="vehicle-fields-container">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
          <div>
            <label for="vehicle-model" class="block text-lg font-medium text-gray-300">Vehicle Model</label>
            <input type="text" name="vehicle-model[]" class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-600 bg-gray-900 text-white focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter vehicle model" required>
          </div>
          <div>
            <label for="vehicle-img" class="block text-lg font-medium text-gray-300">Img Url</label>
            <input type="text" name="vehicle-img[]" class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-600 bg-gray-900 text-white focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter vehicle model" required>
          </div>

          <!-- Dynamic Category Dropdown -->
          <div>
            <label for="vehicle-category" class="block text-lg font-medium text-gray-300">Category</label>
            <select name="vehicle-category[]" class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-600 bg-gray-900 text-white focus:ring-indigo-500 focus:border-indigo-500" required>
              <option value="" disabled selected>Select category</option>
              <?php foreach ($categories as $category): ?>
                  <option value="<?php echo $category['idCategorie']; ?>"><?php echo $category['nom']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div>
            <label for="vehicle-price" class="block text-lg font-medium text-gray-300">Price</label>
            <input type="number" name="vehicle-price[]" class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-600 bg-gray-900 text-white focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter vehicle price" required>
          </div>
          <div>
            <label for="vehicle-availability" class="block text-lg font-medium text-gray-300">Availability</label>
            <select name="vehicle-disponible[]" class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-600 bg-gray-900 text-white focus:ring-indigo-500 focus:border-indigo-500" required>
              <option value="available">Available</option>
              <option value="unavailable">Unavailable</option>
            </select>
          </div>
        </div>
      </div>

      <div class="flex justify-center mb-6">
        <button type="button" onclick="addVehicleField()" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
          Add Another Vehicle
        </button>
      </div>

      <div class="flex justify-center">
        <button type="submit" name="submit" class="w-full sm:w-auto px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
          Submit Vehicles
        </button>
      </div>
    </form>
</div>

<!-- Footer Section -->
<footer class="bg-gray-800 py-6 mt-16 text-center">
    <p>&copy; 2024 Car Rental. All rights reserved.</p>
</footer>

<script src="js/script.js"></script>

</body>
</html>
