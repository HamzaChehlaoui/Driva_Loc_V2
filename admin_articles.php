
<!-- admin_articles.php -->
<?php
session_start();
if(!isset($_SESSION['idUser']) || $_SESSION['idUser'] != 1) {
    header('Location: index.php');
    exit();
}

require("conn.php");
require("Articles.php");

$database = new Database();
$db = $database->getConnection();
$articleObj = new Article($db);

// Handle approval/rejection
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $article_id = $_POST['article_id'] ?? null;
    $action = $_POST['action'] ?? null;
    
    if ($article_id && $action) {
        $status = $action === 'approve' ? 'approved' : 'rejected';
        $is_approved = $action === 'approve' ? 1 : 0;
        
        $stmt = $db->prepare("UPDATE articles SET status = ?, is_approved = ? WHERE article_id = ?");
        $stmt->execute([$status, $is_approved, $article_id]);
        
        header('Location: admin_articles.php');
        exit();
    }
}

// Get pending articles
$stmt = $db->prepare("
    SELECT a.*, u.nom as author_name, t.name as theme_name 
    FROM articles a 
    LEFT JOIN user u ON a.idUser = u.idUser 
    LEFT JOIN themes t ON a.theme_id = t.theme_id 
    WHERE a.status = 'pending' 
    ORDER BY a.created_at DESC
");
$stmt->execute();
$pending_articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Article Approval</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg mb-6">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">Admin Dashboard</h1>
                <a href="blogger.php" class="text-gray-600 hover:text-blue-600">Back to Blog</a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-xl font-bold mb-4">Pending Articles</h2>
        
        <div class="grid gap-6">
            <?php foreach($pending_articles as $article): ?>
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-bold"><?php echo htmlspecialchars($article['title']); ?></h3>
                            <p class="text-gray-600">
                                By <?php echo htmlspecialchars($article['author_name']); ?> | 
                                Theme: <?php echo htmlspecialchars($article['theme_name']); ?> |
                                Submitted: <?php echo date('F j, Y', strtotime($article['created_at'])); ?>
                            </p>
                        </div>
                        
                        <div class="flex gap-2">
                            <form method="POST" class="inline">
                                <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>">
                                <input type="hidden" name="action" value="approve">
                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                                    <i class="fas fa-check mr-2"></i>Approve
                                </button>
                            </form>
                            
                            <form method="POST" class="inline">
                                <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>">
                                <input type="hidden" name="action" value="reject">
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                                    <i class="fas fa-times mr-2"></i>Reject
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <?php if($article['img']): ?>
                        <img src="<?php echo htmlspecialchars($article['img']); ?>" 
                             alt="Article image" 
                             class="w-full h-48 object-cover rounded-lg mb-4">
                    <?php endif; ?>
                    
                    <div class="prose max-w-none">
                        <?php echo nl2br(htmlspecialchars($article['contents'])); ?>
                    </div>
                    
                    <div class="mt-4">
                        <?php
                        $tags = $articleObj->getArticleTags($article['article_id']);
                        foreach($tags as $tag):
                        ?>
                            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">
                                <?php echo htmlspecialchars($tag['name']); ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <?php if(empty($pending_articles)): ?>
                <div class="bg-white rounded-lg shadow-lg p-6 text-center text-gray-600">
                    No pending articles to review.
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>