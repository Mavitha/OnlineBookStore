<?php
// 1. Include the database connection securely
require_once '../backend/php/connection.php';

// 2. Check if a category was selected in the URL, default to 'all'
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : 'all';

try {
    // --- NEW: Fetch Trending Books (Top 4 by trending_score) ---
    $stmtTrending = $pdo->query("SELECT * FROM books ORDER BY trending_score DESC LIMIT 4");
    $trendingBooks = $stmtTrending->fetchAll();

    // 3. Dynamically adjust the SQL query based on the selection for the Catalogue
    if ($selectedCategory !== 'all') {
        $stmtAll = $pdo->prepare("SELECT * FROM books WHERE category = :category");
        $stmtAll->execute(['category' => $selectedCategory]);
    } else {
        $stmtAll = $pdo->query("SELECT * FROM books");
    }
    
    $allBooks = $stmtAll->fetchAll();

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aetheria Books | Single Page Bookstore</title>
    <meta
      name="description"
      content="Traditional single page website for Aetheria Books with Customer and Admin portals."
    />

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />

    <!-- Stylesheet -->
    <link rel="stylesheet" href="styles.css" />

    <script>
      const savedTheme = localStorage.getItem("theme");
      if (savedTheme) {
        document.documentElement.setAttribute("data-theme", savedTheme);
      }
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
        <a href="index.php#hero" class="logo">
          <div class="logo-icon"><i class="fa-solid fa-book-bookmark"></i></div>
          <div class="logo-text">Aetheria<span>Books</span></div>
        </a>

        <!-- Search Bar -->
        <div
          class="nav-search-bar"
          style="
            display: flex;
            align-items: center;
            background: var(--bg-surface-elevated);
            padding: 0.4rem 1rem;
            border-radius: 20px;
            border: 1px solid var(--border-subtle);
            min-width: 250px;
          "
        >
          <i
            class="fa-solid fa-magnifying-glass"
            style="color: var(--text-muted); margin-right: 8px"
          ></i>
          <input
            type="text"
            placeholder="Search titles, authors..."
            style="
              border: none;
              background: transparent;
              outline: none;
              color: var(--text-main);
              font-family: var(--font-body);
              font-size: 0.9rem;
              width: 100%;
            "
          />
        </div>

        <div class="nav-actions">
          <!-- Theme Toggle -->
          <button
            onclick="toggleTheme()"
            class="btn-icon"
            title="Toggle Light/Dark Mode"
            style="
              background: transparent;
              border: none;
              color: var(--text-main);
              font-size: 1.2rem;
              cursor: pointer;
              margin-right: 15px;
            "
          >
            <i class="fa-solid fa-circle-half-stroke"></i>
          </button>

          <!-- User Alias Icon -->
          <a
            href="user-dashboard.html"
            class="nav-link"
            title="User Dashboard"
            style="font-size: 1.25rem; margin-right: 15px"
          >
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
      <!-- HERO BANNER -->
      <section id="hero" class="hero-banner">
        <div class="hero-content">
          <span class="badge badge-gold"
            ><i class="fa-solid fa-crown"></i> Official Book Store</span
          >
          <h1>Welcome to <span>Aetheria Books</span></h1>
          <p>
            Browse available titles, place instant orders with our secure
            payment gateway, and track your customer orders seamlessly by
            signing into your dashboard.
          </p>
          <div class="hero-actions">
            <a href="book-catalogue.php" class="btn-primary"
              ><i class="fa-solid fa-book-open"></i> Browse All Books</a
            >
          </div>
        </div>

        <div class="hero-visual">
          <div class="hero-card-stack">
            <img
              src="assets/shadows_eldoria.png"
              alt="Shadows of Eldoria"
              class="hero-card card-1"
            />
            <img
              src="assets/mastering_web.png"
              alt="Mastering Web Architecture"
              class="hero-card card-2"
            />
            <img
              src="assets/quantum_odyssey.png"
              alt="The Quantum Odyssey"
              class="hero-card card-main"
            />
          </div>
        </div>
      </section>

      <!-- ===================================================================
         USER SECTION 3: Trending Books (DYNAMIC PHP INTEGRATION)
         =================================================================== -->
      <section id="trending" class="content-section">
        <div class="section-header">
          <h2>
            <i class="fa-solid fa-fire" style="color: var(--accent-gold)"></i>
            Trending Books
          </h2>
        </div>

        <div class="books-grid">
          <?php if (count($trendingBooks) > 0): ?>
            <?php foreach ($trendingBooks as $book): ?>
              <article
                class="book-card"
                data-category="<?= htmlspecialchars(strtolower($book['category'])) ?>"
                data-title="<?= htmlspecialchars(strtolower($book['title'])) ?>"
                data-author="<?= htmlspecialchars(strtolower($book['author'])) ?>"
              >
                <div class="book-cover-wrap">
                  <a href="book-details.php?id=<?= $book['id'] ?>">
                    <img
                      src="assets/<?= htmlspecialchars($book['cover_image']) ?>"
                      alt="<?= htmlspecialchars($book['title']) ?>"
                      class="book-cover"
                    />
                  </a>
                  <!-- Added a Trending badge to replace the stock badge here -->
                  <div class="book-category-tag"><span class="badge badge-gold">Trending</span></div>
                </div>
                <div class="book-info">
                  <span class="category-label"><?= htmlspecialchars($book['category']) ?></span>
                  <a href="book-details.php?id=<?= $book['id'] ?>" class="book-title-link">
                    <h3 class="book-title"><?= htmlspecialchars($book['title']) ?></h3>
                  </a>
                  <p class="book-author">by <?= htmlspecialchars($book['author']) ?></p>
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
             <p style="grid-column: 1 / -1; text-align: center; padding: 2rem;">No trending books right now.</p>
          <?php endif; ?>
        </div>
      </section>

      <!-- ===================================================================
         USER SECTION 4: BOOK CATALOGUE (DYNAMIC PHP INTEGRATION)
         =================================================================== -->
      <section id="catalogue" class="content-section">
        <div class="section-header">
          <h2>
            <i class="fa-solid fa-book" style="color: var(--accent-gold)"></i>
            Book Catalogue
          </h2>
          <p>Browse all available titles in store</p>
        </div>

        <!-- Search & Filter Controls -->
        <!-- ACTION adjusted to point to index.php#catalogue to scroll down automatically -->
        <form
          class="filter-section"
          action="index.php#catalogue"
          method="GET"
        >
          <div class="filter-top-row">
            <div class="search-box">
              <i class="fa-solid fa-magnifying-glass"></i>
              <input
                type="text"
                class="search-input"
                id="catalogueSearch"
                placeholder="Filter titles by name or author..."
              />
            </div>
            
            <!-- Added name="category" and onchange submit -->
            <select
              class="sort-select"
              name="category"
              id="categorySelect"
              title="Filter by Category"
              onchange="this.form.submit()"
            >
              <option value="all" <?= $selectedCategory === 'all' ? 'selected' : '' ?>>All Categories</option>
              <option value="Educational" <?= $selectedCategory === 'Educational' ? 'selected' : '' ?>>Educational</option>
              <option value="Fiction" <?= $selectedCategory === 'Fiction' ? 'selected' : '' ?>>Fiction</option>
            </select>
          </div>
        </form>

        <!-- Dynamic Book Cards Grid -->
        <div class="books-grid" id="mainCatalogueGrid">
          <?php if (count($allBooks) > 0): ?>
            <?php foreach ($allBooks as $book): ?>
              <article
                class="book-card"
                data-category="<?= htmlspecialchars(strtolower($book['category'])) ?>"
                data-title="<?= htmlspecialchars(strtolower($book['title'])) ?>"
                data-author="<?= htmlspecialchars(strtolower($book['author'])) ?>"
              >
                <div class="book-cover-wrap">
                  <a href="book-details.php?id=<?= $book['id'] ?>">
                    <img
                      src="assets/<?= htmlspecialchars($book['cover_image']) ?>"
                      alt="<?= htmlspecialchars($book['title']) ?>"
                      class="book-cover"
                    />
                  </a>
                </div>
                <div class="book-info">
                  <span class="category-label"><?= htmlspecialchars($book['category']) ?></span>
                  <a href="book-details.php?id=<?= $book['id'] ?>" class="book-title-link">
                    <h3 class="book-title"><?= htmlspecialchars($book['title']) ?></h3>
                  </a>
                  <p class="book-author">by <?= htmlspecialchars($book['author']) ?></p>
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
    </main>

    <footer
        style="
        text-align: center;
        padding: 2rem 1rem;
        color: var(--text-muted);
        font-size: 0.85rem;
        border-top: 1px solid var(--border-subtle);
        margin-top: 4rem;
      "
    >
      &copy; 2026 Aetheria Books. Traditional Single Page Book Store
      Application.
    </footer>
    <script src="app.js"></script>
  </body>
</html>