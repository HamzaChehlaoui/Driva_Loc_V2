<?php 
    require('conn.php');  

    $database = new Database();
    $conn = $database->getConnection();

    $sql = "SELECT a.commentaire, a.note, a.dateAvis, u.nom
            FROM Avis a
            JOIN user u ON a.userId = u.iduser
            ORDER BY a.dateAvis DESC";

    $result = $conn->query($sql); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Black Navbar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   
</head>
<style>
        /* Fade-in animation */
        .fade-in {
            animation: fadeIn 1s ease-in-out forwards;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Slide-in effect */
        .slide-in {
            animation: slideIn 1s ease-out forwards;
        }

        @keyframes slideIn {
            0% {
                opacity: 0;
                transform: translateX(-100%);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Hover animation (scale and shadow) */
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: scale(1.05); /* Slightly enlarge the card */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); /* Add shadow on hover */
        }    /* Custom styles for black and white accents */
    .btn-primary {
      background-color: #000000; /* Black color */
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }
    .btn-primary:hover {
      background-color: #555555; /* Darker grey for hover effect */
    }

  
    /* Custom black-and-white Section */
    .black-section {
      background-color: #333333; /* Dark background */
      color: white; /* White text */
      padding: 50px 0;
      text-align: center;
      perspective: 1500px; 
    }

    .black-section:hover {
      transform: rotateY(0deg) rotateX(0deg) scale(1.05); 
    }

    .country-card {
      perspective: 1000px; /* Create 3D perspective for the card */
    }

    .country-card .card {
      transform-style: preserve-3d;
      transition: transform 0.5s ease;
    }

    .country-card:hover .card {
      transform: rotateY(15deg) rotateX(10deg); 
    }

    .card {
      background-color: #FFFFFF; 
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      height: 100%;
      color: black; /* Black text for the card */
    }

   
</style>
<script>
   function toggleInfo(card) {
       let infoSection = card.querySelector('.info-section');
       infoSection.classList.toggle('hidden'); // Toggles visibility

   }

;


</script>
<body class="bg-black text-[#fff]">

       <!-- Navbar -->
       <nav class="bg-black text-white py-4">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center">
                <!-- Logo or Brand Name -->
                <div class="text-2xl font-bold">
                    <a href="#">MyWebsite</a>
                </div>
                
                <!-- Navbar Links -->
                <div>
                    <ul class="flex space-x-6">
                        <li><a href="user.php" class="hover:bg-gray-700 px-4 py-2 rounded">Home</a></li>
                        <li><a href="showcare.php" class="hover:bg-gray-700 px-4 py-2 rounded">Explore Cars</a></li>
                        <li><a href="showReserv.php" class="hover:bg-gray-700 px-4 py-2 rounded">Reservation</a></li>
                        <li><a href="blogger.php" class="hover:bg-gray-700 px-4 py-2 rounded">Blogger</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- Image at the Beginning of the Page -->
    <section class="relative">
        <img src="img_sit/4k-wallpaper-sports-cars-on-track-v0-tuocu8x929sa1.jpg" class="h-[600px] w-[100%]">
        <div class="absolute inset-0 bg-black bg-opacity-50 flex justify-center items-center text-center p-4">
            <div>
                <h2 class="text-4xl font-semibold mb-4 text-white">Find Your Perfect Car</h2>
                <p class="text-xl mb-8 text-white">Explore our wide selection of rental cars and hit the road today.</p>
                <div class="relative">
      
    <div class="flex items-center justify-center">
       
                <h2 class="   w-[10rem] h-10 text-[1.5rem]  transform rotate-45 origin-center animate-bounce">Down scroll</h2>
      </div>
            </div>
        </div>
    </section>
    <!-- Car Rental Options -->
    <section class="container flex py-16 px-4 justify-center">
    <a href="showcare.php"><span class="text-3xl font-semibold text-center mb-12 hover:bg-gray-700 px-4 py-2 rounded">Explore Cars</span></a>
    
</section>
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10 mx-[5px]">

<!-- Country Card 1 with 3D effect -->

  <div class="country-card">
    <div class="card">
      <img src="https://38.media.tumblr.com/783af4bdcf4d3058e5091ddfe3535fb0/tumblr_nlr9mleWgp1rwtzqno1_540.gif" alt="Country Image" class="w-full h-48 object-cover rounded-t-lg">
      <div class="p-6">
      <a  href="showcare.php">
        
        <button type="button" class="text-white bg-black  focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-black dark:focus:ring-blue-800">
        Explore Cars
<svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
</svg>
</button></a>
       
      </div>
    </div>
  </div>
  <div class="country-card">
    <div class="card">
      <img src="https://steamuserimages-a.akamaihd.net/ugc/942823742473357672/28E0C4506B7F15D51213F7262DF0E1A98E19DF09/?imw=5000&imh=5000&ima=fit&impolicy=Letterbox&imcolor=%23000000&letterbox=false" alt="Country Image" class="w-full h-48 object-cover rounded-t-lg">
      <div class="p-6">
      <a  href="showcare.php">
        
        <button type="button" class="text-white bg-black  focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-black dark:focus:ring-blue-800">
        Explore Cars
<svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
</svg>
</button></a>
       
      </div>
    </div>
  </div>
  <div class="country-card">
    <div class="card">
      <img src="https://wallpapers-clan.com/wp-content/uploads/2024/04/bmw-on-street-in-rain-gif-desktop-wallpaper-preview.gif" alt="Country Image" class="w-full h-48 object-cover rounded-t-lg">
      <div class="p-6">
      <a  href="showcare.php">
        
        <button type="button" class="text-white bg-black  focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-black dark:focus:ring-blue-800">
        Explore Cars
<svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
</svg>
</button></a>
       
      </div>
    </div>
  </div>
  <div class="country-card">
    <div class="card">
      <img src="https://i.pinimg.com/originals/fe/6b/6b/fe6b6b794fc330b9c23468b09867a4e9.gif" alt="Country Image" class="w-full h-48 object-cover rounded-t-lg">
      <div class="p-6">
      <a  href="showcare.php">
        
        <button type="button" class="text-white bg-black  focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-black dark:focus:ring-blue-800">
        Explore Cars
<svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
</svg>
</button></a>
       
      </div>
    </div>
  </div>
  <div class="country-card">
    <div class="card">
      <img src="https://masterpiecer-images.s3.yandex.net/5fb936448ef311eeb5752656ee3db587:upscaled" alt="Country Image" class="w-full h-48 object-cover rounded-t-lg">
      <div class="p-6">
    

        <a  href="showcare.php">
        
        <button type="button" class="text-white bg-black  focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-black dark:focus:ring-blue-800">
        Explore Cars
<svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
</svg>
</button></a>
      </div>
    </div>
  </div>
  <div class="country-card">
    <div class="card">
      <img src="https://imgcdn.stablediffusionweb.com/2024/11/27/0f96fdeb-e057-4728-8530-0ff852d1de78.jpg" alt="Country Image" class="w-full h-48 object-cover rounded-t-lg">
      <div class="p-6">
      <a  href="showcare.php">
        
        <button type="button" class="text-white bg-black  focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-black dark:focus:ring-blue-800">
        Explore Cars
<svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
</svg>
</button></a>
      </div>
    </div>
  </div>
  <div class="country-card">
    <div class="card">
      <img src="https://pbs.twimg.com/media/GLfEDfmbEAAg3ww.jpg:large" alt="Country Image" class="w-full h-48 object-cover rounded-t-lg">
      <div class="p-6">
      <a  href="showcare.php">
        
        <button type="button" class="text-white bg-black  focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-black dark:focus:ring-blue-800">
        Explore Cars
<svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
</svg>
</button></a>
      
      </div>
    </div>
  </div>
  <div class="country-card">
    <div class="card">
      <img src="https://masterpiecer-images.s3.yandex.net/c174cade9a2411ee89b9f6744ca365da:upscaled" alt="Country Image" class="w-full h-48 object-cover rounded-t-lg">
      <div class="p-6">
      <a  href="showcare.php">
        
        <button type="button" class="text-white bg-black focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-black dark:focus:ring-blue-800">
        Explore Cars
<svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
</svg>
</button></a>
       
      </div>
    </div>
  </div>
</div>







<section>
    <!-- Comment Section Container -->
    <div class="max-w-4xl mx-auto p-6 bg-black rounded-lg shadow-lg mt-10">
        <h2 class="text-2xl font-semibold mb-6 text-white">Comments</h2>

        <!-- Existing Comments -->
        <div class="space-y-6">
            <!-- Comment 1 -->
            <div class="p-4 border rounded-lg bg-black shadow-sm flex items-start">
                <!-- Avatar Image -->
                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="John Doe" class="w-12 h-12 rounded-full mr-4">
                <div>
                    <p class="font-semibold text-white">John Doe</p>
                    <p class="text-gray-400 mt-2">I recently rented a car from this service, and it was amazing! The vehicle was in great condition and the staff was very helpful. I’ll definitely use them again for my next trip!</p>
                    <div class="mt-2">
                        <!-- Star Rating -->
                        <span class="text-yellow-400">&#9733;</span>
                        <span class="text-yellow-400">&#9733;</span>
                        <span class="text-yellow-400">&#9733;</span>
                        <span class="text-yellow-400">&#9733;</span>
                        <span class="text-gray-500">&#9733;</span> <!-- 4 out of 5 stars -->
                    </div>
                    <div class="mt-4 text-sm text-gray-500">Posted on December 31, 2024</div>
                </div>
            </div>

            <!-- Comment 2 -->
            <div class="p-4 border rounded-lg bg-black shadow-sm flex items-start">
                <!-- Avatar Image -->
                <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Jane Smith" class="w-12 h-12 rounded-full mr-4">
                <div>
                    <p class="font-semibold text-white">Jane Smith</p>
                    <p class="text-gray-400 mt-2">Great car rental experience! The booking process was smooth and easy. I appreciated how quickly the car was ready for pickup. Highly recommend this service for anyone looking for a reliable rental!</p>
                    <div class="mt-2">
                        <!-- Star Rating -->
                        <span class="text-yellow-400">&#9733;</span>
                        <span class="text-yellow-400">&#9733;</span>
                        <span class="text-yellow-400">&#9733;</span>
                        <span class="text-yellow-400">&#9733;</span>
                        <span class="text-yellow-400">&#9733;</span> <!-- 5 out of 5 stars -->
                    </div>
                    <div class="mt-4 text-sm text-gray-500">Posted on December 30, 2024</div>
                </div>
            </div>

            <!-- Comment 3 -->
            <div class="p-4 border rounded-lg bg-black shadow-sm flex items-start">
                <!-- Avatar Image -->
                <img src="https://randomuser.me/api/portraits/men/19.jpg" alt="Mark Johnson" class="w-12 h-12 rounded-full mr-4">
                <div>
                    <p class="font-semibold text-white">Mark Johnson</p>
                    <p class="text-gray-400 mt-2">I rented a luxury car for a weekend getaway, and it was perfect! The car was spotless and comfortable, and I didn’t have any issues at all. I’ll definitely be back next time I need a premium car rental.</p>
                    <div class="mt-2">
                        <!-- Star Rating -->
                        <span class="text-yellow-400">&#9733;</span>
                        <span class="text-yellow-400">&#9733;</span>
                        <span class="text-yellow-400">&#9733;</span>
                        <span class="text-yellow-400">&#9733;</span>
                        <span class="text-yellow-400">&#9733;</span> <!-- 5 out of 5 stars -->
                    </div>
                    <div class="mt-4 text-sm text-gray-500">Posted on December 29, 2024</div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="max-w-4xl mx-auto p-6 bg-black rounded-lg shadow-lg mt-10">

        <?php if ($result->rowCount() > 0): ?>
            <div class="space-y-6">
                <?php while($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="p-4 border rounded-lg bg-black shadow-sm flex items-start">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQaEmzjpUf5XiWcRFKWeDt-Pxf4_cG77GIlsQ&s" alt="" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <p class="font-semibold text-white"><?php echo htmlspecialchars($row['nom']); ?></p>
                            <p class="text-gray-400 mt-2"><?php echo htmlspecialchars($row['commentaire']); ?></p>
                            <div class="mt-2">
                                <?php
                                   $stars = str_repeat('&#9733;', (int)$row['note']);
                                   
                                    echo "<span class='text-yellow-400'>{$stars}</span>";
                                ?>
                            </div>
                            <div class="mt-4 text-sm text-gray-500">Posted on <?php echo htmlspecialchars($row['dateAvis']); ?></div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-white">No comments available at the moment.</p>
        <?php endif; ?>
    </div>
</section>




    <!-- Footer Section -->
    <footer class="bg-gray-800 py-6 mt-16 text-center">
        <p>&copy; 2024 Car Rental. All rights reserved.</p>
    </footer>

<script src="js/script.js"></script>
</body>
</html>
