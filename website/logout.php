<?php
require_once 'config.php';
session_start();

$_SESSION = array();

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Logging Out - Bachao Airlines</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .logout-container {
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            animation: fadeIn 0.5s ease;
        }
        .logout-icon {
            font-size: 50px;
            color: #2da0a8;
            margin-bottom: 20px;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    <script>
        setTimeout(() => {
            window.location.href = 'dashboard.php';
        }, 3000);
    </script>
</head>
<body>
    <div class="logout-container">
        <i class="fas fa-check-circle logout-icon"></i>
        <h2>Successfully Logged Out</h2>
        <p>Redirecting to dashboard in a few seconds...</p>
    </div>
</body>
</html>