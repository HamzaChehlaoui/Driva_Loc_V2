<?php
require_once 'Category.php';

if (isset($_POST['submit'])) {

    $nom = $_POST['nom'];
    $description = $_POST['description'];


    $database = new Database();
    $db = $database->getConnection();

    $category = new Category($db);

    $category->nom = $nom;
    $category->description = $description;

    if ($category->addCategory()) {
        echo "Category added successfully!";
        header('Location:admin.php');
    } else {
        echo "Error adding category.";
    }
}
?>
