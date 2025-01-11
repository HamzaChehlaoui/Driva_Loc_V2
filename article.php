<?php
session_start();
require("conn.php");
require("Articles.php");
require("commit.php");
require("Favorite.php");

$database = new Database();
$db = $database->getConnection();
$articleObj = new Article($db);
$commentObj = new Comment($db);
$favoriteObj = new Favorite($db);

$articleId = isset($_GET['id']) ? (int)$_GET['id'] : null;

if (!$articleId) {
    header("Location: index.php");
    exit;
}

$article = $articleObj->getArticleById($articleId);
if (!$article) {
    echo "Article not found.";
    exit;
}

$tags = $articleObj->getArticleTags($articleId);
$comments = $commentObj->getCommentsByArticleId($articleId);

// Handle adding a comment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment']) && isset($_SESSION['idUser'])) {
    $commentObj->addComment($_SESSION['idUser'], $articleId, $_POST['comment']);
    header("Location: article.php?id={$articleId}");
    exit;
}

// Handle deleting a comment
if (isset($_POST['delete_comment']) && isset($_SESSION['idUser'])) {
    $commentObj->deleteComment($_POST['delete_comment'], $_SESSION['idUser']);
    header("Location: article.php?id={$articleId}");
    exit;
}
// Handle editing a comment
if (isset($_POST['edit_comment']) && isset($_SESSION['idUser'])) {
    if (isset($_POST['comment_id']) && isset($_POST['comment'])) {
        $commentObj->editComment($_POST['comment_id'], $_SESSION['idUser'], $_POST['comment']);
    }
    header("Location: article.php?id={$articleId}");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article['title']); ?> - Car Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="index.php" class="text-2xl font-bold text-gray-800">CarBlog</a>
                <div class="flex items-center space-x-4">
                    <?php if (isset($_SESSION['idUser'])): ?>
                        <a href="logout.php" class="text-gray-600 hover:text-red-600">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="text-gray-600 hover:text-blue-600">Login</a>
                        <a href="register.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Article Content -->
    <div class="max-w-5xl mx-auto px-4 py-6 bg-white shadow-md rounded-lg">
        <h1 class="text-3xl font-bold mb-4"><?php echo htmlspecialchars($article['title']); ?></h1>
        <?php if ($article['img']): ?>
            <img src="<?php echo htmlspecialchars($article['img']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>" class="w-full h-96 object-cover mb-4 rounded-lg">
        <?php endif; ?>
        <p class="text-gray-700 mb-4"><?php echo nl2br(htmlspecialchars($article['contents'])); ?></p>
        <div class="flex flex-wrap gap-2 mb-4">
            <?php foreach ($tags as $tag): ?>
                <span class="bg-gray-200 px-2 py-1 rounded-full text-sm"><?php echo htmlspecialchars($tag['name']); ?></span>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="max-w-5xl mx-auto px-4 py-6 bg-white shadow-md rounded-lg mt-6">
        <h2 class="text-2xl font-bold mb-4">Comments</h2>
        <?php if (isset($_SESSION['idUser'])): ?>
            <form action="" method="POST" class="mb-6">
                <textarea name="comment" rows="4" class="w-full px-4 py-2 border rounded-lg mb-4" placeholder="Add a comment..."></textarea>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Submit</button>
            </form>
        <?php else: ?>
            <p class="text-gray-600 mb-6">You need to <a href="login.php" class="text-blue-600">log in</a> to add a comment.</p>
        <?php endif; ?>

        <?php foreach ($comments as $comment): ?>
            <div class="mb-4">
                <p class="text-gray-600"><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                <p class="text-gray-400 text-sm"><?php echo $comment['created_at']; ?></p>

                <?php if (isset($_SESSION['idUser']) && $_SESSION['idUser'] == $comment['idUser']): ?>
                    <!-- Edit Comment -->
                    <button onclick="openEditPopup('<?php echo $comment['comment_id']; ?>', '<?php echo addslashes(htmlspecialchars($comment['content'])); ?>')" class="text-blue-600 hover:text-blue-800">Edit</button>

                    <!-- Delete Comment -->
                    <form action="" method="POST" class="mt-2">
                        <input type="hidden" name="delete_comment" value="<?php echo $comment['comment_id']; ?>">
                        <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Edit Comment Popup -->
    <div id="edit-comment-popup" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h3 class="text-xl font-bold mb-4">Edit Your Comment</h3>
            <form id="edit-comment-form" action="" method="POST">
    <textarea name="comment" rows="4" class="w-full px-4 py-2 border rounded-lg mb-4" placeholder="Edit your comment..."></textarea>
    <input type="hidden" name="comment_id" id="comment_id"> 
    <button type="submit" name="edit_comment" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Save Changes</button>
    <button type="button" onclick="closePopup()" class="mt-4 text-red-600">Cancel</button>
</form>

        </div>
    </div>

    <script>
        function openEditPopup(commentId, commentContent) {
            document.getElementById('edit-comment-popup').classList.remove('hidden');
            document.getElementById('comment_id').value = commentId;
            document.querySelector('textarea[name="comment"]').value = commentContent;
        }

        function closePopup() {
            document.getElementById('edit-comment-popup').classList.add('hidden');
        }
    </script>
</body>
</html>
