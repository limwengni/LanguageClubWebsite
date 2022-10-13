<?php

session_start();

if (isset($_SESSION['MemberEmail'])) {
    $_SESSION = array(); // Clear the variables.
    session_destroy(); // Destroy the session itself.
    setcookie('MemberEmail', '', time() - 3600, '/', '', 0, 0); // Destroy the cookie.
    header("Location: menu.php");
} else if(isset($_SESSION['AdminEmail'])){
    $_SESSION = array(); // Clear the variables.
    session_destroy(); // Destroy the session itself.
    setcookie('AdminEmail', '', time() - 3600, '/', '', 0, 0); // Destroy the cookie.
    header("Location: menu.php");
}
else{
    header("Location: menu.php");
}

