<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inria+Serif:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    
    <title>UM:CCE | Dashboard</title>
    <style>
        
    </style>
</head>
<body>
    <div class="dashboard">
        <?php
        if (isset($_SESSION['message'])) {
            echo "<div class='success-message'>" . htmlspecialchars($_SESSION['message']) . "</div>";
            unset($_SESSION['message']);
        }
        ?>
        
        <div class="welcome-container">
            <h1>Welcome Back! 🎉</h1>
            
            <div class="user-info">
                <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
                <p><strong>Contact:</strong> <?php echo htmlspecialchars($_SESSION['user_contact']); ?></p>
            </div>

            <p class="message">
                You are successfully logged into your UM:CCE account!
            </p>

            <form class="logout-form" action="formhandler.php" method="POST">
                <input type="hidden" name="action" value="logout">
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>
