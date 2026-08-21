<?php
session_start();
require_once '../backend/php/connection.php';

$checkoutMessage = '';
$messageType = '';

// Process the Checkout Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    $name = trim($_POST['customer_name']);
    $email = trim($_POST['customer_email']);
    $paymentMethod = $_POST['payment_method'];
    
    // Decode the JSON cart data sent from app.js
    $cartData = json_decode($_POST['cart_data'], true);

    if (!empty($cartData) && !empty($name) && !empty($email)) {
        try {
            // Use a database transaction to ensure all items process safely
            $pdo->beginTransaction();

            // Based on your schema, we insert one row per book ordered
            $stmt = $pdo->prepare("INSERT INTO orders (book_id, customer_name, customer_email, total_price, payment_method, payment_status) VALUES (?, ?, ?, ?, ?, 'Pending')");

            foreach ($cartData as $item) {
                // Calculate the total for this specific item row
                $totalItemPrice = $item['price'] * $item['quantity'];
                
                // For simplicity with your schema, if quantity is > 1, we still insert it as one row, 
                // but realistically, you might loop the insert based on quantity. We will sum the price here.
                $stmt->execute([$item['id'], $name, $email, $totalItemPrice, $paymentMethod]);
            }

            $pdo->commit();
            $checkoutMessage = "Order placed successfully! Tracking details will be emailed to $email.";
            $messageType = "success";
            
            // Clear the cart from the user's browser using a quick script injection
            echo "<script>localStorage.removeItem('aetheria_cart');</script>";
            
        } catch (PDOException $e) {
            $pdo->rollBack();
            $checkoutMessage = "Error processing order. Please try again.";
            $messageType = "error";
        }
    } else {
        $checkoutMessage = "Checkout failed. Your cart is empty or details are missing.";
        $messageType = "error";
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aetheria Books | Secure Checkout</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="styles.css" />
    
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
            <i class="fa-solid fa-arrow-left"></i> Continue Shopping
          </a>
        </div>
      </div>
    </header>

    <main class="main-wrapper">
      <section class="content-section">
        <div class="section-header">
          <h2><i class="fa-solid fa-cart-shopping" style="color: var(--accent-gold)"></i> Your Shopping Cart</h2>
          <p>Review your items and complete your secure checkout</p>
        </div>

        <?php if ($checkoutMessage): ?>
          <div style="background: <?= $messageType === 'success' ? '#d4edda' : '#ffcccc' ?>; color: <?= $messageType === 'success' ? '#155724' : '#cc0000' ?>; padding: 15px; text-align: center; margin-bottom: 20px; border-radius: 5px; font-weight: bold;">
              <?= htmlspecialchars($checkoutMessage) ?>
          </div>
        <?php endif; ?>

        <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
            
            <!-- LEFT COLUMN: Cart Items (Rendered by JS) -->
            <div class="card-box" style="flex: 2; min-width: 300px;">
                <h3 style="font-family: var(--font-heading); margin-bottom: 1rem; border-bottom: 2px solid var(--border-subtle); padding-bottom: 0.5rem;">Order Summary</h3>
                
                <div id="cart-items-container">
                    <!-- JavaScript will inject cart items here -->
                </div>
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem; padding-top: 1rem; border-top: 2px solid var(--border-subtle);">
                    <span style="font-size: 1.2rem; font-weight: bold;">Grand Total:</span>
                    <span id="cart-total-display" style="font-size: 1.5rem; color: var(--accent-gold); font-weight: 800;">$0.00</span>
                </div>
            </div>

            <!-- RIGHT COLUMN: Checkout Form -->
            <div class="card-box" style="flex: 1; min-width: 300px; height: fit-content;">
                <h3 style="font-family: var(--font-heading); margin-bottom: 1rem;">Customer Details</h3>
                
                <form action="cart.php" method="POST">
                    <!-- Hidden input to carry the JS cart data to PHP -->
                    <input type="hidden" name="cart_data" id="hidden-cart-data">

                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="customer_name" class="form-control" required placeholder="Eleanor Vance" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="customer_email" class="form-control" required placeholder="eleanor@example.com" />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method" class="form-control" required>
                            <option value="Credit Card">Credit Card</option>
                            <option value="PayPal">PayPal</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                        </select>
                    </div>

                    <button type="submit" name="checkout" id="checkout-btn" class="btn-primary" style="width: 100%; justify-content: center; margin-top: 1rem; cursor: pointer; border: none; font-size: 1rem;">
                        <i class="fa-solid fa-lock"></i> Submit Secure Order
                    </button>
                </form>
            </div>

        </div>
      </section>
    </main>

    <footer style="text-align: center; padding: 2rem 1rem; color: var(--text-muted); font-size: 0.85rem; border-top: 1px solid var(--border-subtle); margin-top: 4rem;">
      &copy; 2026 Aetheria Books. Traditional Single Page Book Store Application.
    </footer>
    
    <!-- Include the JS engine -->
    <script src="app.js"></script>
  </body>
</html>