<?php
include('conn.php');  
include('Classcreate_cont.php');      

if (isset($_POST['submit'])) {

    $db = new Database(); 
    $user = new User($db);   
    $user->setEmail($_POST['email']);        
    $user->setPassword($_POST['motDepasse']);
    $user->setFirstName($_POST['nome']);
    $user->setLastName($_POST['adresse']);
    $user->setRoleId(2);

    $response = $user->register(); 

    
    header("Location:user.php");
    exit;  

    echo "<div class='text-center mt-4'>" . $response . "</div>";

    $db->close(); 
}
?>