<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $name = $_POST['name'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];
        $country = $_POST['country'];
        $flight_number = $_POST['flight_number'];
        $rating = $_POST['rating'];
        $comments = $_POST['comments'];

        $stmt = $conn->prepare("INSERT INTO feedback (name, contact, email, country, flight_number, rating, comments) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $name, $contact, $email, $country, $flight_number, $rating, $comments);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Feedback submitted successfully!";
        } else {
            throw new Exception($stmt->error);
        }

    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }

    header("Location: feedback.php");
    exit();
}

function getRecentFeedback($conn) {
    $query = "SELECT * FROM feedback ORDER BY created_at DESC LIMIT 5";
    $result = $conn->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>