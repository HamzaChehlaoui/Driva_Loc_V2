<?php
session_start();
require("conn.php");
require("TagArticle.php");
require("Articles.php");

if (!isset($_SESSION['idUser'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['article_id'])) {
    header("Location: index.php");
    exit;
}

$articleId = (int)$_GET['article_id'];

$database = new Database();
$db = $database->getConnection();
$tagArticleObj = new TagArticle($db);
$articleObj = new Article($db);

$article = $articleObj->getArticleById($articleId);
if (!$article || $article['idUser'] != $_SESSION['idUser']) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tag_id'])) {
    $tagId = (int)$_POST['tag_id'];
    if ($tagArticleObj->addTagToArticle($articleId, $tagId)) {
        $_SESSION['success_message'] = "Tag added successfully!";
    } else {
        $_SESSION['error_message'] = "Tag could not be added. It might already be linked to this article.";
    }
    header("Location: add_tags_to_article.php?article_id=" . $articleId);
    exit;
}

$availableTags = $tagArticleObj->getAvailableTags($articleId);
$currentTags = $tagArticleObj->getArticleTags($articleId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Tags to Article</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold">Add Tags to Article</h1>
                <a href="blogger.php?id=<?php echo $articleId; ?>" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-arrow-left"></i> Back to Article
                </a>
            </div>

            <!-- Article Info -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <h2 class="font-bold mb-2">Article: <?php echo htmlspecialchars($article['title']); ?></h2>
            </div>

            <!-- Success/Error Messages -->
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    <?php 
                    echo $_SESSION['success_message'];
                    unset($_SESSION['success_message']);
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    <?php 
                    echo $_SESSION['error_message'];
                    unset($_SESSION['error_message']);
                    ?>
                </div>
            <?php endif; ?>

            <!-- Current Tags -->
            <div class="mb-6">
                <h3 class="font-bold mb-2">Current Tags:</h3>
                <div class="flex flex-wrap gap-2">
                    <?php if (empty($currentTags)): ?>
                        <p class="text-gray-500">No tags added yet.</p>
                    <?php else: ?>
                        <?php foreach ($currentTags as $tag): ?>
                            <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full flex items-center">
                                <?php echo htmlspecialchars($tag['name']); ?>
                                <a href="remove_tag.php?article_id=<?php echo $articleId; ?>&tag_id=<?php echo $tag['tag_id']; ?>" 
                                   class="ml-2 text-red-500 hover:text-red-700">
                                 
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Add New Tag Form -->
            <?php if (!empty($availableTags)): ?>
                <form method="POST" class="mt-4">
                    <div class="flex gap-4">
                        <select name="tag_id" class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select a tag to add...</option>
                            <?php foreach ($availableTags as $tag): ?>
                                <option value="<?php echo $tag['tag_id']; ?>">
                                    <?php echo htmlspecialchars($tag['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Add Tag
                        </button>
                    </div>
                </form>
            <?php else: ?>
                <p class="text-gray-500">No more tags available to add.</p>
            <?php endif; ?>

            <!-- Create New Tag Link -->
            <div class="mt-6 pt-6 border-t">
                <a href="add_tag.php" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-plus"></i> Create New Tag
                </a>
            </div>
        </div>
    </div>
</body>
</html>