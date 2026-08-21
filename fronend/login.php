<?php
// 1. Start the session BEFORE any HTML is sent to the browser
session_start();

// 2. Include the database connection
require_once '../backend/php/connection.php';

// 3. Determine if the current viewer is already a logged-in Admin
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// 4. Auto-redirect if already logged in (and not trying to logout)
if ($isAdmin && !isset($_GET['logout'])) {
    header("Location: admin-dashboard.php");
    exit;
}

// 5. Handle Logout
if (isset($_GET['logout'])) {
    // Clear all session variables and destroy the session
    $_SESSION = [];
    session_destroy();
    
    // UPDATED: Redirects to login.php instead of admin.php
    header("Location: login.php");
    exit;
}

$error = '';

// 6. Handle the Login Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Added empty field validation
    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password.";
    } else {
        try {
            // Fetch the user from the database (Added LIMIT 1 for optimization)
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch();

            // Verify the user exists and the password matches the hash
            if ($user && password_verify($password, $user['password_hash'])) {
                
                // Save secure data to the session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['username'] = $user['username'];

                // Route based on role
                if ($user['role'] === 'admin') {
                    header("Location: admin-dashboard.php");
                    exit;
                } else {
                    // Redirect standard customers to the homepage
                    header("Location: index.php");
                    exit;
                }
            } else {
                $error = "Invalid username or password.";
            }
        } catch (PDOException $e) {
            $error = "System error. Please try again later.";
        }
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aetheria Books | User Login</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <!-- Stylesheet -->
    <link rel="stylesheet" href="styles.css" />
    
    <!-- Theme Script -->
    <script>
      const savedTheme = localStorage.getItem("theme");
      if (savedTheme) { document.documentElement.setAttribute("data-theme", savedTheme); }
      function toggleTheme() {
        const current = document.documentElement.getAttribute("data-theme");
        const next = current === "light" ? "dark" : "light";
        document.documentElement.setAttribute("data-theme", next);
        localStorage.setItem("theme", next);
      }
    </script>
  </head>
  <body>
    <!-- Top Navigation Bar -->
    <header class="navbar">
      <div class="nav-container">
        <a href="index.php" class="logo">
          <div class="logo-icon"><i class="fa-solid fa-book-bookmark"></i></div>
          <div class="logo-text">Aetheria<span>Books</span></div>
        </a>

        <div class="nav-actions">
          <button onclick="toggleTheme()" class="btn-icon" title="Toggle Light/Dark Mode" style="background:transparent; border:none; color:var(--text-main); font-size:1.2rem; cursor:pointer; margin-right:15px;">
            <i class="fa-solid fa-circle-half-stroke"></i>
          </button>
          
          <a href="index.php" class="role-btn" style="margin-right: 15px;">
            <i class="fa-solid fa-arrow-left"></i> Back to Store
          </a>
        </div>
      </div>
    </header>

    <main class="main-wrapper">
      
      <!-- ===================================================================
         LOGIN SECTION
         =================================================================== -->
      <section id="admin-portal" class="content-section">
        <div class="section-header">
          <h2>
            <i class="fa-solid fa-user-shield" style="color: var(--accent-gold)"></i> Account Authentication
          </h2>
          <p>Login to access your dashboard</p>
        </div>

        <div class="card-box" style="max-width: 440px; margin: 0 auto">
          
          <!-- UPDATED: Form action now points to login.php -->
          <form action="login.php" method="POST">
            
            <!-- Error Message Display -->
            <?php if ($error): ?>
              <div style="background: rgba(220, 53, 69, 0.1); color: #dc3545; border: 1px solid #dc3545; padding: 12px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: 500;">
                <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?>
              </div>
            <?php endif; ?>

            <div class="form-group">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" placeholder="Enter username" required autofocus />
            </div>
            
            <div class="form-group">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" placeholder="Enter password" required />
            </div>

            <button type="submit" name="login" class="btn-primary" style="width: 100%; justify-content: center; margin-top: 1rem; cursor: pointer; border: none; font-size: 1rem;">
              <i class="fa-solid fa-right-to-bracket"></i> Secure Login
            </button>
          </form>
        </div>
      </section>

    </main>
  </body>
</html>