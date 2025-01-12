<?php
session_start();
if (!isset($_SESSION['idUser'])) {
    header('Location: index.php');
    exit();
}

require("conn.php");
require("Articles.php");
require("Themes.php");

$database = new Database();
$db = $database->getConnection();
$articleObj = new Article($db);
$themeObj = new Theme($db);

$article_id = $_GET['id'] ?? null;
if (!$article_id) {
    header('Location: blogger.php');
    exit();
}

$article = $articleObj->getArticleById($article_id);
if (!$article || $article['idUser'] != $_SESSION['idUser']) {
    header('Location: blogger.php');
    exit();
}

$themes = $themeObj->getAllThemes();
$tags = $articleObj->getAllTags();
$currentTags = $articleObj->getArticleTags($article_id);
$currentTagIds = array_column($currentTags, 'tag_id');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $contents = $_POST['contents'] ?? '';
    $theme_id = $_POST['theme_id'] ?? '';
    $selectedTags = $_POST['tags'] ?? [];
    $img = $_POST['img'] ?? ''; // Get the new image URL from POST
    
    // If no new image URL is provided, keep the existing one
    if (empty($img)) {
        $img = $article['img'];
    }
    
    if ($articleObj->updateArticle($article_id, $title, $contents, $theme_id, $img)) {
        foreach ($selectedTags as $tag_id) {
            $articleObj->addArticleTag($article_id, $tag_id);
        }
        header('Location: blogger.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Article - Car Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Edit Article</h1>
        
        <form action="" method="POST" class="bg-white rounded-lg shadow-lg p-6">
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="title">Title</label>
                <input type="text" id="title" name="title" required
                       value="<?php echo htmlspecialchars($article['title']); ?>"
                       class="w-full px-4 py-2 border rounded-lg">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="contents">Content</label>
                <textarea id="contents" name="contents" required rows="6"
                          class="w-full px-4 py-2 border rounded-lg"><?php echo htmlspecialchars($article['contents']); ?></textarea>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="theme_id">Theme</label>
                <select id="theme_id" name="theme_id" required
                        class="w-full px-4 py-2 border rounded-lg">
                    <?php foreach($themes as $theme): ?>
                        <option value="<?php echo $theme['theme_id']; ?>"
                                <?php echo ($theme['theme_id'] == $article['theme_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($theme['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 mb-2" for="img">Image URL</label>
                <?php if($article['img']): ?>
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-2">Current image:</p>
                        <img src="<?php echo htmlspecialchars($article['img']); ?>" 
                             alt="Current image" class="w-48 mb-2">
                    </div>
                <?php endif; ?>
                <input type="text" id="img" name="img" 
                       value="<?php echo htmlspecialchars($article['img']); ?>"
                       placeholder="Enter image URL"
                       class="w-full px-4 py-2 border rounded-lg">
                <p class="text-sm text-gray-500 mt-1">Leave empty to keep current image</p>
            </div>
            
            <div class="flex justify-between">
                <a href="blogger.php" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Update Article
                </button>
            </div>
        </form>
    </div>
</body>
</html>