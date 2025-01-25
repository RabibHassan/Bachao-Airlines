<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'config.php';

$user_query = $conn->prepare("SELECT reward_point FROM users WHERE user_id = ?");
$user_query->bind_param("i", $_SESSION['user_id']);
$user_query->execute();
$user_data = $user_query->get_result()->fetch_assoc();
$reward_points = $user_data['reward_point'];
$has_discount = $reward_points >= 500;
$discount_percentage = $has_discount ? 0.05 : 0;

if (isset($_GET['flight_id'])) {
    $flight_id = $_GET['flight_id'];
    $stmt = $conn->prepare("SELECT * FROM `flight-1` WHERE Flight_ID = ?");
    $stmt->bind_param("s", $flight_id);
    $stmt->execute();
    $flight = $stmt->get_result()->fetch_assoc();
    
    if (!$flight) {
        die("Flight not found");
    }
}

$booked_query = $conn->prepare("SELECT seat_number FROM transactions WHERE flight_id = ?");
$booked_query->bind_param("s", $flight_id);
$booked_query->execute();
$result = $booked_query->get_result();
$booked_seats = array_column($result->fetch_all(MYSQLI_ASSOC), 'seat_number');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Flight - Bachao Airlines</title>
    <link href="https://fonts.googleapis.com/css2?family=Murecho:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: 'Murecho', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }

        .flight-card {
            background: #fff;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }

        .flight-card:hover {
            transform: translateY(-5px);
        }

        .flight-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
            margin-right: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #2da0a8;
            outline: none;
        }

        .payment-section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 15px;
            margin-top: 30px;
        }

        .submit-btn {
            background: #2da0a8;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 18px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            background: #248f96;
            transform: translateY(-2px);
        }

        .price-tag {
            font-size: 24px;
            color: #2da0a8;
            font-weight: 700;
        }

        .flight-info {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .flight-route {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .flight-route i {
            color: #2da0a8;
        }

        .airplane-layout {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
        }

        .plane {
            margin: 20px auto;
        }

        .fuselage {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .seats {
            display: flex;
            flex-wrap: nowrap;
            justify-content: space-between;
            padding: 0;
            margin: 0;
        }

        .seat {
            display: flex;
            position: relative;
            margin: 5px;
        }

        .seat input[type="radio"] {
            display: none;
        }

        .seat label {
            display: block;
            width: 30px;
            height: 30px;
            border: 2px solid #20b2aa;
            background: #ffffff;
            border-radius: 4px;
            text-align: center;
            line-height: 30px;
            cursor: pointer;
        }

        .seat input[type="radio"]:checked + label {
            background: #20b2aa;
            color: white;
        }

        .seat input[type="radio"]:disabled + label {
            background: #ff6b6b;
            cursor: not-allowed;
        }

        .exit {
            height: 10px;
            background: #ff6b6b;
            margin: 10px 0;
        }
        
        .seat-map {
            margin: 20px 0;
        }

        .airplane {
            display: grid;
            gap: 10px;
            justify-content: center;
        }

        .seat-row {
            display: flex;
            gap: 10px;
        }

        .seat input[type="radio"] {
            display: none;
        }

        .seat label {
            display: block;
            width: 35px;
            height: 35px;
            border: 2px solid #2da0a8;
            border-radius: 5px;
            text-align: center;
            line-height: 35px;
            cursor: pointer;
            background: #fff;
        }

        .seat input[type="radio"]:checked + label {
            background: #2da0a8;
            color: white;
        }

        .seat.booked label {
            background: #ff6b6b;
            border-color: #ff6b6b;
            cursor: not-allowed;
        }

        .back-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            background: rgba(45, 160, 168, 0.9);
            color: white;
            padding: 12px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .back-btn:hover {
            transform: translateX(-5px);
            background: #2da0a8;
        }

        .insurance-section, .total-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .insurance-benefits {
            margin-top: 15px;
            padding: 15px;
            background: rgba(45, 160, 168, 0.1);
            border-radius: 8px;
        }

        .insurance-benefits ul {
            list-style: none;
            padding: 0;
        }

        .insurance-benefits li {
            margin: 8px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .insurance-benefits i {
            color: #2da0a8;
        }

        .price-details {
            font-size: 1.1em;
        }

        .price-details .total {
            font-size: 1.2em;
            font-weight: bold;
            color: #2da0a8;
            border-top: 1px solid #eee;
            padding-top: 10px;
            margin-top: 10px;
        }
        
        .price-breakdown {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 15px;
        }

        .price-breakdown p {
            margin: 8px 0;
            display: flex;
            justify-content: space-between;
        }

        .price-breakdown hr {
            border: none;
            border-top: 1px solid #ddd;
            margin: 15px 0;
        }

        .price-breakdown .total {
            font-size: 1.2em;
            color: #2da0a8;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <a href="dashboard.php" class="back-btn">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
    <div class="container">
        <div class="flight-card">
            <div class="flight-header">
                <div class="flight-info">
                    <div class="flight-route">
                        <h3><?php echo htmlspecialchars($flight['Flight_from']); ?></h3>
                        <i class="fas fa-plane"></i>
                        <h3><?php echo htmlspecialchars($flight['Flight_to']); ?></h3>
                    </div>
                    <div class="flight-time">
                        <p><i class="far fa-clock"></i> <?php echo htmlspecialchars($flight['Start_time']); ?></p>
                        <p><i class="far fa-calendar"></i> <?php echo htmlspecialchars($flight['Start_date']); ?></p>
                    </div>
                </div>
                <div class="price-tag">
                    $<?php echo htmlspecialchars($flight['Price']); ?>
                </div>
            </div>
        </div>

        <form action="process_booking.php" method="POST">
            <input type="hidden" name="flight_id" value="<?php echo htmlspecialchars($flight_id); ?>">
            <input type="hidden" name="selected_seat" id="selected_seat">
            <input type="hidden" name="base_fare" value="<?php echo $flight['Price']; ?>">
            
            <div class="form-grid">
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Full Name</label>
                    <input type="text" name="passenger_name" required>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-phone"></i> Phone</label>
                    <input type="tel" name="phone" required>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-passport"></i> Passport Number</label>
                    <input type="text" name="passport" required>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-chair"></i> Seat Preference</label>
                    <select name="seat_type" required>
                        <option value="">Select Seat Type</option>
                        <option value="window">Window</option>
                        <option value="aisle">Aisle</option>
                        <option value="middle">Middle</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label><i class="fas fa-chair"></i> Select Seat</label>
                <div class="seat-map">
                    <div class="airplane">
                        <?php for($row = 1; $row <= 10; $row++): ?>
                            <div class="seat-row">
                                <?php foreach(['A', 'B', 'C', 'D', 'E', 'F'] as $col): 
                                    $seat_number = $row . $col;
                                    $is_booked = in_array($seat_number, $booked_seats);
                                ?>
                                    <div class="seat <?php echo $is_booked ? 'booked' : ''; ?>">
                                        <input type="radio" 
                                               name="seat_number" 
                                               id="<?php echo $seat_number; ?>"
                                               value="<?php echo $seat_number; ?>" 
                                               <?php echo $is_booked ? 'disabled' : ''; ?>
                                               required>
                                        <label for="<?php echo $seat_number; ?>"><?php echo $seat_number; ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>

            <div class="insurance-section">
                <h3><i class="fas fa-shield-alt"></i> Travel Insurance</h3>
                <input type="hidden" name="base_fare" value="<?php echo $flight['Price']; ?>">
                <div class="form-group">
                    <label>Select Insurance Plan</label>
                    <select name="insurance_plan" id="insurancePlan" onchange="calculateTotal()">
                        <option value="none">No Insurance (৳0)</option>
                        <option value="basic">Basic Coverage (৳500)</option>
                        <option value="premium">Premium Coverage (৳1,000)</option>
                        <option value="elite">Elite Coverage (৳2,000)</option>
                    </select>
                </div>
                <input type="hidden" name="insurance_cost" id="insuranceCostHidden" value="0">
                <div id="insuranceDetails"></div>
            </div>

            <div class="total-section">
                <h3>Price Summary</h3>
                <div class="price-breakdown">
                    <p>Original Fare: ৳<span id="originalFare"><?php echo $flight['Price']; ?></span></p>
                    
                    <?php if ($has_discount): ?>
                        <p>Reward Discount (5%): -৳<span id="discountAmount">
                            <?php echo number_format($flight['Price'] * 0.05, 2); ?>
                        </span></p>
                        <p>Discounted Fare: ৳<span id="discountedFare">
                            <?php echo number_format($flight['Price'] * 0.95, 2); ?>
                        </span></p>
                    <?php endif; ?>
                    
                    <p>Insurance: ৳<span id="insuranceCost">0</span></p>
                    <hr>
                    <p class="total">Total Amount: ৳<span id="totalAmount">
                        <?php echo number_format($has_discount ? $flight['Price'] * 0.95 : $flight['Price'], 2); ?>
                    </span></p>
                </div>
            </div>

            <div class="payment-section">
                <h3><i class="fas fa-credit-card"></i> Payment Details</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Payment Method</label>
                        <select name="payment_method" required>
                            <option value="">Select Payment Method</option>
                            <option value="credit">Credit Card</option>
                            <option value="debit">Debit Card</option>
                            <option value="bkash">bKash</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Card/Account Number</label>
                        <input type="text" name="payment_number" required>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="submit-btn">
                <i class="fas fa-check-circle"></i> Confirm Booking
            </button>
        </form>
    </div>
    <script>
        document.querySelectorAll('.seat input[type="radio"]').forEach(input => {
            input.addEventListener('change', function() {
                document.getElementById('selected_seat').value = this.value;

                const seatLetter = this.value.slice(-1);
                let seatType = 'middle';
                if (seatLetter === 'A' || seatLetter === 'F') seatType = 'window';
                if (seatLetter === 'C' || seatLetter === 'D') seatType = 'aisle';
                
                document.querySelector('select[name="seat_type"]').value = seatType;
            });
        });
        
        document.querySelectorAll('.seat input[type="radio"]').forEach(input => {
            input.addEventListener('change', function() {
                const seatLetter = this.value.slice(-1);
                let seatType;

                if (seatLetter === 'A' || seatLetter === 'F') {
                    seatType = 'window';
                } else if (seatLetter === 'C' || seatLetter === 'D') {
                    seatType = 'aisle';
                } else {
                    seatType = 'middle';
                }

                document.querySelector('select[name="seat_type"]').value = seatType;
            });
        });

        const insurancePlans = {
            'none': { cost: 0, benefits: [] },
            'basic': {
                cost: 500,
                benefits: ['Medical emergencies up to ৳50,000', 'Lost baggage compensation', 'Flight delay coverage']
            },
            'premium': {
                cost: 1000,
                benefits: ['Medical emergencies up to ৳100,000', 'Lost baggage compensation', 'Flight delay coverage', 'Trip cancellation']
            },
            'elite': {
                cost: 2000,
                benefits: ['Medical emergencies up to ৳200,000', 'Lost baggage compensation', 'Flight delay coverage', 'Trip cancellation', 'Adventure sports']
            }
        };

        const hasDiscount = <?php echo $has_discount ? 'true' : 'false' ?>;
        const discountPercentage = <?php echo $discount_percentage ?>;

        function calculateTotal() {
            const originalFare = parseFloat(<?php echo $flight['Price']; ?>);
            const hasDiscount = <?php echo $has_discount ? 'true' : 'false' ?>;
            const selectedPlan = document.getElementById('insurancePlan').value;
            const insuranceCost = insurancePlans[selectedPlan].cost;

            let baseFare = originalFare;
            let discountAmount = 0;
            
            if (hasDiscount) {
                discountAmount = originalFare * 0.05;
                baseFare = originalFare - discountAmount;
            }

            const total = baseFare + insuranceCost;

            document.getElementById('originalFare').textContent = originalFare.toFixed(2);
            if (hasDiscount) {
                document.getElementById('discountAmount').textContent = discountAmount.toFixed(2);
                document.getElementById('discountedFare').textContent = baseFare.toFixed(2);
            }
            document.getElementById('insuranceCost').textContent = insuranceCost.toFixed(2);
            document.getElementById('totalAmount').textContent = total.toFixed(2);

            document.getElementById('insuranceCostHidden').value = insuranceCost;
            document.getElementById('discountedFareHidden').value = baseFare;
        }

        document.addEventListener('DOMContentLoaded', calculateTotal);
    </script>
</body>
</html>

<?php
