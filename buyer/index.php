<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(45deg, #A87676, #A87676, #CA8787, #E1ACAC, #A87676, #E1ACAC, #CA8787, #A87676, #A87676);
            background-size: 400% 400%;
            animation: gradientAnimation 8s ease infinite;
            margin: 0;
            padding: 0;
        }

        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

         .header .logo {
            font-size: 24px;
            font-weight: bold;
            color: white;
            display: flex; 
            align-items: center; 
        }

        .header .logo .logo-image {
            width: 30px;
            height: 30px; 
            margin-right: 10px; 
            animation: pumpAnimation 1.5s infinite ease-in-out; 
        }

        @keyframes pumpAnimation {
            0% {
                transform: scale(1); 
            }
            50% {
                transform: scale(1.2); 
            }
            100% {
                transform: scale(1);
            }
        }

        .header {
            width: 100%;
            background-color: #A87676;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            position: absolute;
            top: 0;
            left: 0;
        }

        .header .logo {
            font-size: 24px;
            font-weight: bold;
            color: white;
        }

        .header nav {
            display: flex;
            justify-content: flex-start; 
            gap: 10px; 
            padding-right: 45px; 
        }

        .header a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            font-size: 16px;
            padding: 10px 10px;
            border-radius: 4px;
        }

        .header a:hover {
            background-color: #CA8787;
        }


        .header {
            width: 100%;
            background-color: #A87676;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .container a {
            text-decoration: none;
            color: white;
            background-color: #A87676;
            font-weight: bold;
            font-size: 16px;
            padding: 10px 10px;
            border-radius: 4px;
            transition: all 0.3s ease;
            margin: 5px;
        }

        .container a:hover {
            background-color: #CA8787;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.8), 0 0 30px rgba(255, 255, 255, 0.6); 
            transform: scale(1.05);
            color: #fff; 
        }


        .hero {
            position: relative;
            text-align: center;
            color: white;
            padding: 100px 20px 0;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .hero h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .hero p {
            font-size: 1.2em;
            margin-bottom: 40px;
        }

        .hero-waves {
            position: relative;
            bottom: -1px;
            width: 100%;
            height: 150px;
        }

        svg .wave1 use {
            animation: wave 8s cubic-bezier(0.55, 0.5, 0.45, 0.5) infinite;
        }

        @keyframes wave {
            0% { transform: translate(0, 0); }
            100% { transform: translate(-160px, 0); }
        }

        .hero-waves{
            margin-top: 30px;
            width: 100%;
        }

        .hero .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            gap: 20px; 
        }

        .text-video-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .text {
            flex: 1;
            max-width: 50%; 
        }
        .video {
            flex: 1;
            overflow: hidden;
        }

        video {
            width: 100%;  
            height: auto;
            object-fit: cover;
        }

        .motiv{
            color: #E5E1DA;
        }
    </style>
</head>
<body>   
<header class="header">
    <!-- Logo section (on the left) -->
    <div class="logo">
        <img src="../images/logo.png" class="logo-image">
        FitFusion
    </div>
</header>

<!-- Hero Section -->
<section id="hero" class="hero">
    <img src="assets/img/hero-bg-2.jpg" alt="" class="hero-bg">

    <div class="container">
        <div class="text-video-container">
           <!-- Text section -->
        <div class="text">
        <h1 class="motiv">F I T F U S I O N</h1>
        <p>Focused, Inspired, Tenacious, Fearless, Unstoppable, Strong, Innovative, Outstanding, Never-give-up</p>
           <!-- Navigation links (aligned to the right) -->
    <nav>
        <a href="register.php" class="btn-get-started"><b>Get Started</b></a>
        <a href="login.php"><b>Login</b></a>
    </nav>
        </div>


            <!-- Video section -->
        <div class="video">
            <video autoplay loop muted width="100%" height="auto">
                <source src="../images/bannerimages.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        </div>
    </div>

    <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none">
    <defs>
        <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" fill="#A87676"></path>
    </defs>
    <g class="wave1">
        <use xlink:href="#wave-path" x="50" y="3"></use>
    </g>
    <g class="wave2">
        <use xlink:href="#wave-path" x="50" y="0" ></use>
    </g>
    <g class="wave3">
        <use xlink:href="#wave-path" x="50" y="9"></use>
    </g>
</svg>

</section>


</body>
</html>
