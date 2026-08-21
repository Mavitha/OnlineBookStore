<?php
// 1. Connect to the database
require_once '../backend/php/connection.php';

$book = null;

// 2. Check if a valid numeric ID is present in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    try {
        // 3. Prepare the SQL query to fetch just ONE specific book
        $stmt = $pdo->prepare("SELECT * FROM books WHERE id = :id");
        $stmt->execute(['id' => $_GET['id']]);
        
        // Fetch the single row
        $book = $stmt->fetch();
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Aetheria Books | Book Details</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="styles.css" />
  <script>
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
      document.documentElement.setAttribute('data-theme', savedTheme);
    }
    function toggleTheme() {
      const current = document.documentElement.getAttribute('data-theme');
      const next = current === 'light' ? 'dark' : 'light';
      document.documentElement.setAttribute('data-theme', next);
      localStorage.setItem('theme', next);
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
      
      <!-- Search Bar -->
      <div class="nav-search-bar" style="display:flex; align-items:center; background:var(--bg-surface-elevated); padding:0.4rem 1rem; border-radius:20px; border:1px solid var(--border-subtle); min-width: 250px;">
        <i class="fa-solid fa-magnifying-glass" style="color:var(--text-muted); margin-right:8px;"></i>
        <input type="text" placeholder="Search titles, authors..." style="border:none; background:transparent; outline:none; color:var(--text-main); font-family:var(--font-body); font-size:0.9rem; width: 100%;" />
      </div>
      
      <div class="nav-actions">
        <!-- Theme Toggle -->
        <button onclick="toggleTheme()" class="btn-icon" title="Toggle Light/Dark Mode" style="background:transparent; border:none; color:var(--text-main); font-size:1.2rem; cursor:pointer; margin-right:15px;">
          <i class="fa-solid fa-circle-half-stroke"></i>
        </button>
        
        <!-- User Alias Icon -->
        <a href="user-dashboard.html" class="nav-link" title="User Dashboard" style="font-size: 1.25rem; margin-right: 15px;">
          <i class="fa-solid fa-circle-user"></i>
        </a>

        <!-- Sign In button -->
        <a href="admin.html" class="role-btn active">
          <i class="fa-solid fa-right-to-bracket"></i> Sign In
        </a>
      </div>
    </div>
  </header>

  <main class="main-wrapper">
    <div class="details-container">
      
      <?php if ($book): ?>
        <!-- Display this section if the book exists in the database -->
        <section id="bk_<?= htmlspecialchars($book['id']) ?>" class="book-detail-view" style="display: block;">
          <div class="detail-grid">
            
            <img src="assets/<?= htmlspecialchars($book['cover_image']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" class="detail-cover" />
            
            <div class="detail-info">
              <span class="badge badge-gold" style="margin-bottom:0.75rem;"><?= htmlspecialchars($book['category']) ?></span>
              <h2><?= htmlspecialchars($book['title']) ?></h2>
              <div class="detail-author">by <?= htmlspecialchars($book['author']) ?></div>
              
              <!-- Using a generic description as we don't have a description column in the database yet -->
              <p class="detail-desc">A fantastic addition to our <?= htmlspecialchars($book['category']) ?> collection.</p>
              
              <div class="detail-meta-list">
                <div class="meta-item"><label>Price</label><span class="price-val">$<?= number_format($book['price'], 2) ?></span></div>
                <div class="meta-item"><label>Stock Status</label><span>In Stock</span></div>
                <div class="meta-item"><label>Rating</label><span><i class="fa-solid fa-star" style="color: var(--accent-gold);"></i> 4.5 / 5.0</span></div>
                <div class="meta-item"><label>Item ID</label><span>bk_<?= htmlspecialchars($book['id']) ?></span></div>
              </div>

              <!-- Added the JS onclick handler for your cart functionality -->
              <button class="btn-primary" style="display:block; width: 100%; text-align:center; cursor: pointer; border: none;" onclick="addToCart(<?= $book['id'] ?>, '<?= htmlspecialchars(addslashes($book['title'])) ?>', <?= $book['price'] ?>)">
                <i class="fa-solid fa-cart-plus"></i> Add to Cart
              </button>
            </div>
          </div>
        </section>

      <?php else: ?>
        <!-- Display this default view if the ID is missing or invalid -->
        <section class="default-view" style="display: block;">
          <div style="text-align:center; padding: 4rem;">
            <h2 style="font-family: var(--font-heading);">Book Not Found</h2>
            <p>We couldn't locate the details for this item. It may have been removed.</p>
            <a href="book-catalogue.php" class="btn-secondary" style="margin-top:2rem;">Return to Catalogue</a>
          </div>
        </section>
      <?php endif; ?>

    </div>
  </main>
  
  <footer style="text-align:center; padding: 2rem 1rem; color:var(--text-muted); font-size:0.85rem; border-top:1px solid var(--border-subtle); margin-top:4rem;">
    &copy; 2026 Aetheria Books. Traditional Single Page Book Store Application.
  </footer>
  <script src="app.js"></script>
</body>
</html>