<?php
// 1. SECURITY: Ensure the user is an admin before loading the page
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin.php");
    exit;
}

// 2. Connect to the database
require_once '../backend/php/connection.php';

$message = '';
$editBook = null;

// ==========================================
// CRUD: DELETE BOOK
// ==========================================
if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
    $stmt = $pdo->prepare("DELETE FROM books WHERE id = :id");
    $stmt->execute(['id' => $_GET['delete_id']]);
    header("Location: admin-dashboard.php?msg=deleted");
    exit;
}

// ==========================================
// CRUD: CREATE OR UPDATE BOOK
// ==========================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_book'])) {
    $book_id = $_POST['book_id'] ?? '';
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $category = $_POST['category'];
    $price = $_POST['price'];
    $cover_image = $_POST['cover_image'] ? trim($_POST['cover_image']) : 'default_cover.jpg';
    $trending_score = $_POST['trending_score'] ? (int)$_POST['trending_score'] : 0;

    if (!empty($book_id)) {
        // UPDATE (If a book ID was provided)
        $stmt = $pdo->prepare("UPDATE books SET title=?, author=?, category=?, price=?, cover_image=?, trending_score=? WHERE id=?");
        $stmt->execute([$title, $author, $category, $price, $cover_image, $trending_score, $book_id]);
        header("Location: admin-dashboard.php?msg=updated");
        exit;
    } else {
        // CREATE (If no book ID exists)
        $stmt = $pdo->prepare("INSERT INTO books (title, author, category, price, cover_image, trending_score) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $author, $category, $price, $cover_image, $trending_score]);
        header("Location: admin-dashboard.php?msg=created");
        exit;
    }
}

// ==========================================
// READ: FETCH DATA FOR TABLES & FORMS
// ==========================================

// Handle success messages
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'created') $message = "Book successfully added!";
    if ($_GET['msg'] === 'updated') $message = "Book successfully updated!";
    if ($_GET['msg'] === 'deleted') $message = "Book successfully deleted!";
}

