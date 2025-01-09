<?php
require 'artecle.php';
session_start();
$user_id =  $_SESSION['idUser'];
if (isset($_POST['submit'])) {
    echo 'hamza';

    $titre = $_POST['titre'];
    $content = $_POST['content'];
    $idtheme = $_POST['idtheme'];
    $image = $_POST['image'];


    $database = new Database();
    $db = $database->getConnection();

    $thame = new Article($db);

    $thame->title = $titre;
    $thame->content = $content;
    $thame->user_id = $user_id;
    $thame->idtheme = $idtheme;
    $thame->image = $image;

    if ($thame->addArticle()) {
        echo "Category added successfully!";
        header('Location:blogger.php');
    } else {
        echo "Error adding category.";
    }
}
?>
