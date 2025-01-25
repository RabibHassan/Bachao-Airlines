<?php
session_start();
require_once 'config.php';
require_once 'admin_check.php';
checkAdmin();

$success_msg = '';
$error_msg = '';
$flight = null;

if (isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM `flight-1` WHERE Flight_ID = ?");
    $stmt->bind_param("s", $_GET['id']);
    $stmt->execute();
    $flight = $stmt->get_result()->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $flight_id = $_POST['flight_id'];
        $from = $_POST['from'];
        $to = $_POST['to'];
        $start_date = $_POST['start_date'];
        $land_date = $_POST['land_date'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $duration = $_POST['duration'];
        $price = $_POST['price'];
        
        $stmt = $conn->prepare("UPDATE `flight-1` SET Flight_from=?, Flight_to=?, Start_date=?, Land_date=?, Start_time=?, End_time=?, Duration=?, Price=? WHERE Flight_ID=?");
        $stmt->bind_param("sssssssss", $from, $to, $start_date, $land_date, $start_time, $end_time, $duration, $price, $flight_id);
        
        if ($stmt->execute()) {
            $_SESSION['success_msg'] = "Flight updated successfully!";
            header("Location: admin_flights.php");
            exit();
        } else {
            throw new Exception("Failed to update flight");
        }
    } catch (Exception $e) {
        $error_msg = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Flight - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Murecho:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Murecho', sans-serif;
            margin: 0;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .flight-form {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 800px;
            animation: slideIn 0.5s ease;
        }

        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
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

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
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
            padding: 12px;
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
            padding: 12px 30px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 700;
            font-family: 'Murecho', sans-serif;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 20px;
        }

        .submit-btn:hover {
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
    <div class="flight-form">
        <div class="form-header">
            <a href="admin_flights.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Flights
            </a>
            <h2>Edit Flight Details</h2>
        </div>
        
        <?php if ($flight): ?>
            <form method="POST">
                <input type="hidden" name="flight_id" value="<?php echo htmlspecialchars($flight['Flight_ID']); ?>">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label>From</label>
                        <input type="text" name="from" value="<?php echo htmlspecialchars($flight['Flight_from']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>To</label>
                        <input type="text" name="to" value="<?php echo htmlspecialchars($flight['Flight_to']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" name="start_date" value="<?php echo htmlspecialchars($flight['Start_date']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Land Date</label>
                        <input type="date" name="land_date" value="<?php echo htmlspecialchars($flight['Land_date']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Start Time</label>
                        <input type="time" name="start_time" value="<?php echo htmlspecialchars($flight['Start_time']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>End Time</label>
                        <input type="time" name="end_time" value="<?php echo htmlspecialchars($flight['End_time']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Duration</label>
                        <input type="text" name="duration" value="<?php echo htmlspecialchars($flight['Duration']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" name="price" value="<?php echo htmlspecialchars($flight['Price']); ?>" required>
                    </div>
                </div>
                
                <button type="submit" class="submit-btn">Update Flight</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>