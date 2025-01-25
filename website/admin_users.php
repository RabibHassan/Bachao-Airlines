<?php
session_start();
require_once 'config.php';
require_once 'admin_check.php';
checkAdmin();

$success_msg = '';
$error_msg = '';

$users_query = "SELECT * FROM users ORDER BY user_type = 'Admin' DESC, user_id DESC";
$users = $conn->query($users_query);

if (isset($_GET['delete'])) {
    try {
        header("Location: admin_user_delete.php?id=" . $_GET['delete']);
        exit();
    } catch (Exception $e) {
        $error_msg = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users - Admin Panel</title>
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

        .users-table {
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            overflow: hidden;
            animation: slideDown 0.5s ease;
        }

        .users-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .users-table th {
            background: #2da0a8;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 700;
            font-size: 14px;
        }

        .users-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            color: rgb(48, 47, 47);
        }

        .users-table tr:hover {
            background: rgba(45,160,168,0.05);
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

        .edit-btn { background: #2da0a8; }
        .delete-btn { background: #e74c3c; }

        .action-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
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

        /* Add to existing styles */
        .user-type {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 700;
            display: inline-block;
        }

        .type-Admin {
            background: #2c3e50;
            color: white;
        }

        .type-Customer {
            background: #2da0a8;
            color: white;
        }

        .admin-row {
            background: rgba(44, 62, 80, 0.05);
        }

        /* Add to existing styles */
        .action-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }

        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip .tooltip-text {
            visibility: hidden;
            width: 120px;
            background-color: rgba(0,0,0,0.8);
            color: white;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 12px;
        }

        .tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
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
        <div class="users-table">
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($user = $users->fetch_assoc()): ?>
                        <tr class="<?php echo $user['user_type'] === 'Admin' ? 'admin-row' : ''; ?>">
                            <td>#<?php echo $user['user_id']; ?></td>
                            <td><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['phone']); ?></td>
                            <td>
                                <span class="user-type type-<?php echo $user['user_type']; ?>">
                                    <?php echo $user['user_type']; ?>
                                </span>
                            </td>
                            <td>
                                <?php 
                                $isAdmin = $user['user_type'] === 'Admin';
                                $isCurrentUser = $user['user_id'] == $_SESSION['user_id'];
                                $canDelete = !$isAdmin && !$isCurrentUser;
                                ?>
                                
                                <a href="admin_user_edit.php?id=<?php echo $user['user_id']; ?>" 
                                   class="action-btn edit-btn">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <?php if ($canDelete): ?>
                                    <a href="admin_user_delete.php?id=<?php echo $user['user_id']; ?>" 
                                       class="action-btn delete-btn"
                                       onclick="return confirm('Are you sure you want to delete this user?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="tooltip">
                                        <a class="action-btn delete-btn disabled">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <span class="tooltip-text">
                                            <?php echo $isAdmin ? "Cannot delete admin users" : "Cannot delete your own account"; ?>
                                        </span>
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>