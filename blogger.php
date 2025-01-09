<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog with Tailwind CSS</title>
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
                        <select name="" id="" class=" px-4 py-2 rounded text-[#000]">
                            <option  value="">Thème 1</option>
                            <option  value="">Thème 2</option>
                            <option  value="">Thème 3</option>
                            <option  value="">Thème 4</option>
                        </select>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <section class="relative">
        <img src="https://st2.depositphotos.com/5473448/8221/i/450/depositphotos_82213968-stock-photo-red-text-3d-rendering-with.jpg" class="h-[600px] w-[100%]">
        <div class="absolute inset-0 bg-black bg-opacity-50 flex justify-center items-center text-center p-4">
            <div>
                <h2 class="text-4xl font-semibold mb-4 text-white">Welcome to the world of cars</h2>
                <a href="Add_theme.php" class="text-xl mb-8 text-white  ">Add theme</a>
                <div class="relative">
    
    <div class="flex items-center justify-center">
    
            <h2 class="w-[10rem] h-10 text-[1.5rem] transform rotate-45 origin-center animate-bounce mt-[3rem]">Explore Article</h2>
    </div>
    </div>
        </div>
    </section>
    <div class="max-w-7xl mx-auto py-8 px-4">
      


    <!-- Articles Section -->
    <section id="articlesSection" class="max-w-7xl mx-auto py-8 px-4 hidden">
        <h2 class="text-3xl font-semibold mb-6">Articles for <span id="currentTheme"></span></h2>

        <div id="articlesList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 text-black" >
            <!-- Articles will be injected here -->
        </div>
    </section>


</body>
</html>
