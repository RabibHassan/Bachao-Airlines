<?php
session_start();
require_once 'config.php';
require_once 'admin_check.php';
checkAdmin();

if (isset($_GET['id'])) {
    try {
        $booking_id = $_GET['id'];
        
        $delete_transaction = $conn->prepare("DELETE FROM transactions WHERE id = ?");
        $delete_transaction->bind_param("i", $booking_id);
        
        if (!$delete_transaction->execute()) {
            throw new Exception("Failed to delete booking: " . $delete_transaction->error);
        }
        
        if ($delete_transaction->affected_rows === 0) {
            throw new Exception("No booking found with ID: " . $booking_id);
        }
        
        $_SESSION['success_msg'] = "Booking #" . $booking_id . " cancelled successfully";
        
    } catch (Exception $e) {
        $_SESSION['error_msg'] = "Error: " . $e->getMessage();
    }
}

header("Location: admin_bookings.php");
exit();
?>