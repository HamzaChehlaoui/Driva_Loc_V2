<?php 
require("theme.php");

$database = new Database();
$db = $database->getConnection();
$theme = new theme($db);
$themes = $theme->gettheme();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Add Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white">
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

    <div class="max-w-lg mx-auto p-6 bg-gray-800 rounded-lg shadow-md mt-10">
        <form action="add.articl.php" method="POST">
            <p class="block text-white text-lg font-medium mb-2">Choose the subject that belongs to the article.</p>
        <select name="idtheme" id="theme" class="px-4 py-2 rounded text-[#000]">
                            <?php foreach ($themes as $theme): ?>
                            <option value="<?php echo $theme['theme_id']; ?>"><?php echo $theme['name']; ?></option>
                            <?php endforeach; ?>
        </select>
            <div class="mb-4">
                <label for="titre" class="block text-white text-lg font-medium mb-2">Titre</label>
                <input type="text" name="titre" id="titre" class="w-full p-2 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-black" required>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-white text-lg font-medium mb-2">image</label>
                <input type="text" name="image" id="image" class="w-full p-2 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-black" required>
            </div>

            <div class="mb-4">
                <label for="content" class="block text-white text-lg font-medium mb-2">Content</label>
                <textarea type="text" name="content" id="content" class="w-full p-2 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-black" required></textarea>
            </div>

            <button type="submit" name="submit" class="w-full bg-gray-700 text-white py-2 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">Submit</button>
        </form>
    </div>

</body>
</html>
