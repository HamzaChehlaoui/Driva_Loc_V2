<?php
session_start();
require_once("../conn.php");
require_once("../Favorite.php");

// Check if user is logged in
if (!isset($_SESSION['idUser'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
$articleId = isset($data['article_id']) ? (int)$data['article_id'] : 0;

if ($articleId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid article ID']);
    exit;
}

try {
    $database = new Database();
    $db = $database->getConnection();
    $favoriteObj = new Favorite($db);
    
    $userId = $_SESSION['idUser'];
    
    // Check if already favorited
    if ($favoriteObj->isFavorite($userId, $articleId)) {
        // Remove from favorites
        $result = $favoriteObj->removeFavorite($userId, $articleId);
        $message = "Removed from favorites";
    } else {
        // Add to favorites
        $result = $favoriteObj->addFavorite($userId, $articleId);
        $message = "Added to favorites";
    }
    
    echo json_encode([
        'success' => true, 
        'isFavorite' => $favoriteObj->isFavorite($userId, $articleId),
        'message' => $message
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}