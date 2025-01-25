<?php
session_start();
require_once 'config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
error_log("Session data: " . print_r($_SESSION, true));


if (!isset($_POST['flight_id'])) {
    header("Location: dashboard.php");
    exit();
}

try {
    $conn->begin_transaction();
    
    error_log("Starting new booking process");
    error_log("Flight ID: " . $_POST['flight_id']);
    error_log("Seat Number: " . $_POST['seat_number']);
    
    $seat_check = $conn->prepare("SELECT id FROM seats WHERE flight_id = ? AND seat_number = ? AND status = 'booked'");
    $seat_check->bind_param("ss", $_POST['flight_id'], $_POST['seat_number']);
    $seat_check->execute();
    
    if ($seat_check->get_result()->num_rows > 0) {
        throw new Exception("This seat is already booked");
    }

    $stmt = $conn->prepare("SELECT Price FROM `flight-1` WHERE Flight_ID = ?");
    $stmt->bind_param("s", $_POST['flight_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $flight_data = $result->fetch_assoc();
    $original_fare = $flight_data['Price'];

    $user_query = $conn->prepare("SELECT reward_point FROM users WHERE user_id = ?");
    $user_query->bind_param("i", $_SESSION['user_id']);
    $user_query->execute();
    $user_data = $user_query->get_result()->fetch_assoc();
    $has_discount = $user_data['reward_point'] >= 500;

    $base_fare = $has_discount ? $original_fare * 0.95 : $original_fare;

    $insurance_costs = [
        'none' => 0,
        'basic' => 500,
        'premium' => 1000,
        'elite' => 2000
    ];
    $insurance_plan = $_POST['insurance_plan'] ?? 'none';
    $insurance_amount = $insurance_costs[$insurance_plan];
    $total_amount = $base_fare + $insurance_amount;

    $stmt = $conn->prepare("INSERT INTO transactions 
        (user_id, flight_id, passenger_name, email, phone, passport_number, 
         seat_number, seat_type, payment_method, payment_number, 
         amount, insurance_amount, total_amount) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
    $stmt->bind_param("isssssssssiii",
        $_SESSION['user_id'],
        $_POST['flight_id'],
        $_POST['passenger_name'],
        $_POST['email'],
        $_POST['phone'],
        $_POST['passport'],
        $_POST['seat_number'],
        $_POST['seat_type'],
        $_POST['payment_method'],
        $_POST['payment_number'],
        $base_fare,
        $insurance_amount,
        $total_amount
    );
    
    if (!$stmt->execute()) {
        throw new Exception("Failed to create booking: " . $stmt->error);
    }
    
    $transaction_id = $stmt->insert_id;

    $seat_stmt = $conn->prepare("INSERT INTO seats (flight_id, seat_number, status, transaction_id) 
                                VALUES (?, ?, 'booked', ?)");
    $seat_stmt->bind_param("ssi", $_POST['flight_id'], $_POST['seat_number'], $transaction_id);
    $seat_stmt->execute();
    
    $conn->commit();
    
    $_SESSION['transaction_id'] = $transaction_id;
    header("Location: booking_confirmation.php");
    exit();
    
} catch (Exception $e) {
    $conn->rollback();
    error_log("Booking Error: " . $e->getMessage());
    $_SESSION['error'] = $e->getMessage();
    header("Location: transaction.php?flight_id=" . $_POST['flight_id']);
    exit();
}
?>