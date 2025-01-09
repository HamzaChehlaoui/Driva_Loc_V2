<?php
require 'commit.php';
session_start();

if (!isset($_GET['id']) || !isset($_SESSION['idUser'])) {
    die("Missing article ID or user session.");
}

$article_id = $_GET['id'];
$idUser = $_SESSION['idUser'];

if (isset($_POST['submit'])) {

    $content = htmlspecialchars($_POST['content']);

    $database = new Database();
    $db = $database->getConnection();

    $commits = new commit($db);
    $commits->content = $content;
    $commits->article_id = $article_id;
    $commits->idUser = $idUser;

    if ($commits->addCommit()) {
        echo "Comment added successfully!";
        header('Location: show_article.php?id='. $article_id);
        exit(); 
    } else {
        echo "Error adding comment.";
    }
}
?>
