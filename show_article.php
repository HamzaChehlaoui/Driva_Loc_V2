<?php 
require_once("theme.php");


$database = new Database();
$db = $database->getConnection();
$theme = new theme($db);

$articles = $theme -> getArticles();

$themes = $theme->gettheme();
$commit = $theme->getcommit();
$id=$_GET['id'];
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Modify the getArticles method to accept a search term
$articles = $theme->getArticles($searchTerm);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <style>
        .scrollbar-hidden::-webkit-scrollbar {
    display: none; /* Hide the scrollbar in Webkit browsers (Chrome, Safari, etc.) */
}

.scrollbar-hidden {
    -ms-overflow-style: none;  /* Hide scrollbar for Internet Explorer */
    scrollbar-width: none;     /* Hide scrollbar for Firefox */
}
    </style>
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
    

    <?php foreach($articles as $theme) :?>
        <?php if($theme['article_id']==$id){?>
        <!-- Article Main Content -->
        <main class="flex-1 bg-white p-6 rounded-lg shadow-lg">
            
            <article>
                <h2 class="text-4xl font-bold text-[#000] mb-4"><?php echo $theme['title'] ?></h2>
                <p class="text-lg text-gray-700 mb-6"><?php echo $theme['title'] ?></p>
                <img src="<?php echo $theme['img'] ?>" alt="Web Design Future" class="w-[50%] rounded-lg mb-6">
                <ul class="list-disc pl-6 mb-6 flex list-none gap-[1rem]">
                    <li class="text-lg text-gray-700 ">tage_article</li>
                    
                </ul>
                <p class="text-lg text-gray-700"><?php echo $theme['contents'] ?></p>
            </article>
        </main>
        <!-- Liste des commentaires -->
        <div class="space-y-4">
    <!-- Single Comment Block -->
    

    <!-- Another Comment Block -->
    

    
</div>

<!-- Scrollable Comment Section -->
<div class="h-[400px] overflow-y-auto bg-gray-800 p-4 rounded-lg shadow-md mb-6 mt-[2rem] w-[40%] scrollbar-hidden">
<div class="bg-gray-700 p-4 rounded-lg shadow-md mb-4 ">
        <div class="flex items-center mb-3">
            <!-- User Avatar -->
            <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="User Avatar" class="w-10 h-10 rounded-full mr-3 border-2 border-gray-600">
            <!-- Username -->
            <p class="text-sm font-semibold text-white">Marie Dubois</p>
        </div>
        <!-- Comment Content -->
        <p class="text-gray-400 text-sm">Merci pour ces informations, très utiles pour mon projet !</p>
    </div>
    <!-- This will be the section that holds the comments -->
    <?php foreach($commit as $theme) :?>
        <?php if($theme['article_id'] == $id){ ?>
            <div class="bg-gray-700 p-4 rounded-lg shadow-md mb-4 ">
                <div class="flex items-center mb-3">
                    <!-- User Avatar -->
                    <img src="https://media.istockphoto.com/id/1016744004/fr/vectoriel/image-despace-r%C3%A9serv%C3%A9-de-profil-gray-ne-silhouette-aucune-photo.jpg?s=612x612&w=0&k=20&c=7OLCKLuDpDHaXywnkaGuK-bKQS9lnivwYDYnGqD60bc=" alt="User Avatar" class="w-10 h-10 rounded-full mr-3 border-2 border-gray-600">
                    <!-- Username -->
                    <p class="text-sm font-semibold text-white">Utilisateur Anonyme</p>
                </div>
                <!-- Comment Content -->
                <p class="text-gray-400 text-sm"><?php echo $theme['content']; ?></p>
            </div>
        <?php } endforeach; ?>
</div>

<!-- Comment Form Section -->
<form action="add_commit.php?id_article=<?php echo $theme['article_id']?>" method="POST">
    <div class="bg-gray-800 p-6 rounded-lg shadow-md mb-6 mt-[2rem]">
        <!-- Comment Textarea -->
        <textarea name="content" class="w-full p-4 mb-4 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white bg-gray-900" rows="4" placeholder="Écrivez votre commentaire ici..."></textarea>
        <!-- Submit Button -->
        <button type="submit" name="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Publier le commentaire
        </button>
    </div>
</form>



    </div>
        <?php }endforeach;?>
        <div class="container mx-auto p-4">
    
        <!-- Titre de la section -->
        <h2 class="text-2xl font-semibold  mb-4 text-[#fff]"> commentaire</h2>
    
        <!-- Formulaire de commentaire -->
    
    

</body>
</html>