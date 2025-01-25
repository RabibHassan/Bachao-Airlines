<?php
require_once 'config.php';

$query = "SELECT * FROM feedback ORDER BY created_at DESC LIMIT 5";
$feedbacks = $conn->query($query);

if (!$feedbacks) {
    die("Error fetching feedback: " . $conn->error);
}

function displayStars($rating) {
    $stars = '';
    for($i = 1; $i <= 5; $i++) {
        $stars .= ($i <= $rating) ? '★' : '☆';
    }
    return $stars;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Support - BachaoAirlines</title>
    <link rel="stylesheet" href="feedbackstyles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('airplane-background.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #53343bee;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        .section {
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(131, 23, 117, 0.2);
            margin: 10px;
            box-sizing: border-box;
            background: rgba(255, 255, 255, 0.9);
            border-left: 3px solid #2da0a8;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        h2 {
            color: #e6000f;
            text-align: center;
        }

        #call-section {
            width: 250px;
            position: absolute;
            top: 20px;
            left: 20px;
            background: #f0f8ff;
            color: #00008b;
            font-family: 'Arial', sans-serif;
        }

        #faq-suggestion-section {
            width: 250px;
            position: absolute;
            top: 220px;
            left: 20px;
            background: #ffe4e1;
            color: #8b0000;
            font-family: 'Arial', sans-serif;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(131, 23, 117, 0.2);
        }

        #faq-suggestion-section h3 {
            margin-top: 0;
        }

        #faq-suggestion-section textarea {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #8b0000;
            margin-bottom: 10px;
        }

        .submit-btn-suggestion {
            width: 100%;
            padding: 8px;
            background-color: #8b0000;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .submit-btn-suggestion:hover {
            background-color: #7a0000;
        }

        #chatIcon {
            position: absolute;
            top: 80px;
            left: 20px;
            cursor: pointer;
        }

        #feedback-section {
            width: 450px;
            font-size: 0.9em;
            position: absolute;
            top: 20px;
            right: 10px;
            max-height: 85vh;
            overflow-y: auto;
        }

        #faq-section {
            width: 45%;
            position: absolute;
            top: 70%;
            left: 43%;
            transform: translate(-50%, -50%);
            max-height: 85vh;
            overflow-y: auto;
            background: rgba(255, 255, 255, 0.9);
            color: #53343bee;
            z-index: 1;
            background: rgba(255, 255, 255, 0.9);
            color: #2c3e50;
            border-left: 3px solid #FF8C00;
        }

        .faq-item h4 {
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        .faq-item p {
            font-size: 1em;
            margin-bottom: 20px;
        }

        .feedback-message {
            font-size: 1em;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 10px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .submit-btn {
            width: 100%;
            padding: 8px;
            background-color: #e6000f;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #d4000d;
        }

        .feedback-item {
            border-top: 1px solid #ddd;
            padding-top: 10px;
            margin-top: 10px;
        }

        .feedback-list {
            max-height: 250px;
            overflow-y: auto;
        }

        .load-more {
            display: none;
            width: 100%;
            padding: 10px;
            text-align: center;
            background-color: #e6000f;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        .load-more:hover {
            background-color: #d4000d;
        }

        #customer-support-section {
            width: 300px;
            position: absolute;
            top: 20px;
            left: 33%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #customer-support-icon {
            width: 100px;
            height: auto;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #d5d5e4;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #0056b3;
        }

        header p {
            margin-bottom: 20px;
            font-size: 16px;
            color: #555;
        }

        .feedback-form {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        textarea {
            resize: none;
        }

        button.submit-btn {
            padding: 10px 15px;
            background-color: #56b337;
            color: #fff;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button.submit-btn:hover {
            background-color: #003d7a;
        }

        .bgpic{
            width: 1920px;
            height: 1080px;
            position: absolute;
            z-index: -1;

        }

        #faq-section {
            width: 45%;
            position: absolute;
            top: 70%;
            left: 43%;
            transform: translate(-50%, -50%);
            max-height: 85vh;
            overflow-y: auto;
            background: rgba(255, 255, 255, 0.9);
            color: #53343bee;
            z-index: 1;
            background: rgba(255, 255, 255, 0.9);
            color: #2c3e50;
            border-left: 3px solid #FF8C00;
        }

        .faq-item {
            margin-bottom: 20px;
            padding: 15px;
            border-bottom: 1px solid #ddd;
            border-left: 3px solid #2da0a8;
            background: rgba(255, 255, 255, 0.7);
        }

        .faq-item h4 {
            font-size: 1.2em;
            margin-bottom: 10px;
            color: #e6000f;
        }

        .faq-item p {
            font-size: 1em;
            line-height: 1.5;
        }

        .stars {
            color: #e6000f;
            font-size: 20px;
            letter-spacing: 2px;
        }

        .back-btn {
            position: fixed;
            top: 20px;
            left: 20px;
            background: rgba(83, 52, 59, 0.9);
            color: white;
            padding: 12px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .back-btn:hover {
            transform: translateX(-5px);
            background: #53343b;
        }

        button.submit-btn {
            padding: 12px 25px;
            background-color: #2da0a8;
            color: white;
            font-size: 14px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button.submit-btn:hover {
            background-color: #268f96;
            transform: translateY(-2px);
        }

        textarea, input {
            border: 2px solid #e0e0e0;
            transition: border-color 0.3s ease;
        }

        textarea:focus, input:focus {
            border-color: #2da0a8;
            outline: none;
        }

        .section, #faq-section, #feedback-section {
            scrollbar-width: thin;
            scrollbar-color: #2da0a8 #f0f0f0;
        }

        .section::-webkit-scrollbar,
        #faq-section::-webkit-scrollbar,
        #feedback-section::-webkit-scrollbar {
            width: 8px;
        }

        .section::-webkit-scrollbar-track,
        #faq-section::-webkit-scrollbar-track,
        #feedback-section::-webkit-scrollbar-track {
            background: #f0f0f0;
            border-radius: 4px;
        }

        .section::-webkit-scrollbar-thumb,
        #faq-section::-webkit-scrollbar-thumb,
        #feedback-section::-webkit-scrollbar-thumb {
            background: #2da0a8;
            border-radius: 4px;
            transition: background 0.3s ease;
        }

        .section::-webkit-scrollbar-thumb:hover,
        #faq-section::-webkit-scrollbar-thumb:hover,
        #feedback-section::-webkit-scrollbar-thumb:hover {
            background: #268f96;
        }
    </style>
