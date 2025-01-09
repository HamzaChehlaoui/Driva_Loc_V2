<?php
require 'theme.php';

if (isset($_POST['submit'])) {
    echo 'hamza';

    $neme = $_POST['name_theme'];



    $database = new Database();
    $db = $database->getConnection();

    $thame = new theme($db);

    $theme->name = $neme;


    if ($thame->addtheme()) {
        echo "Category added successfully!";
        header('Location:admin.php');
    } else {
        echo "Error adding category.";
    }
}
?>
