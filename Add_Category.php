<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>form</title>
</head>

<body class="bg-black">
    
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
    <!-- Category Form -->
    <div class="max-w-4xl mx-auto my-12 p-6 bg-gray-800 rounded-lg shadow-lg">
        <h2 class="text-3xl font-bold text-center text-indigo-400 mb-6">Add New Category</h2>

        <form action="addCategory.php" method="POST">
            <!-- Category Name -->
            <div class="mb-6">
                <label for="nom" class="block text-lg font-medium text-gray-300">Category Name</label>
                <input type="text" name="nom" id="nom" class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-600 bg-gray-900 text-white focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter category name" required>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-lg font-medium text-gray-300">Category Description</label>
                <textarea name="description" id="description" class="mt-1 block w-full px-4 py-3 rounded-md border border-gray-600 bg-gray-900 text-white focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter category description" required></textarea>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center">
                <button type="submit" name="submit" class="w-full sm:w-auto px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                    Add Category
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