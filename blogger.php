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
                       
                        <select name="theme" id="theme" class="px-4 py-2 rounded text-[#000]">
                            <?php foreach ($themes as $theme): ?>
                            <option value="<?php echo $theme['theme_id']; ?>"><?php echo $theme['name']; ?></option>
                            <?php endforeach; ?>
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
                <a href="Add_articl.php" class="text-xl mb-8 text-white  ml-[2rem]">Add Article</a>
                <div class="relative">
    
    <div class="flex items-center justify-center">
    
            <h2 class="w-[10rem] h-10 text-[1.5rem] transform rotate-45 origin-center animate-bounce mt-[3rem]">Explore Article</h2>
    </div>
    </div>
        </div>
    </section>
    <div class="container mx-auto p-6 flex space-x-8">
        <!-- Article Main Content -->
        <main class="flex-1 bg-white p-6 rounded-lg shadow-lg">
            <article>
                <h2 class="text-4xl font-bold mb-4">The Future of Web Design</h2>
                <p class="text-lg text-gray-700 mb-6">Web design has evolved rapidly over the past few years. With the rise of
                    mobile-first design, interactive websites, and performance-focused design practices, the future of
                    web design looks more dynamic and user-centric than ever before.</p>
                <p class="text-lg text-gray-700 mb-6">In this article, we will explore the key trends and tools that will shape
                    web design in the years to come, such as AI-driven design, voice interfaces, and the continued
                    importance of accessibility.</p>
                <img src="https://via.placeholder.com/800x400" alt="Web Design Future" class="w-full rounded-lg mb-6">
                <h3 class="text-2xl font-semibold mb-4">Key Trends to Watch</h3>
                <ul class="list-disc pl-6 mb-6">
                    <li class="text-lg text-gray-700">AI-Driven Design</li>
                    <li class="text-lg text-gray-700">Voice User Interface (VUI)</li>
                    <li class="text-lg text-gray-700">Mobile-First Design</li>
                    <li class="text-lg text-gray-700">Sustainability in Web Design</li>
                </ul>
                <p class="text-lg text-gray-700">As technology advances, web design will need to adapt to new challenges and
                    opportunities. The role of web designers will become more integrated with other fields, such as AI and
                    user experience design.</p>
            </article>
        </main>

        <!-- Sidebar Section -->
        <aside class="w-1/3 bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-2xl font-semibold mb-4">Related Articles</h3>
            <ul class="space-y-4">
                <li><a href="#" class="text-lg text-blue-600 hover:underline">The Impact of Mobile Design on UX</a></li>
                <li><a href="#" class="text-lg text-blue-600 hover:underline">How to Optimize Your Website for Speed</a></li>
                <li><a href="#" class="text-lg text-blue-600 hover:underline">Designing for Accessibility: Best Practices</a></li>
            </ul>
        </aside>
    </div>
      


    <!-- Articles Section -->
    <section id="articlesSection" class="max-w-7xl mx-auto py-8 px-4 hidden">
        <h2 class="text-3xl font-semibold mb-6">Articles for <span id="currentTheme"></span></h2>

        <div id="articlesList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 text-black" >
            <!-- Articles will be injected here -->
        </div>
    </section>


</body>
</html>
