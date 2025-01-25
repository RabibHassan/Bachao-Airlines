<?php
session_start();
require_once 'config.php';
require_once 'admin_check.php';
checkAdmin();

$bookings_query = "SELECT t.*, u.first_name, u.last_name, u.email, u.phone, 
                   f.Flight_from, f.Flight_to, f.Start_date, f.Start_time, f.Flight_ID 
                   FROM transactions t 
                   JOIN users u ON t.user_id = u.user_id 
                   JOIN `flight-1` f ON t.flight_id = f.Flight_ID 
                   ORDER BY t.id DESC";
$bookings = $conn->query($bookings_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Bookings - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Murecho:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Murecho', sans-serif;
            margin: 0;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding-bottom: 50px;
        }

        .admin-nav {
            background: white;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .bookings-table {
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            overflow: hidden;
            animation: slideDown 0.5s ease;
        }

        .bookings-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .bookings-table th {
            background: #2da0a8;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 700;
            font-size: 14px;
        }

        .bookings-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .bookings-table tr:hover {
            background: rgba(45,160,168,0.05);
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

        .action-btn {
            padding: 8px 15px;
            border-radius: 25px;
            color: white;
            text-decoration: none;
            font-weight: 700;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .view-btn { background: #2da0a8; }
        .cancel-btn { background: #e74c3c; }

        .action-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="admin-nav">
        <div class="container">
            <a href="admin.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <div class="container">
        <div class="bookings-table">
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Flight Info</th>
                        <th>Passenger</th>
                        <th>Contact</th>
                        <th>Seat</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($booking = $bookings->fetch_assoc()): ?>
                        <tr>
                            <td>#<?php echo $booking['id']; ?></td>
                            <td>
                                <?php echo htmlspecialchars($booking['Flight_ID']); ?><br>
                                <small><?php echo htmlspecialchars($booking['Flight_from'] . ' → ' . $booking['Flight_to']); ?></small>
                            </td>
                            <td><?php echo htmlspecialchars($booking['first_name'] . ' ' . $booking['last_name']); ?></td>
                            <td>
                                <?php echo htmlspecialchars($booking['email']); ?><br>
                                <small><?php echo htmlspecialchars($booking['phone']); ?></small>
                            </td>
                            <td><?php echo htmlspecialchars($booking['seat_number']); ?></td>
                            <td>৳<?php echo number_format($booking['amount']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($booking['Start_date'])); ?></td>
                            <td>
                                <a href="admin_booking_view.php?id=<?php echo $booking['id']; ?>" class="action-btn view-btn">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="admin_booking_cancel.php?id=<?php echo $booking['id']; ?>" 
                                   class="action-btn cancel-btn"
                                   onclick="return confirm('Are you sure you want to cancel this booking?')">
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>