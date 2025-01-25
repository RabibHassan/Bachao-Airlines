<?php
session_start();
require_once 'config.php';
require_once 'admin_check.php';
checkAdmin();

if (isset($_GET['id'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM `flight-1` WHERE Flight_ID = ?");
        $stmt->bind_param("s", $_GET['id']);
        
        if ($stmt->execute()) {
            $_SESSION['success_msg'] = "Flight deleted successfully!";
        } else {
            throw new Exception("Failed to delete flight");
        }
    } catch (Exception $e) {
        $_SESSION['error_msg'] = $e->getMessage();
    }
}

header("Location: admin_flights.php");
exit();
?>