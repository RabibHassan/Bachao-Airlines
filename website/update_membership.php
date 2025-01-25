<?php
require_once 'config.php';

function updateMembershipLevel($user_id) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT reward_point, membership_level FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    $points = $user['reward_point'];
    $current_level = $user['membership_level'];
    
    $new_level = 'Bronze';
    if ($points >= 1001) {
        $new_level = 'Gold';
    } elseif ($points >= 501) {
        $new_level = 'Silver';
    }
    
    $levels = ['Bronze' => 1, 'Silver' => 2, 'Gold' => 3];
    if ($levels[$new_level] > $levels[$current_level]) {
        $update = $conn->prepare("UPDATE users SET membership_level = ? WHERE user_id = ?");
        $update->bind_param("si", $new_level, $user_id);
        $update->execute();
        return $new_level;
    }
    
    return $current_level;
}