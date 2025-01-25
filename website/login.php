<?php
session_start();
include("config.php");
require_once 'update_membership.php';

function sanitize($data, $conn) {
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($data)));
}

if (isset($_POST['login'])) {
    $email = sanitize($_POST['email'], $conn);
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_type'] = $user['user_type'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['logged_in'] = true;
            
            $add_points = $conn->prepare("UPDATE users SET reward_point = reward_point + 20 WHERE user_id = ?");
            $add_points->bind_param("i", $user['user_id']);
            $add_points->execute();

            updateMembershipLevel($_SESSION['user_id']);

            if ($user['user_type'] === 'Admin') {
                header("Location: admin.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
        }
    }
    $_SESSION['error'] = "Invalid credentials";
}

if (isset($_POST['register'])) {
    $first_name = sanitize($_POST['first_name'], $conn);
    $last_name = sanitize($_POST['last_name'], $conn);
    $email = sanitize($_POST['email'], $conn);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $date_of_birth = sanitize($_POST['date_of_birth'], $conn);
    $phone = sanitize($_POST['phone'], $conn);
    $gender = sanitize($_POST['gender'], $conn);
    
    $check_email = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    
    if ($check_email->get_result()->num_rows > 0) {
        echo '<div class="overlay" id="overlay"></div>
              <div id="custom-alert" class="custom-alert">
                  <div class="alert-content">
                      <span class="close-btn">&times;</span>
                      <i class="fas fa-exclamation-circle"></i>
                      <p>This email already exists.<br>Please try a different email address.</p>
                  </div>
              </div>
              <style>
                  .overlay {
                      display: none;
                      position: fixed;
                      top: 0;
                      left: 0;
                      width: 100%;
                      height: 100%;
                      background: rgba(0, 0, 0, 0.5);
                      backdrop-filter: blur(5px);
                      z-index: 999;
                  }
                  .custom-alert {
                      display: none;
                      position: fixed;
                      top: 50%;
                      left: 50%;
                      transform: translate(-50%, -50%) scale(0.7);
                      background: #fff;
                      padding: 25px;
                      border-radius: 12px;
                      box-shadow: 0 5px 20px rgba(0,0,0,0.2);
                      z-index: 1000;
                      min-width: 300px;
                      animation: popIn 0.3s ease-out forwards;
                  }
                  .alert-content {
                      display: flex;
                      align-items: center;
                      gap: 15px;
                  }
                  .close-btn {
                      position: absolute;
                      top: 10px;
                      right: 10px;
                      cursor: pointer;
                      font-size: 22px;
                      opacity: 0.7;
                      transition: opacity 0.2s;
                  }
                  .close-btn:hover {
                      opacity: 1;
                  }
                  .fa-exclamation-circle {
                      color: #ff4444;
                      font-size: 24px;
                  }
                  @keyframes popIn {
                      0% {
                          transform: translate(-50%, -50%) scale(0.7);
                          opacity: 0;
                      }
                      100% {
                          transform: translate(-50%, -50%) scale(1);
                          opacity: 1;
                      }
                  }
              </style>
              <script>
                  document.addEventListener("DOMContentLoaded", function() {
                      var alert = document.getElementById("custom-alert");
                      var overlay = document.getElementById("overlay");
                      
                      alert.style.display = "block";
                      overlay.style.display = "block";
                      
                      document.querySelector(".close-btn").onclick = function() {
                          alert.style.opacity = "0";
                          overlay.style.opacity = "0";
                          setTimeout(function() {
                              alert.style.display = "none";
                              overlay.style.display = "none";
                              window.location.href = "login.php";
                          }, 300);
                      };
                  });
              </script>';
        exit();
    } else {
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, date_of_birth, phone, gender) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $first_name, $last_name, $email, $password, $date_of_birth, $phone, $gender);
        
        if ($stmt->execute()) {
            echo '<div class="overlay" id="overlay"></div>
              <div id="success-alert" class="custom-alert">
                  <div class="alert-content">
                      <i class="fas fa-check-circle"></i>
                      <p>Welcome aboard! ✈️<br>Your journey with us begins now.</p>
                  </div>
              </div>
              <style>
                  .overlay {
                      position: fixed;
                      top: 0;
                      left: 0;
                      width: 100%;
                      height: 100%;
                      background: rgba(0, 0, 0, 0.5);
                      backdrop-filter: blur(5px);
                      z-index: 999;
                  }
                  .custom-alert {
                      position: fixed;
                      top: 50%;
                      left: 50%;
                      transform: translate(-50%, -50%) scale(0.7);
                      background: #fff;
                      padding: 25px;
                      border-radius: 12px;
                      box-shadow: 0 5px 20px rgba(0,0,0,0.2);
                      z-index: 1000;
                      min-width: 300px;
                      animation: popIn 0.3s ease-out forwards;
                  }
                  .fa-check-circle {
                      color: #00C851;
                      font-size: 24px;
                  }
                  .alert-content {
                      display: flex;
                      align-items: center;
                      gap: 15px;
                  }
                  @keyframes popIn {
                      0% { transform: translate(-50%, -50%) scale(0.7); opacity: 0; }
                      100% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
                  }
              </style>
              <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var alert = document.getElementById("success-alert");
                        var overlay = document.getElementById("overlay");
                        
                        alert.style.display = "block";
                        overlay.style.display = "block";
                        
                        setTimeout(function() {
                            alert.style.opacity = "0";
                            overlay.style.opacity = "0";
                            setTimeout(function() {
                                alert.style.display = "none";
                                overlay.style.display = "none";
                                window.location.href = "login.php";
                            }, 300);
                        }, 2000);
                    });
              </script>';
            exit();
        } else {
            $_SESSION['error'] = "Registration failed";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    />
    <link rel="stylesheet" href="login-style.css" />
    <title>Login Page - BachaoAirlines</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }

        body{
            background-color: #c9d6ff;
            background: linear-gradient(to right, #e2e2e2, #c9d6ff);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            height: 100vh;
        }

        .container{
            background-color: #fff;
            border-radius: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
            position: relative;
            overflow: hidden;
            width: 768px;
            max-width: 100%;
            min-height: 480px;
        }

        .container p{
            font-size: 14px;
            line-height: 20px;
            letter-spacing: 0.3px;
            margin: 20px 0;
        }

        .container span{
            font-size: 12px;
        }

        .container a{
            color: #333;
            font-size: 13px;
            text-decoration: none;
            margin: 15px 0 10px;
        }

        .container button{
            background-color: #2da0a8;
            color: #fff;
            font-size: 12px;
            padding: 10px 45px;
            border: 1px solid transparent;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-top: 10px;
            cursor: pointer;
        }

        .container button.hidden{
            background-color: transparent;
            border-color: #fff;
        }

        .container form{
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            height: 100%;
        }

        .container input{
            background-color: #eee;
            border: none;
            margin: 8px 0;
            padding: 10px 15px;
            font-size: 13px;
            border-radius: 8px;
            width: 100%;
            outline: none;
        }

        .form-container{
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
        }

        .sign-in{
            left: 0;
            width: 50%;
            z-index: 2;
        }

        .container.active .sign-in{
            transform: translateX(100%);
        }

        .sign-up{
            left: 0;
            width: 50%;
            opacity: 0;
            z-index: 1;
        }

        .container.active .sign-up{
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            animation: move 0.6s;
        }

        @keyframes move{
            0%, 49.99%{
                opacity: 0;
                z-index: 1;
            }
            50%, 100%{
                opacity: 1;
                z-index: 5;
            }
        }

        .social-icons{
            margin: 20px 0;
        }

        .social-icons a{
            border: 1px solid #ccc;
            border-radius: 20%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            margin: 0 3px;
            width: 40px;
            height: 40px;
        }

        .toggle-container{
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: all 0.6s ease-in-out;
            border-radius: 150px 0 0 100px;
            z-index: 1000;
        }

        .container.active .toggle-container{
            transform: translateX(-100%);
            border-radius: 0 150px 100px 0;
        }

        .toggle{
            background-color: #2da0a8;
            height: 100%;
            background: linear-gradient(to right, #5c6bc0, #2da0a8);
            color: #fff;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: all 0.6s ease-in-out;
        }

        .container.active .toggle{
            transform: translateX(50%);
        }

        .toggle-panel{
            position: absolute;
            width: 50%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 30px;
            text-align: center;
            top: 0;
            transform: translateX(0);
            transition: all 0.6s ease-in-out;
        }

        .toggle-left{
            transform: translateX(-200%);
        }

        .container.active .toggle-left{
            transform: translateX(0);
        }

        .toggle-right{
            right: 0;
            transform: translateX(0);
        }

        .container.active .toggle-right{
            transform: translateX(200%);
        }

        .background-clips {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        @media (min-aspect-ratio:16/9){
            .background-clips {
                width: 100%;
                height: auto;
            }
        }

        @media (max-aspect-ratio:16/9){
            .background-clips{
                width: auto;
                height: 100%;
            }

        }
        .name-container{
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .half-width1{
            margin-right: 12px;
        }

        .container select {
            background-color: #eee;
            border: none;
            margin: 8px 0;
            padding: 10px 15px;
            font-size: 13px;
            border-radius: 8px;
            width: 100%;
            outline: none;
            
        }

        .container select::after {
            content: '\25BC';
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .dob-gender-select {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .dob {
            margin-right: 12px;
        }

    </style>
  </head>

  <body>
    <div class="container" id="container">
      <div class="form-container sign-up">
        <form method="post" action="login.php">
          <h1>Create Account</h1>
          <div class="social-icons">
            <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
            <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
            <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
          </div>
          <span>or use your email for registeration</span>
          <div class="name-container">
            <div class="half-width1">
              <input type="text" name="first_name" placeholder="First Name" required/>
            </div>
            <div class="half-width2">
              <input type="text" name="last_name" placeholder="Last Name" required/>
            </div>
          </div>
          <input type="email" name="email" placeholder="Email" required/>
          <input type="password" name="password" placeholder="Password" required/>
          
          <div class="dob-gender-select">
            <div class="dob">
              <input type="date" name="date_of_birth" placeholder="Date Of Birth" required/>
            </div>
            <select id="gender" name="gender" required>
              <option value="" disabled selected>Gender</option>
              <option value="1">Male</option>
              <option value="2">Female</option>
            </select>
          </div>
          <input type="tel" id="phone" name="phone" placeholder="Phone Number" required>
          <button type="submit" name="register">Sign Up</button>
        </form>
      </div>
      <div class="form-container sign-in">
        <form method="post" action="login.php">
          <h1>Sign In</h1>
          <div class="social-icons">
            <a href="#" class="icon"
              ><i class="fa-brands fa-google-plus-g"></i
            ></a>
            <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
            <a href="#" class="icon"
              ><i class="fa-brands fa-linkedin-in"></i
            ></a>
          </div>
          <span>or use your email password</span>
          <input type="email" name="email" placeholder="Email" required/>
          <input type="password" name="password" placeholder="Password" required/>
          <a href="#">Forget Your Password?</a>
          <?php if(isset($_SESSION['error'])): ?>
              <div class="alert alert-danger">
                  <?php 
                      echo $_SESSION['error'];
                      unset($_SESSION['error']);
                  ?>
              </div>
          <?php endif; ?>
          <button type="submit" name="login">Sign In</button>
        </form>
      </div>
      <div class="toggle-container">
        <div class="toggle">
          <div class="toggle-panel toggle-left">
            <h1>Welcome Back!</h1>
            <p>Enter your personal details to use all of site features</p>
            <button class="hidden" id="login">Sign In</button>
          </div>
          <div class="toggle-panel toggle-right">
            <h1>Hello, Cruiser!
                <br>
                Welcome to BachaoAirlines.
            </h1>
            <p>
              Register with your personal details to use all of site features
            </p>
            <button class="hidden" id="register">Sign Up</button>
          </div>
        </div>
      </div>
    </div>
    <video autoplay loop muted plays-inline class="background-clips">
      <source src="pics/background.mp4"
      type="video/mp4">
  </video>

    <script>
        const container = document.getElementById("container");
        const registerBtn = document.getElementById("register");
        const loginBtn = document.getElementById("login");

        registerBtn.addEventListener("click", () => {
            container.classList.add("active");
        });

        loginBtn.addEventListener("click", () => {
            container.classList.remove("active");
        });
    </script>
  </body>
</html>