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

    

<div class="max-w-5xl mx-auto px-4 py-6 bg-white shadow-md rounded-lg mt-6">
    <h2 class="text-2xl font-bold mb-4">Comments</h2>
    <?php if (isset($_SESSION['idUser'])): ?>
        <form action="" method="POST" class="mb-6">
            <textarea 
                name="comment" 
                rows="4" 
                class="w-full px-4 py-2 border rounded-lg mb-4 focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none" 
                placeholder="Add a comment..."
            ></textarea>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Submit
            </button>
        </form>
    <?php else: ?>
        <p class="text-gray-600 mb-6">
            You need to <a href="index.php" class="text-blue-600 hover:text-blue-800">log in</a> to add a comment.
        </p>
    <?php endif; ?>

    <div class="space-y-4">
        <?php foreach ($comments as $comment): ?>
            <div class="bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <p class="text-gray-700 whitespace-pre-wrap mb-2" id="comment-content-<?php echo $comment['comment_id']; ?>">
                            <?php echo nl2br(htmlspecialchars($comment['content'])); ?>
                        </p>
                        <p class="text-sm text-gray-500"><?php echo $comment['created_at']; ?></p>
                    </div>
                    
                    <?php if (isset($_SESSION['idUser']) && $_SESSION['idUser'] == $comment['idUser']): ?>
                        <div class="flex items-center space-x-2 ml-4">
                            <button 
                                onclick="openEditPopup('<?php echo $comment['comment_id']; ?>', '<?php echo addslashes(htmlspecialchars($comment['content'])); ?>')"
                                class="p-1 rounded-full hover:bg-blue-100 text-blue-600 transition-colors"
                            >
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="" method="POST" class="inline">
                                <input type="hidden" name="delete_comment" value="<?php echo $comment['comment_id']; ?>">
                                <button 
                                    type="submit" 
                                    class="p-1 rounded-full hover:bg-red-100 text-red-600 transition-colors"
                                    onclick="return confirm('Are you sure you want to delete this comment?')"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Edit Comment Modal -->
<div id="edit-comment-popup" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Edit Comment</h3>
            <button onclick="closePopup()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="edit-comment-form" action="" method="POST">
            <textarea 
                name="comment" 
                rows="4" 
                class="w-full px-4 py-2 border rounded-lg mb-4 focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                placeholder="Edit your comment..."
            ></textarea>
            <input type="hidden" name="comment_id" id="comment_id">
            <div class="flex justify-end space-x-3">
                <button 
                    type="button" 
                    onclick="closePopup()" 
                    class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors"
                >
                    Cancel
                </button>
                <button 
                    type="submit" 
                    name="edit_comment" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                >
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditPopup(commentId, commentContent) {
        document.getElementById('edit-comment-popup').classList.remove('hidden');
        document.getElementById('comment_id').value = commentId;
        document.querySelector('#edit-comment-form textarea[name="comment"]').value = commentContent;
        document.querySelector('#edit-comment-form textarea[name="comment"]').focus();
    }

    function closePopup() {
        document.getElementById('edit-comment-popup').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('edit-comment-popup').addEventListener('click', function(e) {
        if (e.target === this) {
            closePopup();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePopup();
        }
    });
</script>
</body>
</html>
