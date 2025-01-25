<?php
session_start();
require_once 'config.php';
require_once 'admin_check.php';
checkAdmin();

$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_flight'])) {
        try {
            $flight_id = $_POST['flight_id'];
            $from = $_POST['from'];
            $to = $_POST['to'];
            $start_date = $_POST['start_date'];
            $land_date = $_POST['land_date'];
            $start_time = $_POST['start_time'];
            $end_time = $_POST['end_time'];
            $duration = $_POST['duration'];
            $type = 'Non-stop';
            $price = $_POST['price'];
            
            $check = $conn->prepare("SELECT Flight_ID FROM `flight-1` WHERE Flight_ID = ?");
            $check->bind_param("s", $flight_id);
            $check->execute();
            if ($check->get_result()->num_rows > 0) {
                throw new Exception("Flight ID already exists");
            }
            
            $stmt = $conn->prepare("INSERT INTO `flight-1` (Flight_ID, Flight_from, Flight_to, Start_date, Land_date, Start_time, End_time, Duration, Type, Price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssssi", $flight_id, $from, $to, $start_date, $land_date, $start_time, $end_time, $duration, $type, $price);
            
            if ($stmt->execute()) {
                $success_msg = "Flight added successfully!";
            } else {
                throw new Exception("Failed to add flight");
            }
        } catch (Exception $e) {
            $error_msg = $e->getMessage();
        }
    }
}

$flights = $conn->query("SELECT * FROM `flight-1` ORDER BY Flight_ID DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Flights - Admin Panel</title>
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

        .flight-form {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            animation: slideDown 0.5s ease;
        }

        .form-group {
            margin-bottom: 15px;
            margin-right: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: rgb(48, 47, 47);
            font-weight: 700;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 10px 15px;
            border: 2px solid #eee;
            border-radius: 25px;
            transition: all 0.3s ease;
            font-family: 'Murecho', sans-serif;
        }

        .form-group input:focus {
            border-color: #2da0a8;
            box-shadow: 0 0 0 3px rgba(45,160,168,0.1);
            outline: none;
        }

        .submit-btn {
            background: #2da0a8;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 700;
            font-family: 'Murecho', sans-serif;
            transition: all 0.3s ease;
            width: auto;
            margin: 20px auto;
            display: block;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        .admin-table {
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .admin-table th {
            background: #2da0a8;
            color: white;
            font-weight: 700;
            padding: 15px;
            font-size: 14px;
        }

        .admin-table tr {
            transition: all 0.3s ease;
        }

        .admin-table tr:hover {
            background: rgba(45,160,168,0.05);
        }

        .admin-table td {
            padding: 15px;
            color: rgb(48, 47, 47);
            font-weight: 500;
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

        .edit-btn {
            background: #2da0a8;
        }

        .delete-btn {
            background: #e74c3c;
        }

        .action-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .loading::after {
            content: '';
            width: 40px;
            height: 40px;
            border: 4px solid #eee;
            border-top: 4px solid #2da0a8;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .admin-nav {
            background: white;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-links {
            display: flex;
            gap: 20px;
        }

        .nav-btn {
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            color: rgb(48, 47, 47);
            font-weight: 700;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-btn:hover {
            background: rgba(45,160,168,0.1);
            transform: translateY(-2px);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            padding: 20px;
        }

        .message {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            animation: slideDown 0.5s ease;
        }

        .success { 
            background: #d4edda;
            color: #155724;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
        }

        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body>
    <div class="admin-nav">
        <div class="container nav-links">
            <a href="admin.php" class="nav-btn">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            <h2>Manage Flights</h2>
        </div>
    </div>

    <div class="container">
        <?php if ($success_msg): ?>
            <div class="message success">
                <i class="fas fa-check-circle"></i> <?php echo $success_msg; ?>
            </div>
        <?php endif; ?>

        <?php if ($error_msg): ?>
            <div class="message error">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error_msg; ?>
            </div>
        <?php endif; ?>

        <div class="card flight-form">
            <h2>Add New Flight</h2>
            <form method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Flight ID</label>
                        <input type="text" name="flight_id" required>
                    </div>
                    <div class="form-group">
                        <label>From</label>
                        <input type="text" name="from" required>
                    </div>
                    <div class="form-group">
                        <label>To</label>
                        <input type="text" name="to" required>
                    </div>
                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label>Landing Date</label>
                        <input type="date" name="land_date" required>
                    </div>
                    <div class="form-group">
                        <label>Start Time</label>
                        <input type="time" name="start_time" required>
                    </div>
                    <div class="form-group">
                        <label>End Time</label>
                        <input type="time" name="end_time" required>
                    </div>
                    <div class="form-group">
                        <label>Duration</label>
                        <input type="text" name="duration" required>
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" name="price" required>
                    </div>
                    <button type="submit" name="add_flight" class="submit-btn">Add Flight</button>
                </div>
            </form>
        </div>

        <div class="card admin-table">
            <h2>All Flights</h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Flight ID</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Start Date</th>
                        <th>Land Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Duration</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="flightTableBody">
                    <?php while($flight = $flights->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($flight['Flight_ID']); ?></td>
                            <td><?php echo htmlspecialchars($flight['Flight_from']); ?></td>
                            <td><?php echo htmlspecialchars($flight['Flight_to']); ?></td>
                            <td><?php echo htmlspecialchars($flight['Start_date']); ?></td>
                            <td><?php echo htmlspecialchars($flight['Land_date']); ?></td>
                            <td><?php echo htmlspecialchars($flight['Start_time']); ?></td>
                            <td><?php echo htmlspecialchars($flight['End_time']); ?></td>
                            <td><?php echo htmlspecialchars($flight['Duration']); ?></td>
                            <td><?php echo htmlspecialchars($flight['Type']); ?></td>
                            <td>৳<?php echo number_format($flight['Price']); ?></td>
                            <td>
                                <a href="edit_flight.php?id=<?php echo urlencode($flight['Flight_ID']); ?>" 
                                   class="action-btn edit-btn">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="delete_flight.php?id=<?php echo urlencode($flight['Flight_ID']); ?>" 
                                   class="action-btn delete-btn"
                                   onclick="return confirm('Are you sure you want to delete this flight?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const loader = document.createElement('div');
        loader.className = 'loading';
        document.body.appendChild(loader);

        window.addEventListener('load', function() {
            loader.remove();
        });

        const observerOptions = {
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = 1;
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.admin-table tr').forEach(row => {
            observer.observe(row);
        });
    });
    
    function searchFlights(query) {
        window.location.href = '?search=' + encodeURIComponent(query);
    }
    </script>
</body>
</html>