</head>
<body>

    <a href="dashboard.php" class="back-btn">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>

    <img class="bgpic" src="pics/Blue and White Illustrated Sky and Airplane Desktop Wallpaper.png" alt="Airplane Background">
   
    <div class="section" id="customer-support-section">
        <img id="customer-support-icon" src="pics/help-desk.png" alt="Customer Support Icon">
        <h2>Customer Support</h2>
    </div>

    <div class="section" id="call-section">
        <h2>Contact Us</h2>
        <div class="call-info">
            <p>For immediate assistance, call us:</p>
            <a href="tel:01855123216" class="call-btn">📞 01855123216</a>
        </div>
    </div>

    <div class="section" id="faq-suggestion-section">
        <h3>Suggest a Question for FAQ</h3>
        <textarea id="faq-suggestion" rows="4" placeholder="Your question..."></textarea>
        <button type="submit" class="submit-btn-suggestion">Submit</button>
    </div>

    <div id="chatIcon">💬</div>

    <div class="section" id="feedback-section">
        <h2>Feedback</h2>
        <p class="feedback-message">Leave a feedback so that we can improve our service</p>
        <form class="feedback-form" id="feedbackForm" method="POST" action="process_feedback.php">
            <div class="form-group">
                <label for="name">Name: *</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="contact">Contact Number: *</label>
                <input type="tel" id="contact" name="contact" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="country">Country:</label>
                <input type="text" id="country" name="country">
            </div>
            <div class="form-group">
                <label for="flightNumber">Flight Number:</label>
                <input type="text" id="flightNumber" name="flightNumber" placeholder="Helps to evaluate feedback">
            </div>
            <div class="form-group">
                <label for="rating">Rating:</label>
                <select id="rating" name="rating" required>
                    <option value="" disabled selected>Select a rating</option>
                    <option value="1">1 - Very Poor</option>
                    <option value="2">2 - Poor</option>
                    <option value="3">3 - Average</option>
                    <option value="4">4 - Good</option>
                    <option value="5">5 - Excellent</option>
                </select>
            </div>
            <div class="form-group">
                <label for="comments">Comments:</label>
                <textarea id="comments" name="comments" rows="5" placeholder="Write your comments here"></textarea>
            </div>
            <button type="submit" class="submit-btn">Submit Feedback</button>
        </form>
        <div class="feedback-list" id="feedbackList">
            <?php while($feedback = $feedbacks->fetch_assoc()): ?>
                <div class="feedback-item">
                    <h4><?php echo htmlspecialchars($feedback['name']); ?></h4>
                    <div class="stars">
                        <?php echo displayStars($feedback['rating']); ?>
                    </div>
                    <p><?php echo htmlspecialchars($feedback['comments']); ?></p>
                    <small>Posted on: <?php echo date('F j, Y', strtotime($feedback['created_at'])); ?></small>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="load-more" id="loadMore">Load More</div>
    </div>

    <div class="section" id="faq-section">
        <h2>FAQ</h2>
        <div class="faq-item">
            <h4>What is the process for changing a reservation?</h4>
            <p>To change a reservation, please visit our Manage Reservations page or call customer service.</p>
        </div>
        <div class="faq-item">
            <h4>Can I cancel my ticket and get a refund?</h4>
            <p>Yes, cancellations are allowed under certain conditions. Refunds depend on the ticket type.</p>
        </div>
        <div class="faq-item">
            <h4>What should I do if I miss my flight?</h4>
            <p>If you miss your flight, please contact customer service immediately for assistance with rebooking.</p>
        </div>
        <div class="faq-item">
            <h4>How can I check the status of my flight?</h4>
            <p>You can check the status of your flight on our website or by calling customer service.</p>
        </div>
        <div class="faq-item">
            <h4>What are the baggage allowances for my flight?</h4>
            <p>Please check our website or contact customer service for detailed baggage allowance information.</p>
        </div>
        <div class="faq-item">
            <h4>How early should I arrive at the airport?</h4>
            <p>We recommend arriving at least 2 hours before domestic flights and 3 hours before international flights.</p>
        </div>
    </div>
</body>
</html>