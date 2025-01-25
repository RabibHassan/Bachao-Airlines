<?php
session_start();
require_once 'config.php';
require_once 'update_membership.php';

if (!isset($_SESSION['transaction_id'])) {
    header("Location: dashboard.php");
    exit();
}

$transaction_id = $_SESSION['transaction_id'];

$stmt = $conn->prepare("
    SELECT t.*, f.Flight_from, f.Flight_to, f.Start_date, f.Start_time, f.Price 
    FROM transactions t 
    JOIN `flight-1` f ON t.flight_id = f.Flight_ID 
    WHERE t.id = ?
");
$stmt->bind_param("i", $transaction_id);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Confirmation - Bachao Airlines</title>
    <link href="https://fonts.googleapis.com/css2?family=Murecho:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: 'Murecho', sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        }
        .success-icon {
            text-align: center;
            color: #2da0a8;
            font-size: 48px;
            margin: 20px 0;
        }
        .booking-details {
            margin: 20px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        .print-btn {
            background: #2da0a8;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .print-btn:hover {
            background: #248f96;
        }
        .price-breakdown {
            margin-top: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .price-breakdown hr {
            border: none;
            border-top: 1px solid #ddd;
            margin: 15px 0;
        }

        .price-breakdown .total {
            font-size: 1.2em;
            color: #2da0a8;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        
        <h1>Booking Confirmed!</h1>
        <p>Thank you for choosing Bachao Airlines. Your booking has been confirmed.</p>
        
        <div class="booking-details">
            <h2>Booking Details</h2>
            <p><strong>Booking ID:</strong> <?php echo htmlspecialchars($booking['id']); ?></p>
            <p><strong>Passenger:</strong> <?php echo htmlspecialchars($booking['passenger_name']); ?></p>
            <p><strong>Flight:</strong> <?php echo htmlspecialchars($booking['Flight_from']); ?> to <?php echo htmlspecialchars($booking['Flight_to']); ?></p>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($booking['Start_date']); ?></p>
            <p><strong>Time:</strong> <?php echo htmlspecialchars($booking['Start_time']); ?></p>
            <p><strong>Seat Type:</strong> <?php echo htmlspecialchars($booking['seat_type']); ?></p>
            <p><strong>Seat Number:</strong> <?php echo htmlspecialchars($booking['seat_number']); ?></p>
            
            <div class="price-breakdown">
                <h3>Price Details</h3>
                <p><strong>Base Fare:</strong> ৳<?php echo number_format($booking['amount']); ?></p>
                <p><strong>Insurance:</strong> ৳<?php echo number_format($booking['insurance_amount']); ?></p>
                <hr>
                <p class="total"><strong>Total Amount:</strong> ৳<?php echo number_format($booking['amount'] + $booking['insurance_amount']); ?></p>
            </div>
        </div>
        
        <button onclick="window.print()" class="print-btn">
            <i class="fas fa-print"></i> Print Ticket
        </button>
        
        <p><a href="dashboard.php">Return to Dashboard</a></p>
    </div>
</body>
</html>
<?php
$add_booking_points = $conn->prepare("UPDATE users SET reward_point = reward_point + 100 WHERE user_id = ?");
$add_booking_points->bind_param("i", $_SESSION['user_id']);
$add_booking_points->execute();

$user_query = $conn->prepare("SELECT reward_point FROM users WHERE user_id = ?");
$user_query->bind_param("i", $_SESSION['user_id']);
$user_query->execute();
$user_data = $user_query->get_result()->fetch_assoc();
$had_discount = $user_data['reward_point'] >= 500;

if ($had_discount) {
    $deduct_points = $conn->prepare("UPDATE users SET reward_point = reward_point - 500 WHERE user_id = ?");
    $deduct_points->bind_param("i", $_SESSION['user_id']);
    $deduct_points->execute();
    
    error_log("Deducted 500 points from user " . $_SESSION['user_id'] . " for discount usage");
}

updateMembershipLevel($_SESSION['user_id']);
?>
