<?php 
require_once("theme.php");


$database = new Database();
$db = $database->getConnection();
$theme = new theme($db);

$articles = $theme -> getArticles();

$themes = $theme->gettheme();
$commit = $theme->getcommit();
$id=$_GET['id'];
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
    <div class="bg-black p-4 rounded-lg shadow-md w-[40%]">
        <div class="flex items-center mb-2">
            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User Avatar" class="w-8 h-8 rounded-full mr-2">
            <p class="text-sm font-semibold text-white">Jean Dupont</p>
        </div>
        <p class="text-gray-400">C'est un excellent article ! J'ai appris beaucoup de choses aujourd'hui.</p>
    </div>

    <div class="bg-black p-4 rounded-lg shadow-md w-[40%]">
        <div class="flex items-center mb-2">
            <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="User Avatar" class="w-8 h-8 rounded-full mr-2">
            <p class="text-sm font-semibold text-white">Marie Dubois</p>
        </div>
        <p class="text-gray-400">Merci pour ces informations, très utiles pour mon projet !</p>
    </div>

    <div class="bg-black p-4 rounded-lg shadow-md w-[40%]">
        <div class="flex items-center mb-2">
            <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="User Avatar" class="w-8 h-8 rounded-full mr-2">
            <p class="text-sm font-semibold text-white">Marie Dubois</p>
        </div>
        <p class="text-gray-400">Merci pour ces informations, très utiles pour mon projet !</p>
    </div>
    <?php foreach($commit as $theme) :?>
        <?php if($theme['article_id']==$id){ ?>
            
        <div class="bg-black p-4 rounded-lg shadow-md w-[40%]">
        <div class="flex items-center mb-2">
            <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="User Avatar" class="w-8 h-8 rounded-full mr-2">
            <p class="text-sm font-semibold text-white">Marie Dubois</p>
        </div>
        <p class="text-gray-400"><?php echo $theme['content']?></p>
    </div>
    <?php }endforeach;?>
</div>

<form action="add_commit.php?id=<?php echo $theme['article_id']?>" method="POST">
    <div class="bg-black p-6 rounded-lg shadow-md mb-6 mt-[2rem]">
        <textarea name="content" class="w-full p-4 mb-4 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white bg-black" rows="4" placeholder="Écrivez votre commentaire ici..."></textarea>
        <button type="submit" name="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
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