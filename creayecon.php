<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind Registration Template</title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">
    <link rel="stylesheet" href="styles.css">
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');

        .font-family-karla {
            font-family: karla;
        }

        /* Keyframes for sliding in from the right */
        @keyframes slideInRight {
            0% {
                transform: translateX(100%);
            }
            100% {
                transform: translateX(0);
            }
        }

        /* Keyframes for sliding in from the left */
        @keyframes slideInLeft {
            0% {
                transform: translateX(-100%);
            }
            100% {
                transform: translateX(0);
            }
        }

        /* Apply the animation to the registration section */
        .slide-in-right {
            animation: slideInRight 1s ease-out;
        }

        /* Apply the animation to the image section */
        .slide-in-left {
            animation: slideInLeft 1s ease-out;
        }
    </style>
</head>
<body class="bg-white font-family-karla h-screen overflow-hidden">
    
    <div class="w-full flex flex-wrap">
        <!-- Image Section -->
        <div class="w-1/2 shadow-2xl slide-in-left ">
            <img class="object-cover w-full h-screen md:block" src="img_sit/994894e4-21a3-40d4-95c1-4d36e7b57c2b.jpeg" alt="Image">
        </div>
  
        <!-- Registration Section -->
        <div class="w-full md:w-1/2 flex flex-col slide-in-right">
            <div class="flex flex-col justify-center md:justify-start my-auto pt-8 md:pt-0 px-8 md:px-24 lg:px-32">
                <p class="text-center text-3xl">Create an Account</p>
                <form action="insertCont.php" method="POST" class="flex flex-col pt-3 md:pt-8">
                    
                    <div class="flex flex-col pt-4">
                        <label for="first-name" class="text-lg">full name</label>
                        <input type="text" name="nome" id="first-name" placeholder="First name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="flex flex-col pt-4">
                        <label for="last-name" class="text-lg">Adresse</label>
                        <input type="text" name="adresse" id="last-name" placeholder="Last name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="flex flex-col pt-4">
                        <label for="email" class="text-lg">Email</label>
                        <input type="email" name="email" id="email" placeholder="your@email.com" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="flex flex-col pt-4">
                        <label for="password" class="text-lg">Password</label>
                        <input type="password" name="motDepasse" id="password" placeholder="Password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <input type="submit" value="Create Account" name="submit" class="bg-black text-white font-bold text-lg hover:bg-gray-700 p-2 mt-8">
                </form>
                <div class="text-center pt-12 pb-12">
                    <p>Already have an account? <a href="index.php" class="underline font-semibold">Login here.</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
