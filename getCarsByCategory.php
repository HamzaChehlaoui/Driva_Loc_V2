<?php
require('conn.php');
require('care.php');

if (isset($_GET['category'])) {
    $categoryId = $_GET['category'];
    
    $db = new Database();
    $connection = $db->getConnection();
    
    $query = $connection->prepare("SELECT * FROM vehicule WHERE categorieId = :categoryId");
    $query->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
    $query->execute();
    
    if ($query->rowCount() > 0) {
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            echo '
                <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg transform transition duration-300 hover:scale-105 hover:shadow-2xl cursor-pointer car-card">
                    <img src="' . $row['img'] . '" alt="Car image" class="w-full h-60 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold mb-2">' . $row['modele'] . '</h3>
                        <div class="info-section hidden">
                            <p class="text-gray-400 mb-4">Prix : ' . $row['prix'] . '</p>
                            <p class="text-gray-400 mb-4">Disponible : ' . $row['disponible'] . '</p>
                        </div>
                        <a href="reservationuser.php">
                            <div class="mt-4 flex justify-center">
                                <svg class="bg-[#fff] opacity-60" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 19.5C10 20.3284 9.32843 21 8.5 21C7.67157 21 7 20.3284 7 19.5C7 18.6716 7.67157 18 8.5 18C9.32843 18 10 18.6716 10 19.5Z" stroke="black" stroke-width="null" class="my-path"></path>
                                    <path d="M18 19.5C18 20.3284 17.3284 21 16.5 21C15.6716 21 15 20.3284 15 19.5C15 18.6716 15.6716 18 16.5 18C17.3284 18 18 18.6716 18 19.5Z" stroke="black" stroke-width="null" class="my-path"></path>
                                    <path d="M21 15H11C8.17157 15 6.75736 15 5.87868 14.1213C5 13.2426 5 11.8284 5 9V5C5 3.89543 4.10457 3 3 3" stroke="black" stroke-width="null" stroke-linecap="round" class="my-path"></path>
                                    <path d="M9 7.5C9 6.09554 9 5.39331 9.33706 4.88886C9.48298 4.67048 9.67048 4.48298 9.88886 4.33706C10.3933 4 11.0955 4 12.5 4H16.5C17.9045 4 18.6067 4 19.1111 4.33706C19.3295 4.48298 19.517 4.67048 19.6629 4.88886C20 5.39331 20 6.09554 20 7.5C20 8.90446 20 9.60669 19.6629 10.1111C19.517 10.3295 19.3295 10.517 19.1111 10.6629C18.6067 11 17.9045 11 16.5 11H12.5C11.0955 11 10.3933 11 9.88886 10.6629C9.67048 10.517 9.48298 10.3295 9.33706 10.1111C9 9.60669 9 8.90446 9 7.5Z" stroke="black" stroke-width="null" class="my-path"></path>
                                </svg> 
                            </div>
                        </a>
                    </div>
                </div>';
        }
    } else {
        echo '<p class="text-white">No cars found in this category.</p>';
    }
}
?>
