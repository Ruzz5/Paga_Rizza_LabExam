<?php
session_start();

$usersFile = 'users.json';

if (!file_exists($usersFile)) {
    file_put_contents($usersFile, json_encode([], JSON_PRETTY_PRINT));
}

function loadUsers() {
    global $usersFile;
    $json = file_get_contents($usersFile);
    return json_decode($json, true) ?? [];
}

function saveUsers($users) {
    global $usersFile;
    file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
}

function registerUser($email, $contact, $password) {
    if (empty($email) || empty($contact) || empty($password)) {
        return ['success' => false, 'message' => 'All fields are required'];
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'message' => 'Invalid email format'];
    }

    if (strlen($password) < 6) {
        return ['success' => false, 'message' => 'Password must be at least 6 characters'];
    }

    $users = loadUsers();

    // Check if email already exists
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            return ['success' => false, 'message' => 'Email already registered'];
        }
    }

    // Create new user
    $newUser = [
        'id' => uniqid(),
        'email' => $email,
        'contact' => $contact,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'created_at' => date('Y-m-d H:i:s')
    ];

    $users[] = $newUser;
    saveUsers($users);

    return ['success' => true, 'message' => 'Registration successful! Please login.'];
}


function loginUser($email, $password) {
    // Validate input
    if (empty($email) || empty($password)) {
        return ['success' => false, 'message' => 'Email and password are required'];
    }

    $users = loadUsers();

    // Find user by email
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_contact'] = $user['contact'];
                $_SESSION['logged_in'] = true;

                return ['success' => true, 'message' => 'Login successful!'];
            } else {
                return ['success' => false, 'message' => 'Incorrect password'];
            }
        }
    }

    return ['success' => false, 'message' => 'Email not found'];
}

// Logout user
function logoutUser() {
    session_destroy();
    return ['success' => true, 'message' => 'Logged out successfully'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'login') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['pass'] ?? '';
        $result = loginUser($email, $password);
        
        if ($result['success']) {
            $_SESSION['message'] = $result['message'];
            header('Location: index.php');
            exit();
        } else {
            $_SESSION['error'] = $result['message'];
            header('Location: login.php');
            exit();
        }
    } 
    elseif ($action === 'register') {
        $email = $_POST['email'] ?? '';
        $contact = $_POST['contact'] ?? '';
        $password = $_POST['pass'] ?? '';
        $result = registerUser($email, $contact, $password);
        
        if ($result['success']) {
            $_SESSION['message'] = $result['message'];
            header('Location: login.php');
            exit();
        } else {
            $_SESSION['error'] = $result['message'];
            header('Location: register.php');
            exit();
        }
    }
    elseif ($action === 'logout') {
        logoutUser();
        header('Location: login.php');
        exit();
    }
}

if (isset($_SESSION['message'])) {
    echo "<div class='success-message'>" . htmlspecialchars($_SESSION['message']) . "</div>";
    unset($_SESSION['message']);
}

if (isset($_SESSION['error'])) {
    echo "<div class='error-message'>" . htmlspecialchars($_SESSION['error']) . "</div>";
    unset($_SESSION['error']);
}
?>