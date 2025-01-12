<?php
session_start();
if($_SESSION['idUser']==null){
    header('Location:index.php');
}
require("conn.php");
require("Themes.php");
require("Articles.php");
require("Favorite.php");
require("TagArticle.php");  

$database = new Database();
$db = $database->getConnection();
$themeObj = new Theme($db);
$articleObj = new Article($db);
$favoriteObj = new Favorite($db);
$tagArticleObj = new TagArticle($db);  
$search = isset($_GET['search']) ? $_GET['search'] : '';
$selectedTheme = isset($_GET['theme']) ? (int)$_GET['theme'] : null;
$selectedTag = isset($_GET['tag']) ? (int)$_GET['tag'] : null;
$articlesPerPage = isset($_GET['perPage']) ? (int)$_GET['perPage'] : 3;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page -1 ) * $articlesPerPage;

$themes = $themeObj->getAllThemes();
$tags = $articleObj->getAllTags();
$articles = $articleObj->getFilteredArticles($search, $selectedTheme, $selectedTag, $articlesPerPage, $offset);
$totalArticles = $articleObj->getTotalFilteredArticles($search, $selectedTheme, $selectedTag);
$totalPages = ceil($totalArticles / $articlesPerPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 <?php echo isset($_SESSION['idUser']) ? 'logged-in' : ''; ?>">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-8">
                    <a href="index.php" class="text-2xl font-bold text-gray-800">CarBlog</a>
                    <div class="hidden md:flex space-x-4">
                        <?php foreach($themes as $theme): ?>
                            <a href="?theme=<?php echo $theme['theme_id']; ?>" 
                               class="text-gray-600 hover:text-blue-600 transition">
                                <?php echo htmlspecialchars($theme['name']); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                
                <?php if(isset($_SESSION['idUser'])): ?>
                    <div class="flex items-center space-x-4">
                        <a href="create_article.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Create Article
                        </a>
                        <a href="favorites.php" class="text-gray-600 hover:text-blue-600">
                            <i class="fas fa-heart"></i> Favorites
                        </a>
                        <a href="logout.php" class="text-gray-600 hover:text-red-600">Logout</a>
                        <a href="add_tag.php" class="text-gray-600 hover:text-blue-600">
    <i class="fas fa-tag"></i> Add Tag
</a>
                    </div>
                <?php else: ?>
                    <div class="flex items-center space-x-4">
                        <a href="login.php" class="text-gray-600 hover:text-blue-600">Login</a>
                        <a href="register.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Register
                        </a>
                        
                    </div>
                <?php endif; ?>
            </div>
        </div>
       
    </nav>
    <!-- Search and Filters -->
    <div class="bg-white shadow-md py-4 mb-6">
        <div class="max-w-7xl mx-auto px-4">
            <form action="" method="GET" class="flex flex-wrap gap-4">
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" 
                       class="flex-1 px-4 py-2 border rounded-lg" placeholder="Search articles...">
                
                <select name="tag" class="px-4 py-2 border rounded-lg">
                    <option value="">All Tags</option>
                    <?php foreach($tags as $tag): ?>
                        <option value="<?php echo $tag['tag_id']; ?>" 
                                <?php echo ($selectedTag == $tag['tag_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($tag['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select name="perPage" class="px-4 py-2 border rounded-lg">
                    <option value="3" <?php echo ($articlesPerPage == 3) ? 'selected' : ''; ?>>3 per page</option>
                    <option value="10" <?php echo ($articlesPerPage == 10) ? 'selected' : ''; ?>>10 per page</option>
                    <option value="15" <?php echo ($articlesPerPage == 15) ? 'selected' : ''; ?>>15 per page</option>
                </select>

                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Search
                </button>
            </form>
        </div>
    </div>

    <!-- Articles Grid -->
    <div class="max-w-7xl mx-auto px-4 py-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach($articles as $article): ?>
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
                    
                    <!-- Simplified tag display without deletion -->
                    <div class="flex flex-wrap gap-2 mb-4">
                        <?php foreach($articleObj->getArticleTags($article['article_id']) as $tag): ?>
                            <span class="bg-gray-200 px-2 py-1 rounded-full text-sm">
                                <?php echo htmlspecialchars($tag['name']); ?>
                            </span>
                        <?php endforeach; ?>
                        
                        <?php if(isset($_SESSION['idUser']) && $_SESSION['idUser'] == $article['idUser']): ?>
                            <a href="add_tags_to_article.php?article_id=<?php echo $article['article_id']; ?>" 
                               class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-plus"></i> Add Tag
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <a href="article.php?id=<?php echo $article['article_id']; ?>" 
                           class="text-blue-600 hover:text-blue-800">Read More</a>
                        
                        <?php if(isset($_SESSION['idUser'])): ?>
                            <div class="flex items-center space-x-4">
                                <button onclick="toggleFavorite(<?php echo $article['article_id']; ?>)" 
                                        class="text-gray-600 hover:text-red-600">
                                    <i id="heart-icon-<?php echo $article['article_id']; ?>" 
                                       class="fas fa-heart <?php echo $favoriteObj->isFavorite($_SESSION['idUser'], $article['article_id']) ? 'text-red-600' : ''; ?>">
                                    </i>
                                </button>
                                
                                <?php if($_SESSION['idUser'] == $article['idUser']): ?>
                                    <a href="edit_article.php?id=<?php echo $article['article_id']; ?>" 
                                       class="text-gray-600 hover:text-blue-600">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteArticle(<?php echo $article['article_id']; ?>)" 
                                            class="text-gray-600 hover:text-red-600">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</div>
        <!-- Pagination -->
        <?php if($totalPages > 1): ?>
            <div class="flex justify-center mt-8">
                <nav class="flex space-x-2">
                    <?php for($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&theme=<?php echo $selectedTheme; ?>&tag=<?php echo $selectedTag; ?>&perPage=<?php echo $articlesPerPage; ?>" 
                           class="px-4 py-2 rounded-lg <?php echo ($i == $page) ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-100'; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                </nav>
            </div>
        <?php endif; ?>
    </div>

    <script>
    function toggleFavorite(articleId) {
    // First, check if user is logged in (you can add a hidden input with PHP to check this)
    if (!document.body.classList.contains('logged-in')) {
        window.location.href = 'login.php';
        return;
    }

    fetch('ajax/toggle_favorite.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            article_id: articleId
        }),
        credentials: 'same-origin' // Important for sessions
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Get the heart icon
            const heartIcon = document.querySelector(`#heart-icon-${articleId}`);
            
            // Toggle the heart color
            if (data.isFavorite) {
                heartIcon.classList.remove('text-gray-600');
                heartIcon.classList.add('text-red-600');
                console.log('Added to favorites');
            } else {
                heartIcon.classList.remove('text-red-600');
                heartIcon.classList.add('text-gray-600');
                console.log('Removed from favorites');
            }
            
            // Optional: Show a feedback message
            showMessage(data.message);
        } else {
            console.error('Error:', data.message);
            showMessage(data.message || 'An error occurred', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('An error occurred while updating favorites', 'error');
    });
}

// Add this helper function for showing messages (optional)
function showMessage(message, type = 'success') {
    // Create message element
    const messageDiv = document.createElement('div');
    messageDiv.textContent = message;
    messageDiv.className = `fixed top-4 right-4 p-4 rounded-lg ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    } text-white`;

    // Add to page
    document.body.appendChild(messageDiv);

    // Remove after 3 seconds
    setTimeout(() => {
        messageDiv.remove();
    }, 3000);
}


    function deleteArticle(articleId) {
        if(confirm('Are you sure you want to delete this article?')) {
            fetch('ajax/delete_article.php', {
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
                if(data.success) {
                    location.reload();
                }
            });
        }
    }
    </script>
</body>
</html>