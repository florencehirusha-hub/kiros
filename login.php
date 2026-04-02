<?php
session_start();
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        // Replace this with your real database login logic
        // Example only:
        if ($email === "admin@kairos.lk" && $password === "123456") {
            $_SESSION["user_email"] = $email;
            header("Location: index.html");
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | Kairos</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      --navy: #04113b;
      --navy-deep: #020b26;
      --blue: #0a56b5;
      --cyan: #36c7f4;
      --cyan-soft: #c9f6ff;
      --white: #ffffff;
      --text: #2d3754;
      --muted: #627090;
      --border: rgba(4, 17, 59, 0.08);
      --shadow: 0 18px 45px rgba(4, 17, 59, 0.12);
      --shadow-strong: 0 22px 60px rgba(2, 11, 38, 0.28);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Inter", sans-serif;
    }

    body {
      min-height: 100vh;
      background:
        radial-gradient(circle at top left, rgba(54, 199, 244, 0.18), transparent 28%),
        radial-gradient(circle at right center, rgba(10, 86, 181, 0.28), transparent 28%),
        linear-gradient(135deg, var(--navy-deep) 0%, var(--navy) 42%, var(--blue) 82%, var(--cyan) 160%);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px;
    }

    .auth-wrapper {
      width: 100%;
      max-width: 1150px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      background: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.14);
      border-radius: 30px;
      overflow: hidden;
      backdrop-filter: blur(16px);
      box-shadow: var(--shadow-strong);
    }

    .auth-left {
      padding: 60px;
      color: var(--white);
      display: flex;
      flex-direction: column;
      justify-content: center;
      position: relative;
    }

    .auth-left::before {
      content: "";
      position: absolute;
      width: 220px;
      height: 220px;
      background: rgba(255,255,255,0.08);
      border-radius: 50%;
      top: -60px;
      right: -60px;
      filter: blur(10px);
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 14px;
      margin-bottom: 28px;
      position: relative;
      z-index: 1;
    }

    .brand img {
      width: 56px;
      height: 56px;
      object-fit: contain;
    }

    .brand h2 {
      font-size: 1.4rem;
      margin-bottom: 4px;
    }

    .brand p {
      color: rgba(255,255,255,0.78);
      font-size: 0.92rem;
    }

    .auth-left h1 {
      font-size: clamp(2.2rem, 5vw, 3.8rem);
      line-height: 1.08;
      margin-bottom: 18px;
      position: relative;
      z-index: 1;
    }

    .auth-left .subtitle {
      color: rgba(255,255,255,0.82);
      font-size: 1rem;
      max-width: 500px;
      margin-bottom: 28px;
      position: relative;
      z-index: 1;
    }

    .feature-list {
      display: grid;
      gap: 14px;
      position: relative;
      z-index: 1;
    }

    .feature-list div {
      padding: 14px 16px;
      border-radius: 16px;
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(255,255,255,0.1);
      color: rgba(255,255,255,0.9);
    }

    .auth-right {
      background: #ffffff;
      padding: 55px 45px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .form-box {
      width: 100%;
      max-width: 420px;
    }

    .top-link {
      text-align: right;
      margin-bottom: 18px;
      font-size: 0.95rem;
      color: var(--muted);
    }

    .top-link a {
      color: var(--blue);
      font-weight: 700;
      text-decoration: none;
    }

    .form-box h3 {
      font-size: 2rem;
      color: var(--navy);
      margin-bottom: 10px;
    }

    .form-box .desc {
      color: var(--muted);
      margin-bottom: 24px;
    }

    .error-message {
      background: rgba(255, 72, 72, 0.08);
      border: 1px solid rgba(255, 72, 72, 0.18);
      color: #c62828;
      padding: 14px 16px;
      border-radius: 14px;
      margin-bottom: 18px;
      font-size: 0.95rem;
    }

    .input-group {
      margin-bottom: 16px;
    }

    .input-group label {
      display: block;
      margin-bottom: 8px;
      color: var(--navy);
      font-weight: 600;
      font-size: 0.95rem;
    }

    .input-group input {
      width: 100%;
      padding: 15px 16px;
      border-radius: 14px;
      border: 1px solid rgba(4, 17, 59, 0.12);
      outline: none;
      font-size: 0.96rem;
      transition: 0.3s ease;
      color: var(--text);
    }

    .input-group input:focus {
      border-color: var(--blue);
      box-shadow: 0 0 0 4px rgba(54, 199, 244, 0.15);
    }

    .form-options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 12px;
      margin-bottom: 22px;
      font-size: 0.92rem;
    }

    .form-options label {
      color: var(--muted);
    }

    .form-options a {
      color: var(--blue);
      text-decoration: none;
      font-weight: 600;
    }

    .btn-submit {
      width: 100%;
      border: none;
      padding: 15px 18px;
      border-radius: 999px;
      background: linear-gradient(135deg, var(--cyan), var(--blue));
      color: var(--white);
      font-size: 1rem;
      font-weight: 700;
      cursor: pointer;
      box-shadow: 0 12px 30px rgba(10, 86, 181, 0.24);
      transition: 0.3s ease;
    }

    .btn-submit:hover {
      transform: translateY(-2px);
    }

    .back-home {
      display: inline-block;
      margin-top: 18px;
      color: var(--muted);
      text-decoration: none;
      font-size: 0.94rem;
    }

    .back-home:hover {
      color: var(--blue);
    }

    @media (max-width: 900px) {
      .auth-wrapper {
        grid-template-columns: 1fr;
      }

      .auth-left {
        padding: 40px 30px;
      }

      .auth-right {
        padding: 40px 24px;
      }
    }

    @media (max-width: 560px) {
      .auth-left h1 {
        font-size: 2rem;
      }

      .form-options {
        flex-direction: column;
        align-items: flex-start;
      }
    }
  </style>
</head>
<body>
  <div class="auth-wrapper">
    <div class="auth-left">
      <div class="brand">
        <img src="delta-strix-logo.png" alt="Delta Strix Logo">
        <div>
          <h2>Kairos</h2>
          <p>by Delta Strix</p>
        </div>
      </div>

      <h1>Welcome back to your career guidance platform.</h1>
      <p class="subtitle">
        Log in to continue your journey, access personalized recommendations, and explore future pathways with confidence.
      </p>

      <div class="feature-list">
        <div>Personalized pathway recommendations</div>
        <div>Career and A/L stream guidance</div>
        <div>Clean, student-friendly dashboard experience</div>
      </div>
    </div>

    <div class="auth-right">
      <div class="form-box">
        <div class="top-link">
          Don’t have an account? <a href="signup.php">Sign Up</a>
        </div>

        <h3>Login</h3>
        <p class="desc">Enter your details to access your Kairos account.</p>

        <?php if (!empty($error)): ?>
          <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
          <div class="input-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
          </div>

          <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
          </div>

          <div class="form-options">
            <label><input type="checkbox"> Remember me</label>
            <a href="#">Forgot Password?</a>
          </div>

          <button type="submit" class="btn-submit">Login</button>
        </form>

        <a href="index.html" class="back-home">← Back to Home</a>
      </div>
    </div>
  </div>
</body>
</html>