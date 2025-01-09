<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Theme</title>
    <!-- Tailwind CSS link -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
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
                        <li><a href="showReserv.php" class="hover:bg-gray-700 px-4 py-2 rounded">Reservation</a></li>
                        <li><a href="blogger.php" class="hover:bg-gray-700 px-4 py-2 rounded">Blogger</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="bg-gray-900 flex items-center justify-center min-h-screen">
        <div class="bg-black p-8 rounded-lg shadow-lg max-w-sm w-full">
            <form action="addtheme.php" method="POST">
                <div class="mb-4">
                    <label for="name" class="block text-lg font-medium text-white">Name Theme</label>
                    <input id="name" name="name_theme" type="text" class="mt-2 p-2 w-full border border-gray-700 rounded-md focus:ring-2 focus:ring-gray-500 text-white bg-gray-800" placeholder="Enter theme name" required>
                </div>
                <button name="submit" type="submit" class="w-full bg-gray-700 text-white py-2 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>
