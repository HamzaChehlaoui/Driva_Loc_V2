<?php
session_start();
require("conn.php");
require("Articles.php");
require("Favorite.php");

// Redirect if not logged in
if (!isset($_SESSION['idUser'])) {
    header('Location: index.php');
    exit;
}

$database = new Database();
$db = $database->getConnection();
$favoriteObj = new Favorite($db);
$articleObj = new Article($db);

// Get user's favorites
$favorites = $favoriteObj->getUserFavorites($_SESSION['idUser']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Favorites - CarBlog</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-8">
                    <a href="index.php" class="text-2xl font-bold text-gray-800">CarBlog</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="create_article.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Create Article
                    </a>
                    <a href="favorites.php" class="text-red-600">
                        <i class="fas fa-heart"></i> Favorites
                    </a>
                    <a href="logout.php" class="text-gray-600 hover:text-red-600">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Favorites Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">My Favorite Articles</h1>
        
        <?php if (empty($favorites)): ?>
            <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                <p class="text-gray-600 text-lg">You haven't added any articles to your favorites yet.</p>
                <a href="blogger.php" class="inline-block mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Browse Articles
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach($favorites as $article): ?>
                    <article class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <?php if($article['img']): ?>
                            <img src="<?php echo htmlspecialchars($article['img']); ?>" 
                                 alt="<?php echo htmlspecialchars($article['title']); ?>"
                                 class="w-full h-48 object-cover">
                        <?php endif; ?>
                        
                        <div class="p-6">
                            <h2 class="text-xl font-bold mb-2">
                                <?php echo htmlspecialchars($article['title']); ?>
                            </h2>
                            <p class="text-gray-600 mb-4">
                                <?php echo substr(htmlspecialchars($article['contents']), 0, 150) . '...'; ?>
                            </p>
                            
                            <div class="flex flex-wrap gap-2 mb-4">
                                <?php foreach($articleObj->getArticleTags($article['article_id']) as $tag): ?>
                                    <span class="bg-gray-200 px-2 py-1 rounded-full text-sm">
                                        <?php echo htmlspecialchars($tag['name']); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <a href="article.php?id=<?php echo $article['article_id']; ?>" 
                                   class="text-blue-600 hover:text-blue-800">
                                    Read More
                                </a>
                                
                                <div class="flex items-center space-x-4">
                                    <button onclick="toggleFavorite(<?php echo $article['article_id']; ?>)" 
                                            class="text-red-600 hover:text-gray-600">
                                        <i id="heart-icon-<?php echo $article['article_id']; ?>" 
                                           class="fas fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
    function toggleFavorite(articleId) {
        fetch('ajax/toggle_favorite.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                article_id: articleId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the article card from the favorites page
                const articleElement = document.querySelector(`#heart-icon-${articleId}`).closest('article');
                articleElement.remove();
                
                // If no more favorites, reload the page to show the empty state
                const remainingArticles = document.querySelectorAll('article');
                if (remainingArticles.length === 0) {
                    location.reload();
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    </script>
</body>
</html>