<?php
session_start();
require_once 'config.php';
require_once 'admin_check.php';
checkAdmin();

$flights_query = "SELECT * FROM `flight-1` ORDER BY Flight_ID DESC LIMIT 5";
$flights = $conn->query($flights_query);

$users_query = "SELECT * FROM users WHERE user_type != 'admin' ORDER BY user_id DESC LIMIT 5";
$users = $conn->query($users_query);

$total_users = $conn->query("SELECT COUNT(*) as total FROM users WHERE user_type != 'admin'")->fetch_assoc()['total'];
$total_bookings = $conn->query("SELECT COUNT(*) as total FROM transactions")->fetch_assoc()['total'];

$base_revenue = $conn->query("SELECT SUM(amount) as total FROM transactions")->fetch_assoc()['total'];
$total_revenue = $conn->query("SELECT SUM(total_amount) as total FROM transactions")->fetch_assoc()['total'];
$insurance_revenue = $conn->query("SELECT SUM(insurance_amount) as total FROM transactions")->fetch_assoc()['total'];


$recent_bookings_query = "SELECT t.*, u.first_name, u.last_name, f.Flight_from, f.Flight_to, f.Flight_ID 
                         FROM transactions t 
                         JOIN users u ON t.user_id = u.user_id 
                         JOIN `flight-1` f ON t.flight_id = f.Flight_ID 
                         ORDER BY t.id DESC LIMIT 5";
$recent_bookings = $conn->query($recent_bookings_query);

$conn->query("UPDATE transactions SET total_amount = amount WHERE total_amount IS NULL");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Bachao Airlines</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #f5f7fa;
        }
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background: #2c3e50;
            padding: 20px;
            color: white;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        .nav-item {
            padding: 15px;
            color: white;
            text-decoration: none;
            display: block;
            margin: 5px 0;
            border-radius: 5px;
            transition: 0.3s;
        }
        .nav-item:hover {
            background: rgba(255,255,255,0.1);
        }
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card h3 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .stat-card .number {
            font-size: 24px;
            font-weight: bold;
            color: #2da0a8;
        }

        .recent-bookings {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .recent-bookings table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .recent-bookings th, 
        .recent-bookings td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .recent-bookings th {
            background: #f8f9fa;
            color: #2c3e50;
        }

        .quick-actions {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }

        .action-btn {
            padding: 10px 20px;
            background: #2da0a8;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .action-btn:hover {
            background: #248f96;
        }
        .admin-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }
        .admin-table th, .admin-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .action-button {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        .edit-btn { background: #2da0a8; color: white;}
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <nav>
                <a href="admin.php" class="nav-item"><i class="fas fa-home"></i> Dashboard</a>
                <a href="admin_flights.php" class="nav-item"><i class="fas fa-plane"></i> Manage Flights</a>
                <a href="admin_users.php" class="nav-item"><i class="fas fa-users"></i> Manage Users</a>
                <a href="admin_bookings.php" class="nav-item"><i class="fas fa-ticket-alt"></i> Bookings</a>
                <a href="dashboard.php" class="nav-item"><i class="fas fa-globe"></i> Main Site</a>
                <a href="logout.php" class="nav-item"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </div>
        <div class="content">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['first_name']); ?></h1>
            
            <div class="quick-actions">
                <button class="action-btn" onclick="location.href='admin_flights.php'">
                    <i class="fas fa-plus"></i> Add New Flight
                </button>
                <button class="action-btn" onclick="location.href='admin_users.php'">
                    <i class="fas fa-user-plus"></i> Manage Users
                </button>
            </div>

            <div class="stats-container">
                <div class="stat-card">
                    <h3><i class="fas fa-users"></i> Total Users</h3>
                    <div class="number"><?php echo number_format($total_users); ?></div>
                </div>
                
                <div class="stat-card">
                    <h3><i class="fas fa-ticket-alt"></i> Total Bookings</h3>
                    <div class="number"><?php echo number_format($total_bookings); ?></div>
                </div>
                
                <div class="stat-card">
                    <h3><i class="fas fa-money-bill-wave"></i> Base Revenue</h3>
                    <div class="number">৳<?php echo number_format($base_revenue); ?></div>
                </div>

                <div class="stat-card">
                    <h3><i class="fas fa-shield-alt"></i> Insurance Revenue</h3>
                    <div class="number">৳<?php echo number_format($insurance_revenue); ?></div>
                </div>

                <div class="stat-card">
                    <h3><i class="fas fa-money-bill-wave"></i> Total Revenue</h3>
                    <div class="number">৳<?php echo number_format($total_revenue); ?></div>
                </div>
            </div>

            <div class="recent-bookings">
                <h2>Recent Bookings</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Flight ID</th>
                            <th>Passenger</th>
                            <th>Route</th>
                            <th>Base Fare</th>
                            <th>Insurance</th>
                            <th>Total</th>
                            <th>Seat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($booking = $recent_bookings->fetch_assoc()): ?>
                        <tr>
                            <td>#<?php echo $booking['id']; ?></td>
                            <td><?php echo htmlspecialchars($booking['Flight_ID']); ?></td>
                            <td><?php echo htmlspecialchars($booking['first_name'] . ' ' . $booking['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($booking['Flight_from'] . ' → ' . $booking['Flight_to']); ?></td>
                            <td>৳<?php echo number_format($booking['amount']); ?></td>
                            <td>৳<?php echo number_format($booking['insurance_amount']); ?></td>
                            <td>৳<?php echo number_format($booking['total_amount']); ?></td>
                            <td><?php echo htmlspecialchars($booking['seat_number']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>