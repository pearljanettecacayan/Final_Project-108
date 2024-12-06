<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        background: linear-gradient(45deg, #A87676, #A87676, #CA8787, #E1ACAC, #A87676, #E1ACAC, #CA8787, #A87676, #A87676);
        background-size: 400% 400%;
        animation: gradientAnimation 8s ease infinite;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
      }

      @keyframes gradientAnimation {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
      }

      .login-form {
        background-color: rgba(255, 255, 255, 0.8);
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 500px;
      }

      .login-form h1,
      .login-form h5 {
        text-align: center;
        margin-bottom: 20px;
        color: #A87676;
      }

      .login-form label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #A87676;
      }

      .input-container {
        position: relative;
        margin-bottom: 15px;
      }

      .login-form input {
        width: 90%;
        padding: 10px;
        padding-left: 40px;
        border: 1px solid #ddd;
        border-radius: 4px;
        color: #A87676;
      }

      .login-form input:focus {
        border-color: #CA8787;
        outline: none;
      }

      .input-icon {
        position: absolute;
        top: 50%;
        left: 10px;
        transform: translateY(-50%);
        color: #A87676;
        font-size: 18px;
      }

      .login-form button {
        display: block;
        width: 99%;
        padding: 10px;
        background-color: #A87676;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        margin: 0 auto;
      }

      .login-form button:hover {
        background-color: #CA8787;
      }

      @keyframes moveLogo {
        0% { transform: translateX(0); }
        50% { transform: translateX(20px); }
        100% { transform: translateX(0); }
      }

      .logo {
        animation: moveLogo 2s ease-in-out infinite;
      }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="login-form">
        <div class="logo-container" style="text-align: center;">
            <img src="../images/logo.png" class="logo" style="width: 100px; height: auto;">
        </div>
        <h1 class="text-center">Welcome to FitFusion</h1>
        <h5>Login to Your Account</h5>
        <form action="../serverdb/loginAdmindb.php" method="post">
            <label for="email">Email</label>
            <div class="input-container">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" id="email" name="email" required>
            </div>

            <label for="password">Password</label>
            <div class="input-container">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>