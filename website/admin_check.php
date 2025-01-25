<?php
function checkAdmin() {
    if (!isset($_SESSION['logged_in']) || $_SESSION['user_type'] !== 'Admin') {
        header("Location: dashboard.php");
        exit();
    }
}