<?php
session_start();
require_once 'config.php';
require_once 'admin_check.php';
checkAdmin();

if (!isset($_GET['id'])) {
    header("Location: admin_bookings.php");
    exit();
}

$booking_id = $_GET['id'];
$query = "SELECT t.*, u.first_name, u.last_name, u.email, u.phone, 
          f.Flight_from, f.Flight_to, f.Start_date, f.Land_date, 
          f.Start_time, f.End_time, f.Flight_ID 
          FROM transactions t 
          JOIN users u ON t.user_id = u.user_id 
          JOIN `flight-1` f ON t.flight_id = f.Flight_ID 
          WHERE t.id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();

if (!$booking) {
    header("Location: admin_bookings.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Booking - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Murecho:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Murecho', sans-serif;
            margin: 0;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .booking-container {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            padding: 30px;
            animation: slideIn 0.5s ease;
        }

        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }

        .booking-id {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
        }

        .section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .info-item {
            margin-bottom: 15px;
        }

        .info-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 16px;
            color: #2c3e50;
            font-weight: 500;
        }

        .back-btn {
            color: rgb(48, 47, 47);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            transform: translateX(-5px);
        }

        .print-btn {
            background: #2da0a8;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .print-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(45,160,168,0.2);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="booking-container">
        <div class="booking-header">
            <a href="admin_bookings.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Bookings
            </a>
            <div class="booking-id">Booking #<?php echo $booking['id']; ?></div>
            <button onclick="window.print()" class="print-btn">
                <i class="fas fa-print"></i> Print
            </button>
        </div>

        <div class="section">
            <div class="section-title">Flight Information</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Flight ID</div>
                    <div class="info-value"><?php echo htmlspecialchars($booking['Flight_ID']); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Route</div>
                    <div class="info-value">
                        <?php echo htmlspecialchars($booking['Flight_from'] . ' → ' . $booking['Flight_to']); ?>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Departure</div>
                    <div class="info-value">
                        <?php echo date('M d, Y', strtotime($booking['Start_date'])) . ' ' . $booking['Start_time']; ?>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Arrival</div>
                    <div class="info-value">
                        <?php echo date('M d, Y', strtotime($booking['Land_date'])) . ' ' . $booking['End_time']; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Passenger Information</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Name</div>
                    <div class="info-value">
                        <?php echo htmlspecialchars($booking['first_name'] . ' ' . $booking['last_name']); ?>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value"><?php echo htmlspecialchars($booking['email']); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Phone</div>
                    <div class="info-value"><?php echo htmlspecialchars($booking['phone']); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>