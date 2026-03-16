<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/main.css"> <!-- Main CSS -->

    <link rel="preconnect" href="https://fonts.googleapis.com"> <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inria+Serif:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    
    <title>UM:CCE | Sign In</title>
</head>
<body>
    <div class="limiter">
        <!-- LEFT SIDE -->
        <div class="left">
            <?php
            session_start();
            if (isset($_SESSION['error'])) {
                echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px 0; margin-right: 60%; border-left: 4px solid #f5c6cb; font-family: Inter;'>" . htmlspecialchars($_SESSION['error']) . "</div>";
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['message'])) {
                echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0; margin-right: 60%; border-left: 4px solid #28a745; font-family: Inter;'>" . htmlspecialchars($_SESSION['message']) . "</div>";
                unset($_SESSION['message']);
            }
            ?>
            <form class="login" action="formhandler.php" method="POST">
                <input type="hidden" name="action" value="login">
                <span class="Logo">
                    <img src="images/logo.png" alt="Logo">
                </span>
                <br>
                <h2>Login to your Account</h2>
                <span class="welcome-back">
                    Welcome Back!
                </span>

                <div>
                    <input class="email-input-block" type="text" name="email" placeholder="Email Address" required>
                </div>

                <div>
                    <input class="password-input-block" type="password" name="pass" placeholder="• • • • • • • •" required>
                </div>

                <div>
                    <button type="submit" class="login-btn">
                        Login
                    </button>
                </div>

                <div>
                    <a href="register.php" class="signup-btn" style="text-decoration: none; display: block; text-align: center;">
                        Create an Account
                    </a>
                    <button type="button" class="signup-btn" onclick="alert('Google Sign Up - Coming soon!')">
                        <span class="symbol">
                            <img src="images/search.png" alt="Google Icon">
                        </span>
                        Sign Up with Google
                    </button>
                </div>
            </form>
        </div>
        <!-- RIGHT SIDE -->
        <div class="right">
            <img src="images/login-bg.png" alt="IMG">
        </div>
    </div>
</body>
</html>
