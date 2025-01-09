<?php
require 'theme.php';

if (isset($_POST['submit'])) {
    echo 'hamza';

    $name = $_POST['name_theme'];



    $database = new Database();
    $db = $database->getConnection();

    $thame = new theme($db);

    $thame->name = $name;


    if ($thame->addtheme()) {
        echo "Category added successfully!";
        header('Location:blogger.php');
    } else {
        echo "Error adding category.";
    }
}
?>
