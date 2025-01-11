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
    
    $img = $article['img'];
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $fileName = uniqid() . '_' . basename($_FILES['img']['name']);
        $uploadFile = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['img']['tmp_name'], $uploadFile)) {
            if ($img && file_exists($img)) {
                unlink($img);
            }
            $img = $uploadFile;
        }
    }
    
    if ($articleObj->updateArticle($article_id, $title, $contents, $theme_id, $img)) {
        // $articleObj->deleteArticleTags($article_id);
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
        
        <form action="" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-lg p-6">
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
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Tags</label>
                <div class="flex flex-wrap gap-4">
                    <?php foreach($tags as $tag): ?>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="tags[]" value="<?php echo $tag['tag_id']; ?>"
                                   <?php echo in_array($tag['tag_id'], $currentTagIds) ? 'checked' : ''; ?>
                                   class="form-checkbox">
                            <span class="ml-2"><?php echo htmlspecialchars($tag['name']); ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 mb-2" for="img">Image</label>
                <?php if($article['img']): ?>
                    <img src="<?php echo htmlspecialchars($article['img']); ?>" 
                         alt="Current image" class="w-48 mb-2">
                <?php endif; ?>
                <input type="file" id="img" name="img" accept="image/*"
                       class="w-full px-4 py-2 border rounded-lg">
            </div>
            
            <div class="flex justify-between">
                <a href="index.php" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
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