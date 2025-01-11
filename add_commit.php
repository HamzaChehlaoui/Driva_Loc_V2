<?php
require 'commit.php';
session_start();
$article_id = $_GET['id_article'];
$idUser = $_SESSION['idUser'];

if (!isset($_GET['id_article']) || !isset($_SESSION['idUser'])) {
    die("Missing article ID or user session.");
}


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
