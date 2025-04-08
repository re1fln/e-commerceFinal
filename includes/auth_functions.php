<?php
function check_auth() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ".BASE_URL."/login.php");
        exit();
    }
}

function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function login_user($email, $password) {
    global $dbh;
    
    $stmt = $dbh->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        return true;
    }
    
    return false;
}
?>