// Check if Admin clicked 'Edit' to populate the form
if (isset($_GET['edit_id']) && is_numeric($_GET['edit_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM books WHERE id = :id");
    $stmt->execute(['id' => $_GET['edit_id']]);
    $editBook = $stmt->fetch();
}

// Fetch all books for the Inventory Table
$inventory = $pdo->query("SELECT * FROM books ORDER BY id DESC")->fetchAll();

// Fetch all orders for the Orders Table
$orders = $pdo->query("SELECT * FROM orders ORDER BY order_date DESC")->fetchAll();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aetheria Books | Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body>
    <!-- Top Navigation Bar -->
    <header class="navbar">
      <div class="nav-container">
        <a href="index.php" class="logo">
          <div class="logo-icon"><i class="fa-solid fa-book-bookmark"></i></div>
          <div class="logo-text">Aetheria<span>Books</span> Admin</div>
        </a>

        <div class="nav-actions">
          <span style="margin-right: 20px; color: var(--text-main); font-weight: bold;">
            Welcome, <?= htmlspecialchars($_SESSION['username']) ?>
          </span>
          <a href="login.php?logout=true" class="role-btn active" style="background: var(--accent-red); color: white; border: none;">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
          </a>
        </div>
      </div>
    </header>

    <main class="main-wrapper">
      
      <?php if ($message): ?>
        <div style="background: #d4edda; color: #155724; padding: 15px; text-align: center; margin-bottom: 20px; border-radius: 5px; font-weight: bold;">
            <?= htmlspecialchars($message) ?>
        </div>
      <?php endif; ?>

      <!-- ===================================================================
         INVENTORY MANAGEMENT (CREATE & UPDATE FORM)
         =================================================================== -->
      <section id="admin-inventory" class="content-section">
        <div class="section-header">
          <h2><i class="fa-solid fa-boxes-stacked" style="color: var(--accent-gold)"></i> Admin Inventory Management</h2>
          <p>Maintain book catalogue: Add, edit, or update book titles.</p>
        </div>

        <div class="card-box" style="margin-bottom: 2rem">
          <h3 style="font-family: var(--font-heading); margin-bottom: 1.25rem">
            <i class="fa-solid <?= $editBook ? 'fa-pen' : 'fa-plus-circle' ?>"></i> 
            <?= $editBook ? 'Edit Existing Book' : 'Add New Book' ?>
          </h3>

          <form action="admin-dashboard.php" method="POST">
            <!-- Hidden ID field required for Updating -->
            <input type="hidden" name="book_id" value="<?= $editBook ? $editBook['id'] : '' ?>">
            
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Book Title</label>
                <input type="text" name="title" class="form-control" required value="<?= $editBook ? htmlspecialchars($editBook['title']) : '' ?>" />
              </div>
              <div class="form-group">
                <label class="form-label">Author</label>
                <input type="text" name="author" class="form-control" required value="<?= $editBook ? htmlspecialchars($editBook['author']) : '' ?>" />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Category</label>
                <select name="category" class="form-control">
                  <option value="Sci-Fi" <?= ($editBook && $editBook['category'] == 'Sci-Fi') ? 'selected' : '' ?>>Sci-Fi</option>
                  <option value="Fantasy" <?= ($editBook && $editBook['category'] == 'Fantasy') ? 'selected' : '' ?>>Fantasy</option>
                  <option value="Tech & Coding" <?= ($editBook && $editBook['category'] == 'Tech & Coding') ? 'selected' : '' ?>>Tech & Coding</option>
                  <option value="Biography" <?= ($editBook && $editBook['category'] == 'Biography') ? 'selected' : '' ?>>Biography</option>
                  <option value="Educational" <?= ($editBook && $editBook['category'] == 'Educational') ? 'selected' : '' ?>>Educational</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Price ($)</label>
                <input type="number" step="0.01" name="price" class="form-control" required value="<?= $editBook ? $editBook['price'] : '' ?>" />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Trending Score</label>
                <input type="number" name="trending_score" class="form-control" value="<?= $editBook ? $editBook['trending_score'] : '0' ?>" />
              </div>
              <div class="form-group">
                <label class="form-label">Cover Image File (e.g. dune.jpg)</label>
                <input type="text" name="cover_image" class="form-control" value="<?= $editBook ? htmlspecialchars($editBook['cover_image']) : '' ?>" />
              </div>
            </div>

            <button type="submit" name="save_book" class="btn-primary" style="margin-top: 0.5rem; border:none; cursor:pointer;">
              <i class="fa-solid fa-floppy-disk"></i> <?= $editBook ? 'Update Book' : 'Save New Book' ?>
            </button>
            <?php if ($editBook): ?>
                <a href="admin-dashboard.php" class="btn-secondary" style="margin-left: 10px;">Cancel Edit</a>
            <?php endif; ?>
          </form>
        </div>

        <!-- ===================================================================
         READ / DELETE: INVENTORY DATA TABLE
         =================================================================== -->
        <div class="table-responsive">
          <table class="data-table">
            <thead>
              <tr>
                <th>Cover</th>
                <th>Book Details</th>
                <th>Category</th>
                <th>Price</th>
                <th>Score</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($inventory as $book): ?>
              <tr>
                <td><img src="assets/<?= htmlspecialchars($book['cover_image']) ?>" alt="cover" class="table-thumb" style="width: 50px;" /></td>
                <td>
                  <strong style="color: var(--text-main)"><?= htmlspecialchars($book['title']) ?></strong>
                  <div style="font-size: 0.75rem; color: var(--text-muted)">by <?= htmlspecialchars($book['author']) ?> | ID: bk_<?= $book['id'] ?></div>
                </td>
                <td><span class="badge badge-gold"><?= htmlspecialchars($book['category']) ?></span></td>
                <td style="color: var(--accent-gold); font-weight: 700">$<?= number_format($book['price'], 2) ?></td>
                <td><?= $book['trending_score'] ?></td>
                <td>
                  <a href="admin-dashboard.php?edit_id=<?= $book['id'] ?>#admin-inventory" class="btn-secondary btn-sm"><i class="fa-solid fa-pen"></i></a>
                  <!-- Added confirmation popup before deleting -->
                  <a href="admin-dashboard.php?delete_id=<?= $book['id'] ?>" class="btn-primary btn-sm" style="background: var(--accent-red); margin-left: 5px;" onclick="return confirm('Are you sure you want to delete this book? This cannot be undone.');">
                    <i class="fa-solid fa-trash"></i>
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </section>

      <!-- ===================================================================
         ORDER MANAGEMENT
         =================================================================== -->
      <section id="admin-orders" class="content-section">
        <div class="section-header">
          <h2><i class="fa-solid fa-truck-ramp-box" style="color: var(--accent-gold)"></i> Admin Order Management</h2>
          <p>Monitor real customer orders and tracking</p>
        </div>

        <div class="table-responsive">
          <table class="data-table">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Book ID</th>
                <th>Customer Name & Email</th>
                <th>Total Price</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              <?php if (count($orders) > 0): ?>
                  <?php foreach ($orders as $order): ?>
                  <tr>
                    <td><strong style="color: var(--accent-gold)">ORD-<?= $order['id'] ?></strong></td>
                    <td>bk_<?= $order['book_id'] ?></td>
                    <td>
                      <strong><?= htmlspecialchars($order['customer_name']) ?></strong>
                      <div style="font-size: 0.75rem; color: var(--text-muted)"><?= htmlspecialchars($order['customer_email']) ?></div>
                    </td>
                    <td style="color: var(--accent-gold); font-weight: 700">$<?= number_format($order['total_price'], 2) ?></td>
                    <td><?= htmlspecialchars($order['payment_method']) ?> (<?= htmlspecialchars($order['payment_status']) ?>)</td>
                    <td><span class="badge badge-emerald"><?= htmlspecialchars($order['delivery_status']) ?></span></td>
                    <td><?= date('Y-m-d', strtotime($order['order_date'])) ?></td>
                  </tr>
                  <?php endforeach; ?>
              <?php else: ?>
                  <tr><td colspan="7" style="text-align:center;">No orders placed yet.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </section>

    </main>
  </body>
</html>