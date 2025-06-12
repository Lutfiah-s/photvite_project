<?php
session_start();
include 'config.php';

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = md5($_POST['password']);

  $result = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username' AND password='$password'");

  if (mysqli_num_rows($result) > 0) {
    $_SESSION['admin'] = $username;
    header("Location: dashboard.php");
    exit;
  } else {
    $error = "Username atau password salah!";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Admin</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      background: linear-gradient(to right top, #ffd6e8, #ffe3f1); 
      background-image: url('../assets/admin.jpg');
      background-position: center;
      backdrop-fiter: blur(10px);
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-box {
      background: rgba(255, 255, 255, 0.25);
      backdrop-filter: blur(15px);
      border-radius: 20px;
      padding: 40px 30px;
      box-shadow: 0 8px 40px rgba(255, 105, 180, 0.3);
      width: 100%;
      max-width: 400px;
      animation: fadeIn 0.8s ease;
      border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .login-box h3 {
      text-align: center;
      color: #e91e63;
      margin-bottom: 25px;
      font-size: 26px;
    }

    .input-group {
      position: relative;
      margin-bottom: 20px;
    }

    .input-group i {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #ec407a;
    }

    .input-group input {
      width: 100%;
      padding: 12px 15px 12px 40px;
      border: none;
      border-radius: 12px;
      background-color: rgba(255, 240, 245, 0.7);
      font-size: 14px;
      color: #333;
      outline: none;
      transition: 0.3s ease;
    }

    .input-group input:focus {
      background-color: rgba(255, 240, 245, 1);
      box-shadow: 0 0 0 3px rgba(240, 98, 146, 0.3);
    }

    button {
      width: 100%;
      padding: 12px;
      background: linear-gradient(to right, #f06292, #e91e63);
      border: none;
      color: white;
      border-radius: 12px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: transform 0.2s, background 0.3s ease;
    }

    button:hover {
      background: linear-gradient(to right, #e91e63, #d81b60);
      transform: scale(1.02);
    }

    .error-msg {
      background-color: #ffe6ea;
      color: #b71c1c;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 10px;
      font-size: 14px;
      text-align: center;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h3>Login Admin</h3>
    <?php if (isset($error)) echo "<div class='error-msg'>$error</div>"; ?>
    <form method="POST">
      <div class="input-group">
        <i class="fas fa-user"></i>
        <input type="text" name="username" placeholder="Username" required>
      </div>
      <div class="input-group">
        <i class="fas fa-lock"></i>
        <input type="password" name="password" placeholder="Password" required>
      </div>
      <button name="login" type="submit">Login</button>
    </form>
  </div>
</body>
</html>
