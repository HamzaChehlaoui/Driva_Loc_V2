<?php 
require_once("theme.php");

$database = new Database();
$db = $database->getConnection();
$theme = new theme($db);

$search = isset($_GET['search']) ? $_GET['search'] : '';

if ($search) {
    $articles = $theme->getArticles($search);  
} else {
    $articles = $theme->getArticles(); 
}

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
            <form action="blogger.php" method="GET" class="flex items-center space-x-4">
    <input type="text" name="search" id="search" class="px-4 py-2 rounded text-black" placeholder="Search Articles">
    <button type="submit" class="px-4 py-2 rounded bg-gray-700 text-white">Search</button>
</form>
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
        <?php foreach($articles as $theme) :?>
        <!-- Article Main Content -->
        <main class="flex-1 bg-white p-6 rounded-lg shadow-lg">
            
            <article>
                <h2 class="text-4xl font-bold text-[#000] mb-4"><?php echo $theme['title'] ?></h2>
                <p class="text-lg text-gray-700 mb-6"><?php echo $theme['title'] ?></p>
                <img src="<?php echo $theme['imgs'] ?>" alt="Web Design Future" class="w-[50%] rounded-lg mb-6">
                <ul class="list-disc pl-6 mb-6 flex list-none gap-[1rem]">
                    <li class="text-lg text-gray-700 ">tage_article</li>
                    
                </ul>
                
                <a href="show_article.php?id=<?php echo $theme['article_id'] ?>" class="text-lg text-gray-700">more</a>
            </article>
        </main>
        <?php endforeach;?>
        
        
        
    </div>
    <div class="container mx-auto p-4">
    
        
    
    
    
    



</body>
</html>
