<?php
session_start();
require_once("../conn.php");
require_once("../Articles.php");

header('Content-Type: application/json');

if (!isset($_SESSION['idUser'])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$articleId = isset($data['article_id']) ? (int)$data['article_id'] : 0;

if (!$articleId) {
    echo json_encode(['success' => false, 'message' => 'Invalid article ID']);
    exit;
}

$database = new Database();
$db = $database->getConnection();
$articleObj = new Article($db);

$article = $articleObj->getArticleById($articleId);
if($_SESSION['idUser'] !=1){
if (!$article || ($article['idUser'] != $_SESSION['idUser'] )) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized to delete this article']);
    exit;
}
}
if ($articleObj->deleteArticle($articleId)) {
    echo json_encode(['success' => true, 'message' => 'Article deleted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete article']);
}