<?php
session_start();
require_once 'config.php';
require_once 'admin_check.php';
checkAdmin();

if (isset($_GET['id'])) {
    try {
        $user_id = $_GET['id'];
        
        $check = $conn->prepare("SELECT user_type FROM users WHERE user_id = ?");
        $check->bind_param("i", $user_id);
        $check->execute();
        $result = $check->get_result()->fetch_assoc();
        
        if (!$result) {
            throw new Exception("User not found");
        }
        
        if ($result['user_type'] === 'Admin') {
            $_SESSION['error_msg'] = "Cannot delete Admin users";
            header("Location: admin_users.php");
            exit();
        }
        
        if ($user_id == $_SESSION['user_id']) {
            $_SESSION['error_msg'] = "Cannot delete your own account";
            header("Location: admin_users.php");
            exit();
        }
        
        $conn->begin_transaction();
        
        $stmt = $conn->prepare("DELETE FROM transactions WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        
        $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        
        $conn->commit();
        
        $_SESSION['success_msg'] = "User deleted successfully";
        
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['error_msg'] = $e->getMessage();
    }
}

header("Location: admin_users.php");
exit();
?>