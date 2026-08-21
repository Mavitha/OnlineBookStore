<?php
// 1. Connect to your database
require_once '../backend/php/connection.php';

// 2. Check if a category was selected in the URL, default to 'all'
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : 'all';

try {
    // 3. Dynamically adjust the SQL query based on the selection
    if ($selectedCategory !== 'all') {
        // Use a prepared statement to prevent SQL injection when using variables
        $stmt = $pdo->prepare("SELECT * FROM books WHERE category = :category");
        $stmt->execute(['category' => $selectedCategory]);
    } else {
        // If 'all' is selected, grab everything
        $stmt = $pdo->query("SELECT * FROM books");
    }
    
    $books = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Book Catalogue | Aetheria Books</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="styles.css" />
</head>

<body>

  <!-- ===================================================================
         NAVIGATION HEADER
         =================================================================== -->
  <header class="navbar" style="padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ccc; margin-bottom: 2rem;">
    <div>
      <a href="index.php" style="text-decoration: none; font-size: 1.1rem; color: inherit;">
        <i class="fa-solid fa-house"></i> Home
      </a>
    </div>
    <div>
      <a href="login.php" style="text-decoration: none; font-size: 1.1rem; color: inherit;">
        <i class="fa-solid fa-right-to-bracket"></i> Sign In
      </a>
    </div>
  </header>

  <!-- ===================================================================
         USER SECTION 2: BOOK CATALOGUE
         =================================================================== -->
  <section id="catalogue" class="content-section">
    <div class="section-header">
      <h2>
        <i class="fa-solid fa-book" style="color: var(--accent-gold)"></i>
        Book Catalogue
      </h2>
      <p>Browse all available titles in store</p>
    </div>

    <!-- Server-Side HTML Search & Filter Controls -->
    <form class="filter-section" action="book-catalogue.php" method="GET">
      <div class="filter-top-row">
        <div class="search-box">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="text" class="search-input" id="catalogueSearch" placeholder="Filter titles by name or author..." />
        </div>
        
        <select class="sort-select" name="category" id="categorySelect" title="Filter by Category" onchange="this.form.submit()">
          <option value="all" <?= $selectedCategory === 'all' ? 'selected' : '' ?>>All Categories</option>
          <option value="Educational" <?= $selectedCategory === 'Educational' ? 'selected' : '' ?>>Educational</option>
          <option value="Fiction" <?= $selectedCategory === 'Fiction' ? 'selected' : '' ?>>Fiction</option>
          <option value="Sci-fi" <?= $selectedCategory === 'Sci-fi' ? 'selected' : '' ?>>Sci-fi</option>
          <option value="Biography" <?= $selectedCategory === 'Biography' ? 'selected' : '' ?>>Biography</option>
          
        </select>
      </div>
    </form>

    <!-- Dynamic Book Cards Grid Pulled From Database -->
    <div class="books-grid">

      <?php if (count($books) > 0): ?>
          <?php foreach ($books as $book): ?>
          <article class="book-card" data-category="<?= htmlspecialchars(strtolower($book['category'])) ?>"
            data-title="<?= htmlspecialchars(strtolower($book['title'])) ?>"
            data-author="<?= htmlspecialchars(strtolower($book['author'])) ?>">
            <div class="book-cover-wrap">
              <!-- UPDATED: Changed .html to .php here -->
              <a href="book-details.php?id=<?= $book['id'] ?>">
                <img src="assets/<?= htmlspecialchars($book['cover_image']) ?>"
                  alt="<?= htmlspecialchars($book['title']) ?>" class="book-cover" />
              </a>
              <div class="book-category-tag">
                <span class="badge badge-emerald">In Stock</span>
              </div>
            </div>
            <div class="book-info">
              <span class="category-label">
                <?= htmlspecialchars($book['category']) ?>
              </span>
              <!-- UPDATED: Changed .html to .php here -->
              <a href="book-details.php?id=<?= $book['id'] ?>" class="book-title-link">
                <h3 class="book-title">
                  <?= htmlspecialchars($book['title']) ?>
                </h3>
              </a>
              <p class="book-author">by
                <?= htmlspecialchars($book['author']) ?>
              </p>
              <div class="book-rating">
                <i class="fa-solid fa-star"></i> 4.5
                <span class="book-rating-num">(ID: bk_<?= $book['id'] ?>)</span>
              </div>
              <div class="book-footer">
                <span class="book-price">$<?= number_format($book['price'], 2) ?></span>
                <button onclick="addToCart(<?= $book['id'] ?>, '<?= htmlspecialchars(addslashes($book['title'])) ?>', <?= $book['price'] ?>)" class="add-cart-btn" style="border:none; cursor:pointer; background: transparent; font-family: inherit; font-size: inherit; color: var(--text-main);">
                      <i class="fa-solid fa-cart-plus"></i> Add to Cart
                    </button>
                
              </div>
            </div>
          </article>
          <?php endforeach; ?>
      <?php else: ?>
          <p style="grid-column: 1 / -1; text-align: center; padding: 2rem;">No books found in this category.</p>
      <?php endif; ?>

    </div>
  </section>

  <script src="app.js"></script>
</body>

</html>