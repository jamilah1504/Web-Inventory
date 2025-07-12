<?php include "koneksi.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register - Modern Design</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    :root {
      --primary: #6366f1;
      --primary-dark: #4f46e5;
      --secondary: #f43f5e;
      --dark: #1e293b;
      --light: #f8fafc;
      --gray: #94a3b8;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }
    
    body {
      background-color: #f1f5f9;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
    
    .auth-container {
      display: flex;
      width: 100%;
      max-width: 1100px;
      background: white;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
      overflow: hidden;
    }
    
    .auth-illustration {
      flex: 1;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      padding: 60px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      color: white;
      text-align: center;
    }
    
    .auth-illustration img {
      max-width: 90%;
      height: auto;
      margin-bottom: 30px;
    }
    
    .auth-illustration h2 {
      font-size: 2rem;
      margin-bottom: 15px;
      font-weight: 600;
    }
    
    .auth-illustration p {
      opacity: 0.9;
      margin-bottom: 30px;
      font-size: 0.95rem;
    }
    
    .auth-form {
      flex: 1;
      padding: 60px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    
    .logo {
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--primary);
      margin-bottom: 10px;
    }
    
    .auth-form h3 {
      font-size: 1.5rem;
      color: var(--dark);
      margin-bottom: 5px;
    }
    
    .auth-form p.subtitle {
      color: var(--gray);
      margin-bottom: 30px;
      font-size: 0.9rem;
    }
    
    .form-group {
      margin-bottom: 20px;
      position: relative;
    }
    
    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-size: 0.9rem;
      color: var(--dark);
      font-weight: 500;
    }
    
    .form-control {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      font-size: 0.95rem;
      transition: all 0.3s;
    }
    
    .form-control:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
    
    .btn {
      padding: 12px 20px;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s;
      border: none;
    }
    
    .btn-primary {
      background-color: var(--primary);
      color: white;
    }
    
    .btn-primary:hover {
      background-color: var(--primary-dark);
      transform: translateY(-2px);
    }
    
    .btn-outline {
      background: transparent;
      border: 1px solid var(--primary);
      color: var(--primary);
    }
    
    .btn-outline:hover {
      background-color: var(--primary);
      color: white;
    }
    
    .divider {
      display: flex;
      align-items: center;
      margin: 25px 0;
    }
    
    .divider::before, .divider::after {
      content: "";
      flex: 1;
      border-bottom: 1px solid #e2e8f0;
    }
    
    .divider-text {
      padding: 0 15px;
      color: var(--gray);
      font-size: 0.8rem;
    }
    
    .social-login {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-bottom: 25px;
    }
    
    .social-btn {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.1rem;
      transition: all 0.3s;
    }
    
    .social-btn:hover {
      transform: translateY(-3px);
    }
    
    .facebook {
      background-color: #3b5998;
    }
    
    .google {
      background-color: #db4437;
    }
    
    .twitter {
      background-color: #1da1f2;
    }
    
    .text-center {
      text-align: center;
    }
    
    .mt-4 {
      margin-top: 1.5rem;
    }
    
    .text-primary {
      color: var(--primary);
      text-decoration: none;
      font-weight: 500;
    }
    
    .text-primary:hover {
      text-decoration: underline;
    }
    
    .checkbox-container {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }
    
    .checkbox-container input {
      margin-right: 10px;
    }
    
    @media (max-width: 768px) {
      .auth-container {
        flex-direction: column;
      }
      
      .auth-illustration {
        padding: 40px 20px;
        display: none;
      }
      
      .auth-form {
        padding: 40px;
      }
    }
  </style>
</head>
<body>
  <div class="auth-container">
    <div class="auth-illustration">
      <img src="/Web-Inventory/assets/images/logo.png" alt="Register Illustration" style="width: 300px;">
      <h2>One of us?</h2>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum laboriosam od deleniti.</p>
    </div>
    
    <div class="auth-form">
      <div class="logo">YourLogo</div>
      <h3>Create Account</h3>
      <p class="subtitle">Join us today! It takes only few steps</p>
      
      <form method="post" action="proses.php?action=register">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username" required>
        </div>
        
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
        </div>
        
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" class="form-control" placeholder="Create password" required>
        </div>
        
        <div class="checkbox-container">
          <input type="checkbox" id="terms" required>
          <label for="terms">I agree to all Terms & Conditions</label>
        </div>
        
        <button type="submit" class="btn btn-primary">SIGN UP</button>
      </form>
      
      <div class="divider">
        <span class="divider-text">OR CONTINUE WITH</span>
      </div>
      
      <div class="social-login">
        <a href="#" class="social-btn facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="social-btn google"><i class="fab fa-google"></i></a>
        <a href="#" class="social-btn twitter"><i class="fab fa-twitter"></i></a>
      </div>
      
      <p class="text-center mt-4">Already have an account? <a href="login.php" class="text-primary">Sign In</a></p>
    </div>
  </div>
</body>
</html>