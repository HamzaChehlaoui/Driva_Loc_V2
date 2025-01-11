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

$themes = $themeObj->getAllThemes();
$tags = $articleObj->getAllTags();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $contents = $_POST['contents'] ?? '';
    $theme_id = $_POST['theme_id'] ?? '';
    $selectedTags = $_POST['tags'] ?? [];
    
    $img = null;
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $fileName = uniqid() . '_' . basename($_FILES['img']['name']);
        $uploadFile = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['img']['tmp_name'], $uploadFile)) {
            $img = $uploadFile;
        }
    }
    
    $article_id = $articleObj->createArticle($title, $contents, $_SESSION['idUser'], $theme_id, $img);
    
    if ($article_id) {
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
    <title>Create Article - Car Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Create New Article</h1>
        
        <form action="" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-lg p-6">
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="title">Title</label>
                <input type="text" id="title" name="title" required
                       class="w-full px-4 py-2 border rounded-lg">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="contents">Content</label>
                <textarea id="contents" name="contents" required rows="6"
                          class="w-full px-4 py-2 border rounded-lg"></textarea>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="theme_id">Theme</label>
                <select id="theme_id" name="theme_id" required
                        class="w-full px-4 py-2 border rounded-lg">
                    <?php foreach($themes as $theme): ?>
                        <option value="<?php echo $theme['theme_id']; ?>">
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
                                   class="form-checkbox">
                            <span class="ml-2"><?php echo htmlspecialchars($tag['name']); ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 mb-2" for="img">Image</label>
                <input type="file" id="img" name="img" accept="image/*"
                       class="w-full px-4 py-2 border rounded-lg">
            </div>
            
            <div class="flex justify-between">
                <a href="index.php" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Create Article
                </button>
            </div>
        </form>
    </div>
</body>
</html>