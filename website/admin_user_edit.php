<?php
session_start();
require_once 'config.php';
require_once 'admin_check.php';
checkAdmin();

$success_msg = '';
$error_msg = '';
$user = null;

if (isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    
    if (!$user) {
        $_SESSION['error_msg'] = "User not found";
        header("Location: admin_users.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $user_id = $_POST['user_id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $user_type = $_POST['user_type'];
        
        if ($user_id == $_SESSION['user_id']) {
            $user_type = $user['user_type'];
        }
        
        $stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, email=?, phone=?, user_type=? WHERE user_id=?");
        $stmt->bind_param("sssssi", $first_name, $last_name, $email, $phone, $user_type, $user_id);
        
        if ($stmt->execute()) {
            $_SESSION['success_msg'] = "User updated successfully!";
            header("Location: admin_users.php");
            exit();
        } else {
            throw new Exception("Failed to update user");
        }
    } catch (Exception $e) {
        $error_msg = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User - Admin Panel</title>
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

        .user-form {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 600px;
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

        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #eee;
            border-radius: 25px;
            transition: all 0.3s ease;
            font-family: 'Murecho', sans-serif;
            background: white;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
        }

        .form-group select:focus {
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

        .form-help {
            color: #666;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="user-form">
        <div class="form-header">
            <a href="admin_users.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Users
            </a>
            <h2>Edit User Details</h2>
        </div>

        <?php if ($user): ?>
            <form method="POST">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">
                
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Phone</label>
                    <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label>User Type</label>
                    <select name="user_type" <?php echo ($user['user_id'] == $_SESSION['user_id']) ? 'disabled' : ''; ?>>
                        <option value="Customer" <?php echo $user['user_type'] === 'Customer' ? 'selected' : ''; ?>>Customer</option>
                        <option value="Admin" <?php echo $user['user_type'] === 'Admin' ? 'selected' : ''; ?>>Admin</option>
                    </select>
                    <?php if($user['user_id'] == $_SESSION['user_id']): ?>
                        <div class="form-help">Cannot change your own user type</div>
                    <?php endif; ?>
                </div>
                
                <button type="submit" class="submit-btn">Update User</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>