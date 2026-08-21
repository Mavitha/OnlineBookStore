<?php
session_start();
require_once '../backend/php/connection.php';

$stmt = $pdo->query("SELECT * FROM books ORDER BY id DESC LIMIT 4");
$popular_books = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT * FROM books ORDER BY price DESC LIMIT 4");
$trending_books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lumina Books — Home</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..800;1,400..800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body>

  <!-- ================= TOP ANNOUNCEMENT BANNER ================= -->
  <div class="top-announcement">
    <p>✨ Complimentary worldwide shipping on all orders over $35 | Use code <strong>LUMINA20</strong> for 20% off</p>
  </div>

  <!-- ================= SITE HEADER ================= -->
  <header class="site-header" id="siteHeader"><header class="site-header" id="siteHeader">
    <div class="header-main container">
      
      <!-- Left: Hamburger Menu Icon & Brand Logo -->
      <div class="header-left">
        <button id="hamburgerBtn" class="icon-btn hamburger-btn" aria-label="Open Categories Menu" title="Browse Categories">
          <span class="hamburger-line"></span>
          <span class="hamburger-line"></span>
          <span class="hamburger-line"></span>
        </button>
        
        <!-- Brand / Logo -->
        <a href="index.html" class="brand-logo" id="logoLink">
          <div class="logo-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
              <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
              <line x1="12" y1="6" x2="16" y2="6"></line>
              <line x1="12" y1="10" x2="16" y2="10"></line>
            </svg>
          </div>
          <div class="brand-text">
            <span class="brand-name">Lumina</span>
            <span class="brand-sub">Books & Editions</span>
          </div>
        </a>
      </div>

      <!-- Navigation Links -->
      <nav class="desktop-nav">
        <a href="index.php" class="nav-link" data-view="home">Home</a>
        <a href="catalog.html?filter=popular" class="nav-link" data-view="popular">Popular</a>
        <a href="catalog.html?filter=trending" class="nav-link" data-view="trending">Trending</a>
        <a href="catalog.html" class="nav-link" data-view="browse">Browse All</a>
      </nav>

      <!-- Right Header Actions -->
      <div class="header-right">
        
        <!-- Cart Quick Button -->
        <button id="quickCartBtn" onclick="window.location.href='cart.html'" class="icon-btn cart-quick-btn" title="Open Shopping Cart" aria-label="Shopping Cart">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
          </svg>
          <span class="cart-badge-count" id="cartBadgeCount">0</span>
        </button>

        <!-- Profile Avatar Button with Dropdown -->
        <div class="profile-dropdown-wrapper">
          <button id="profileBtn" class="profile-avatar-btn" aria-label="User Account Menu" title="My Account">
            <div class="avatar-circle" id="avatarDisplay">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
            </div>
          </button>

          <!-- Hidden Profile Menu Dropdown -->
          <div class="profile-dropdown" id="profileDropdown">
            <div class="dropdown-header">
              <p class="user-greeting" id="userGreeting">Welcome, Reader</p>
              <span class="user-status" id="userStatus">Guest Account</span>
            </div>
            <div class="dropdown-divider"></div>
            <ul class="dropdown-list">
              <li>
                <button class="dropdown-item" id="menuLoginBtn">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                    <polyline points="10 17 15 12 10 7"></polyline>
                    <line x1="15" y1="12" x2="3" y2="12"></line>
                  </svg>
                  <span id="authActionText">Login / Register</span>
                </button>
              </li>
              <li>
                <button class="dropdown-item" id="menuCartBtn" onclick="window.location.href='cart.html'">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                  </svg>
                  <span>Shopping Cart</span>
                  <span class="menu-pill" id="menuCartCount">0</span>
                </button>
              </li>
              <li>
                <button class="dropdown-item" id="menuOrdersBtn" onclick="window.location.href='user_dashboard.html'">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <polyline points="21 8 21 21 3 21 3 8"></polyline>
                    <rect x="1" y="3" width="22" height="5"></rect>
                    <line x1="10" y1="12" x2="14" y2="12"></line>
                  </svg>
                  <span>My Orders</span>
                  <span class="menu-pill pill-secondary" id="orderCountPill">2</span>
                </button>
              </li>
              <li>
                <button class="dropdown-item" id="menuWishlistBtn">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                  </svg>
                  <span>Saved Wishlist</span>
                </button>
              </li>
            </ul>
          </div>
        </div>

      </div>
    </div>

    <!-- Below Header Search & Multi-Filter Bar -->
    <div class="header-subsearch">
      <div class="container">
        <div class="search-filter-composite">
          
          <!-- Search Input -->
          <div class="search-input-box">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="11" cy="11" r="8"></circle>
              <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" id="globalSearchInput" placeholder="Search by title, author, topic, or keyword..." autocomplete="off">
            <button id="clearSearchBtn" class="clear-search-btn" title="Clear Search" style="display:none;">&times;</button>
          </div>

          <!-- Category Filter Dropdown -->
          <div class="filter-box">
            <label for="categoryFilter" class="filter-label">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="select-icon">
                <path d="M4 6h16M4 12h10M4 18h6"></path>
              </svg>
              Category:
            </label>
            <select id="categoryFilter" class="filter-select">
              <option value="all">All Categories</option>
              <option value="Fiction">Fiction</option>
              <option value="Science">Science</option>
              <option value="Mystery">Mystery</option>
              <option value="History">History</option>
              <option value="Fantasy">Fantasy</option>
              <option value="Technology">Technology</option>
              <option value="Philosophy">Philosophy</option>
              <option value="Biography">Biography</option>
            </select>
          </div>

          <!-- Author Filter Dropdown -->
          <div class="filter-box">
            <label for="authorFilter" class="filter-label">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="select-icon">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
              Author:
            </label>
            <select id="authorFilter" class="filter-select">
              <option value="all">All Authors</option>
              <!-- Populated dynamically by JS -->
            </select>
          </div>

          <!-- Sort Filter Dropdown -->
          <div class="filter-box">
            <label for="sortFilter" class="filter-label">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="select-icon">
                <line x1="18" y1="20" x2="18" y2="10"></line>
                <line x1="12" y1="20" x2="12" y2="4"></line>
                <line x1="6" y1="20" x2="6" y2="14"></line>
              </svg>
              Sort:
            </label>
            <select id="sortFilter" class="filter-select">
              <option value="popular">Popularity</option>
              <option value="rating">Top Rated</option>
              <option value="price-low">Price: Low to High</option>
              <option value="price-high">Price: High to Low</option>
              <option value="title-az">Title: A to Z</option>
            </select>
          </div>

        </div>
      </div>
    </div>
  </header>

  <!-- ================= CATEGORY SLIDE-OVER DRAWER ================= -->
  <div class="drawer-backdrop" id="drawerBackdrop"></div>
  <aside class="category-drawer" id="categoryDrawer" aria-label="Book Categories Menu">
    <div class="drawer-header">
      <div class="drawer-title-group">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="drawer-icon">
          <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
          <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
        </svg>
        <h3>Book Categories</h3>
      </div>
      <button id="closeDrawerBtn" class="close-btn" aria-label="Close Categories Menu">&times;</button>
    </div>
    
    <div class="drawer-body">
      <p class="drawer-lead">Explore our curated collection organized across literature and sciences.</p>
      <div class="category-list" id="categoryDrawerList">
        <!-- Generated by JavaScript with category counts and icons -->
      </div>
    </div>

    <div class="drawer-footer">
      <a href="#browse" class="btn btn-outline btn-block" id="drawerBrowseAllBtn">View Complete Catalog</a>
    </div>
  </aside>

  
  <main class="app-main-content">
<!-- ================= VIEW 1: HOME VIEW ================= -->
    <section id="view-home" class="app-view active">
      
      <!-- Hero Section -->
      <section class="hero-section">
        <div class="container hero-container">
          <div class="hero-content">
            <span class="hero-kicker">Curated Collection 2026</span>
            <h1 class="hero-title">Words that breathe. <br><em>Stories that linger.</em></h1>
            <p class="hero-description">
              Discover profound philosophical texts, groundbreaking scientific explorations, and compelling modern fiction. Elegantly bound, thoughtfully curated.
            </p>
            <div class="hero-actions">
              <a href="#browse" class="btn btn-primary">Browse Full Library</a>
              <button class="btn btn-outline" id="heroExploreBtn">Explore Categories</button>
            </div>
            
            <!-- Category Pills Quick Jump -->
            <div class="hero-quick-tags">
              <span class="tags-label">Popular Topics:</span>
              <button class="tag-pill" data-cat="Fiction">Fiction</button>
              <button class="tag-pill" data-cat="Science">Science</button>
              <button class="tag-pill" data-cat="Philosophy">Philosophy</button>
              <button class="tag-pill" data-cat="Technology">Technology</button>
              <button class="tag-pill" data-cat="Mystery">Mystery</button>
            </div>
          </div>
          
          <div class="hero-showcase">
            <div class="featured-book-card" id="heroFeaturedBook">
              <!-- Dynamically populated hero spotlight -->
            </div>
          </div>
        </div>
      </section>

      <!-- Active Search/Filter Indicator if filters applied on Home -->
      <div class="container" id="homeFilterNotice" style="display: none;">
        <div class="filter-active-bar">
          <span id="homeFilterNoticeText">Showing filtered results</span>
          <button class="btn btn-text-sm" id="resetHomeFiltersBtn">Reset Filters</button>
        </div>
      </div>

      <!-- SECTION 1: POPULAR BOOKS (Row with horizontal scroll) -->
      <section class="book-section popular-section" id="homePopularSection">
        <div class="container">
          <div class="section-header">
            <div class="section-title-wrap">
              <span class="section-badge">Reader Favorites</span>
              <h2 class="section-title">Popular Books</h2>
              <p class="section-subtitle">The most beloved titles cherished by our literary community.</p>
            </div>
            <a href="#popular" class="view-more-link" title="See all popular books">
              <span>View More</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </a>
          </div>

          <!-- Horizontal Scroll Row with Controls -->
          <div class="books-row-wrapper">
            <button class="row-scroll-btn prev-btn" id="scrollPopularLeft" aria-label="Scroll left">&#8249;</button>
            <div class="books-scroll-row" id="homePopularGrid">

            <article class="book-card">
              <div class="book-cover-wrap">
                <span class="book-badge badge-popular">Bestseller</span>
                <img class="book-cover-img" src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=600&q=80" alt="Book Title">
              </div>
              <div class="book-info">
                <span class="book-category">Philosophy</span>
                <h3 class="book-title">The Architecture of Solitude</h3>
                <p class="book-author">by Julian Vance</p>
                <div class="book-rating-row">
                  <svg class="star-icon" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                  <span>4.9</span>
                  <span style="color:var(--text-muted);font-weight:400;">(312)</span>
                </div>
                <div class="book-card-bottom">
                  <span class="book-price">$24.50</span>
                  <button class="add-cart-mini-btn" title="Add to Bag">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <circle cx="9" cy="21" r="1"></circle>
                      <circle cx="20" cy="21" r="1"></circle>
                      <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                  </button>
                </div>
              </div>
            </article>

            <article class="book-card">
              <div class="book-cover-wrap">
                <span class="book-badge badge-popular">Bestseller</span>
                <img class="book-cover-img" src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=600&q=80" alt="Book Title">
              </div>
              <div class="book-info">
                <span class="book-category">Philosophy</span>
                <h3 class="book-title">The Architecture of Solitude</h3>
                <p class="book-author">by Julian Vance</p>
                <div class="book-rating-row">
                  <svg class="star-icon" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                  <span>4.9</span>
                  <span style="color:var(--text-muted);font-weight:400;">(312)</span>
                </div>
                <div class="book-card-bottom">
                  <span class="book-price">$24.50</span>
                  <button class="add-cart-mini-btn" title="Add to Bag">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <circle cx="9" cy="21" r="1"></circle>
                      <circle cx="20" cy="21" r="1"></circle>
                      <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                  </button>
                </div>
              </div>
            </article>

            <article class="book-card">
              <div class="book-cover-wrap">
                <span class="book-badge badge-popular">Bestseller</span>
                <img class="book-cover-img" src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=600&q=80" alt="Book Title">
              </div>
              <div class="book-info">
                <span class="book-category">Philosophy</span>
                <h3 class="book-title">The Architecture of Solitude</h3>
                <p class="book-author">by Julian Vance</p>
                <div class="book-rating-row">
                  <svg class="star-icon" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                  <span>4.9</span>
                  <span style="color:var(--text-muted);font-weight:400;">(312)</span>
                </div>
                <div class="book-card-bottom">
                  <span class="book-price">$24.50</span>
                  <button class="add-cart-mini-btn" title="Add to Bag">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <circle cx="9" cy="21" r="1"></circle>
                      <circle cx="20" cy="21" r="1"></circle>
                      <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                  </button>
                </div>
              </div>
            </article>

            <article class="book-card">
              <div class="book-cover-wrap">
                <span class="book-badge badge-popular">Bestseller</span>
                <img class="book-cover-img" src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=600&q=80" alt="Book Title">
              </div>
              <div class="book-info">
                <span class="book-category">Philosophy</span>
                <h3 class="book-title">The Architecture of Solitude</h3>
                <p class="book-author">by Julian Vance</p>
                <div class="book-rating-row">
                  <svg class="star-icon" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                  <span>4.9</span>
                  <span style="color:var(--text-muted);font-weight:400;">(312)</span>
                </div>
                <div class="book-card-bottom">
                  <span class="book-price">$24.50</span>
                  <button class="add-cart-mini-btn" title="Add to Bag">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <circle cx="9" cy="21" r="1"></circle>
                      <circle cx="20" cy="21" r="1"></circle>
                      <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                  </button>
                </div>
              </div>
            </article>

              <!-- Rendered by JS -->
            </div>
            <button class="row-scroll-btn next-btn" id="scrollPopularRight" aria-label="Scroll right">&#8250;</button>
          </div>
        </div>
      </section>

      <!-- SECTION 2: TRENDING BOOKS (Row with horizontal scroll) -->
      <section class="book-section trending-section" id="homeTrendingSection">
        <div class="container">
          <div class="section-header">
            <div class="section-title-wrap">
              <span class="section-badge badge-accent">On The Rise</span>
              <h2 class="section-title">Trending This Month</h2>
              <p class="section-subtitle">Fast-climbing titles, viral book club picks, and recent award winners.</p>
            </div>
            <a href="#trending" class="view-more-link" title="See all trending books">
              <span>View More</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </a>
          </div>

          <!-- Horizontal Scroll Row with Controls -->
          <div class="books-row-wrapper">
            <button class="row-scroll-btn prev-btn" id="scrollTrendingLeft" aria-label="Scroll left">&#8249;</button>
            <div class="books-scroll-row" id="homeTrendingGrid">

            <article class="book-card">
              <div class="book-cover-wrap">
                <span class="book-badge badge-popular">Bestseller</span>
                <img class="book-cover-img" src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=600&q=80" alt="Book Title">
              </div>
              <div class="book-info">
                <span class="book-category">Philosophy</span>
                <h3 class="book-title">The Architecture of Solitude</h3>
                <p class="book-author">by Julian Vance</p>
                <div class="book-rating-row">
                  <svg class="star-icon" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                  <span>4.9</span>
                  <span style="color:var(--text-muted);font-weight:400;">(312)</span>
                </div>
                <div class="book-card-bottom">
                  <span class="book-price">$24.50</span>
                  <button class="add-cart-mini-btn" title="Add to Bag">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <circle cx="9" cy="21" r="1"></circle>
                      <circle cx="20" cy="21" r="1"></circle>
                      <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                  </button>
                </div>
              </div>
            </article>

            <article class="book-card">
              <div class="book-cover-wrap">
                <span class="book-badge badge-popular">Bestseller</span>
                <img class="book-cover-img" src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=600&q=80" alt="Book Title">
              </div>
              <div class="book-info">
                <span class="book-category">Philosophy</span>
                <h3 class="book-title">The Architecture of Solitude</h3>
                <p class="book-author">by Julian Vance</p>
                <div class="book-rating-row">
                  <svg class="star-icon" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                  <span>4.9</span>
                  <span style="color:var(--text-muted);font-weight:400;">(312)</span>
                </div>
                <div class="book-card-bottom">
                  <span class="book-price">$24.50</span>
                  <button class="add-cart-mini-btn" title="Add to Bag">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <circle cx="9" cy="21" r="1"></circle>
                      <circle cx="20" cy="21" r="1"></circle>
                      <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                  </button>
                </div>
              </div>
            </article>

            <article class="book-card">
              <div class="book-cover-wrap">
                <span class="book-badge badge-popular">Bestseller</span>
                <img class="book-cover-img" src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=600&q=80" alt="Book Title">
              </div>
              <div class="book-info">
                <span class="book-category">Philosophy</span>
                <h3 class="book-title">The Architecture of Solitude</h3>
                <p class="book-author">by Julian Vance</p>
                <div class="book-rating-row">
                  <svg class="star-icon" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                  <span>4.9</span>
                  <span style="color:var(--text-muted);font-weight:400;">(312)</span>
                </div>
                <div class="book-card-bottom">
                  <span class="book-price">$24.50</span>
                  <button class="add-cart-mini-btn" title="Add to Bag">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <circle cx="9" cy="21" r="1"></circle>
                      <circle cx="20" cy="21" r="1"></circle>
                      <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                  </button>
                </div>
              </div>
            </article>

            <article class="book-card">
              <div class="book-cover-wrap">
                <span class="book-badge badge-popular">Bestseller</span>
                <img class="book-cover-img" src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=600&q=80" alt="Book Title">
              </div>
              <div class="book-info">
                <span class="book-category">Philosophy</span>
                <h3 class="book-title">The Architecture of Solitude</h3>
                <p class="book-author">by Julian Vance</p>
                <div class="book-rating-row">
                  <svg class="star-icon" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                  <span>4.9</span>
                  <span style="color:var(--text-muted);font-weight:400;">(312)</span>
                </div>
                <div class="book-card-bottom">
                  <span class="book-price">$24.50</span>
                  <button class="add-cart-mini-btn" title="Add to Bag">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <circle cx="9" cy="21" r="1"></circle>
                      <circle cx="20" cy="21" r="1"></circle>
                      <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                  </button>
                </div>
              </div>
            </article>

              <!-- Rendered by JS -->
            </div>
            <button class="row-scroll-btn next-btn" id="scrollTrendingRight" aria-label="Scroll right">&#8250;</button>
          </div>
        </div>
      </section>

      <!-- SECTION 3: BROWSE BOOKS -->
      <section class="book-section browse-section" id="homeBrowseSection">
        <div class="container">
          <div class="section-header">
            <div class="section-title-wrap">
              <span class="section-badge">Full Library</span>
              <h2 class="section-title">Browse Books</h2>
              <p class="section-subtitle">Explore our expansive catalogue across genres, authors, and disciplines.</p>
            </div>
            <a href="#browse" class="view-more-link" title="Full catalogue view">
              <span>Full Catalog</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </a>
          </div>

          <!-- Quick category tabs for Browse -->
          <div class="category-tabs" id="browseCategoryTabs">
            <!-- Rendered by JS -->
          </div>

          <!-- Browse Books Grid -->
          <div class="books-grid" id="homeBrowseGrid">

            <article class="book-card">
              <div class="book-cover-wrap">
                <span class="book-badge badge-popular">Bestseller</span>
                <img class="book-cover-img" src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=600&q=80" alt="Book Title">
              </div>
              <div class="book-info">
                <span class="book-category">Philosophy</span>
                <h3 class="book-title">The Architecture of Solitude</h3>
                <p class="book-author">by Julian Vance</p>
                <div class="book-rating-row">
                  <svg class="star-icon" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                  <span>4.9</span>
                  <span style="color:var(--text-muted);font-weight:400;">(312)</span>
                </div>
                <div class="book-card-bottom">
                  <span class="book-price">$24.50</span>
                  <button class="add-cart-mini-btn" title="Add to Bag">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <circle cx="9" cy="21" r="1"></circle>
                      <circle cx="20" cy="21" r="1"></circle>
                      <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                  </button>
                </div>
              </div>
            </article>

            <article class="book-card">
              <div class="book-cover-wrap">
                <span class="book-badge badge-popular">Bestseller</span>
                <img class="book-cover-img" src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=600&q=80" alt="Book Title">
              </div>
              <div class="book-info">
                <span class="book-category">Philosophy</span>
                <h3 class="book-title">The Architecture of Solitude</h3>
                <p class="book-author">by Julian Vance</p>
                <div class="book-rating-row">
                  <svg class="star-icon" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                  <span>4.9</span>
                  <span style="color:var(--text-muted);font-weight:400;">(312)</span>
                </div>
                <div class="book-card-bottom">
                  <span class="book-price">$24.50</span>
                  <button class="add-cart-mini-btn" title="Add to Bag">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <circle cx="9" cy="21" r="1"></circle>
                      <circle cx="20" cy="21" r="1"></circle>
                      <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                  </button>
                </div>
              </div>
            </article>

            <article class="book-card">
              <div class="book-cover-wrap">
                <span class="book-badge badge-popular">Bestseller</span>
                <img class="book-cover-img" src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=600&q=80" alt="Book Title">
              </div>
              <div class="book-info">
                <span class="book-category">Philosophy</span>
                <h3 class="book-title">The Architecture of Solitude</h3>
                <p class="book-author">by Julian Vance</p>
                <div class="book-rating-row">
                  <svg class="star-icon" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                  <span>4.9</span>
                  <span style="color:var(--text-muted);font-weight:400;">(312)</span>
                </div>
                <div class="book-card-bottom">
                  <span class="book-price">$24.50</span>
                  <button class="add-cart-mini-btn" title="Add to Bag">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <circle cx="9" cy="21" r="1"></circle>
                      <circle cx="20" cy="21" r="1"></circle>
                      <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                  </button>
                </div>
              </div>
            </article>

            <article class="book-card">
              <div class="book-cover-wrap">
                <span class="book-badge badge-popular">Bestseller</span>
                <img class="book-cover-img" src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=600&q=80" alt="Book Title">
              </div>
              <div class="book-info">
                <span class="book-category">Philosophy</span>
                <h3 class="book-title">The Architecture of Solitude</h3>
                <p class="book-author">by Julian Vance</p>
                <div class="book-rating-row">
                  <svg class="star-icon" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                  <span>4.9</span>
                  <span style="color:var(--text-muted);font-weight:400;">(312)</span>
                </div>
                <div class="book-card-bottom">
                  <span class="book-price">$24.50</span>
                  <button class="add-cart-mini-btn" title="Add to Bag">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <circle cx="9" cy="21" r="1"></circle>
                      <circle cx="20" cy="21" r="1"></circle>
                      <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                  </button>
                </div>
              </div>
            </article>

            <article class="book-card">
              <div class="book-cover-wrap">
                <span class="book-badge badge-popular">Bestseller</span>
                <img class="book-cover-img" src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=600&q=80" alt="Book Title">
              </div>
              <div class="book-info">
                <span class="book-category">Philosophy</span>
                <h3 class="book-title">The Architecture of Solitude</h3>
                <p class="book-author">by Julian Vance</p>
                <div class="book-rating-row">
                  <svg class="star-icon" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                  <span>4.9</span>
                  <span style="color:var(--text-muted);font-weight:400;">(312)</span>
                </div>
                <div class="book-card-bottom">
                  <span class="book-price">$24.50</span>
                  <button class="add-cart-mini-btn" title="Add to Bag">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <circle cx="9" cy="21" r="1"></circle>
                      <circle cx="20" cy="21" r="1"></circle>
                      <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                  </button>
                </div>
              </div>
            </article>

            <article class="book-card">
              <div class="book-cover-wrap">
                <span class="book-badge badge-popular">Bestseller</span>
                <img class="book-cover-img" src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=600&q=80" alt="Book Title">
              </div>
              <div class="book-info">
                <span class="book-category">Philosophy</span>
                <h3 class="book-title">The Architecture of Solitude</h3>
                <p class="book-author">by Julian Vance</p>
                <div class="book-rating-row">
                  <svg class="star-icon" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                  <span>4.9</span>
                  <span style="color:var(--text-muted);font-weight:400;">(312)</span>
                </div>
                <div class="book-card-bottom">
                  <span class="book-price">$24.50</span>
                  <button class="add-cart-mini-btn" title="Add to Bag">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <circle cx="9" cy="21" r="1"></circle>
                      <circle cx="20" cy="21" r="1"></circle>
                      <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                  </button>
                </div>
              </div>
            </article>

            <article class="book-card">
              <div class="book-cover-wrap">
                <span class="book-badge badge-popular">Bestseller</span>
                <img class="book-cover-img" src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=600&q=80" alt="Book Title">
              </div>
              <div class="book-info">
                <span class="book-category">Philosophy</span>
                <h3 class="book-title">The Architecture of Solitude</h3>
                <p class="book-author">by Julian Vance</p>
                <div class="book-rating-row">
                  <svg class="star-icon" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                  <span>4.9</span>
                  <span style="color:var(--text-muted);font-weight:400;">(312)</span>
                </div>
                <div class="book-card-bottom">
                  <span class="book-price">$24.50</span>
                  <button class="add-cart-mini-btn" title="Add to Bag">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <circle cx="9" cy="21" r="1"></circle>
                      <circle cx="20" cy="21" r="1"></circle>
                      <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                  </button>
                </div>
              </div>
            </article>

            <article class="book-card">
              <div class="book-cover-wrap">
                <span class="book-badge badge-popular">Bestseller</span>
                <img class="book-cover-img" src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=600&q=80" alt="Book Title">
              </div>
              <div class="book-info">
                <span class="book-category">Philosophy</span>
                <h3 class="book-title">The Architecture of Solitude</h3>
                <p class="book-author">by Julian Vance</p>
                <div class="book-rating-row">
                  <svg class="star-icon" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                  <span>4.9</span>
                  <span style="color:var(--text-muted);font-weight:400;">(312)</span>
                </div>
                <div class="book-card-bottom">
                  <span class="book-price">$24.50</span>
                  <button class="add-cart-mini-btn" title="Add to Bag">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <circle cx="9" cy="21" r="1"></circle>
                      <circle cx="20" cy="21" r="1"></circle>
                      <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                  </button>
                </div>
              </div>
            </article>

            <!-- Rendered by JS -->
          </div>

          <!-- Pagination Bar for Browse Section -->
          <div class="pagination-container" id="homeBrowsePagination">
            <!-- Rendered by JS -->
          </div>

        </div>
      </section>

    
    </section>
  </main>
<!-- ================= FOOTER ================= -->
  <footer class="site-footer">
    <div class="container footer-content">
      <div class="footer-col brand-col">
        <div class="brand-logo footer-logo">
          <div class="logo-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
              <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
            </svg>
          </div>
          <span class="brand-name">Lumina Books</span>
        </div>
        <p class="footer-desc">A curated haven for avid readers, thinkers, and collectors. Designed with care, clarity, and minimalism.</p>
      </div>

      <div class="footer-col">
        <h4 class="footer-heading">Categories</h4>
        <ul class="footer-links">
          <li><a href="#category/Fiction">Fiction</a></li>
          <li><a href="#category/Science">Science</a></li>
          <li><a href="#category/Philosophy">Philosophy</a></li>
          <li><a href="#category/Technology">Technology</a></li>
          <li><a href="#category/Mystery">Mystery</a></li>
          <li><a href="#category/History">History</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4 class="footer-heading">Navigation</h4>
        <ul class="footer-links">
          <li><a href="#home">Home</a></li>
          <li><a href="#popular">Popular Books</a></li>
          <li><a href="#trending">Trending Titles</a></li>
          <li><a href="#browse">Complete Catalog</a></li>
          <li><button class="footer-btn-link" id="footerOrdersLink">My Orders</button></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4 class="footer-heading">Newsletter</h4>
        <p class="footer-subtext">Receive monthly reading recommendations and collector editions.</p>
        <form class="newsletter-form" id="newsletterForm" onsubmit="event.preventDefault(); window.app.handleNewsletter(this);">
          <input type="email" placeholder="Enter your email address" required>
          <button type="submit" class="btn btn-primary btn-sm">Subscribe</button>
        </form>
      </div>
    </div>

    <div class="footer-bottom">
      <div class="container footer-bottom-inner">
        <p>&copy; 2026 Lumina Books. Minimalist Light Edition. All rights reserved.</p>
        <div class="footer-badges">
          <span>🌿 Sustainable Packaging</span>
          <span>⚡ Fast Delivery</span>
          <span>🔒 Secure Checkout</span>
        </div>
      </div>
    </div>
  </footer>

  <!-- ================= BOOK DETAILS MODAL ================= -->
  <div class="modal-backdrop" id="bookModalBackdrop">
    <div class="modal-card book-modal-card" id="bookModalCard" role="dialog" aria-modal="true">
      <button class="modal-close-btn" id="closeBookModalBtn" aria-label="Close Book Details">&times;</button>
      <div class="book-modal-content" id="bookModalBody">
        <!-- Rendered by JS -->
      </div>
    </div>
  </div>

  <!-- ================= SHOPPING CART DRAWER ================= -->
  <div class="cart-drawer-backdrop" id="cartDrawerBackdrop"></div>
  <aside class="cart-drawer" id="cartDrawer" aria-label="Shopping Cart Drawer">
    <div class="cart-drawer-header">
      <div class="cart-header-title">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="9" cy="21" r="1"></circle>
          <circle cx="20" cy="21" r="1"></circle>
          <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
        </svg>
        <h3>Your Shopping Bag</h3>
        <span class="cart-count-badge" id="cartHeaderCount">0 items</span>
      </div>
      <button id="closeCartBtn" class="close-btn" aria-label="Close Shopping Bag">&times;</button>
    </div>

    <div class="cart-drawer-body" id="cartDrawerBody">
      <!-- Rendered by JS: Cart Items or Empty State -->
    </div>

    <div class="cart-drawer-footer" id="cartDrawerFooter">
      <div class="promo-box">
        <input type="text" id="promoCodeInput" placeholder="Promo code (e.g. LUMINA20)">
        <button id="applyPromoBtn" class="btn btn-outline btn-sm">Apply</button>
      </div>

      <div class="cart-summary-lines">
        <div class="summary-line">
          <span>Subtotal</span>
          <span id="cartSubtotal">$0.00</span>
        </div>
        <div class="summary-line" id="discountLine" style="display: none;">
          <span class="text-accent">Discount (20%)</span>
          <span class="text-accent" id="cartDiscount">-$0.00</span>
        </div>
        <div class="summary-line">
          <span>Estimated Shipping</span>
          <span id="cartShipping">Free</span>
        </div>
        <div class="summary-line summary-total">
          <span>Total</span>
          <span id="cartTotal">$0.00</span>
        </div>
      </div>

      <button id="checkoutBtn" class="btn btn-primary btn-block checkout-btn">
        <span>Proceed to Checkout</span>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="5" y1="12" x2="19" y2="12"></line>
          <polyline points="12 5 19 12 12 19"></polyline>
        </svg>
      </button>
    </div>
  </aside>

  <!-- ================= AUTH MODAL (LOGIN / REGISTER) ================= -->
  <div class="modal-backdrop" id="authModalBackdrop">
    <div class="modal-card auth-modal-card" id="authModalCard">
      <button class="modal-close-btn" id="closeAuthModalBtn" aria-label="Close Auth Dialog">&times;</button>
      
      <div class="auth-tabs">
        <button class="auth-tab active" id="tabLoginBtn">Sign In</button>
        <button class="auth-tab" id="tabRegisterBtn">Create Account</button>
      </div>

      <div class="auth-body">
        <!-- Sign In Form -->
        <form id="loginForm" class="auth-form active">
          <div class="form-group">
            <label for="loginEmail">Email Address</label>
            <input type="email" id="loginEmail" placeholder="reader@lumina.com" required value="reader@lumina.com">
          </div>
          <div class="form-group">
            <label for="loginPassword">Password</label>
            <input type="password" id="loginPassword" placeholder="••••••••" required value="password123">
          </div>
          <div class="form-meta">
            <label class="checkbox-label">
              <input type="checkbox" checked>
              <span>Remember me</span>
            </label>
            <a href="#" class="forgot-pass-link" onclick="event.preventDefault(); window.app.showToast('Password reset link sent to demo email.');">Forgot password?</a>
          </div>
          <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          
          <div class="auth-demo-hint">
            <p>💡 Demo credentials pre-filled. Click <strong>Sign In</strong> to simulate login.</p>
          </div>
        </form>

        <!-- Register Form -->
        <form id="registerForm" class="auth-form">
          <div class="form-group">
            <label for="regName">Full Name</label>
            <input type="text" id="regName" placeholder="Eleanor Vance" required>
          </div>
          <div class="form-group">
            <label for="regEmail">Email Address</label>
            <input type="email" id="regEmail" placeholder="eleanor@example.com" required>
          </div>
          <div class="form-group">
            <label for="regPassword">Create Password</label>
            <input type="password" id="regPassword" placeholder="Min. 8 characters" required>
          </div>
          <button type="submit" class="btn btn-primary btn-block">Create Account</button>
        </form>
      </div>
    </div>
  </div>

  <!-- ================= MY ORDERS MODAL ================= -->
  <div class="modal-backdrop" id="ordersModalBackdrop">
    <div class="modal-card orders-modal-card">
      <button class="modal-close-btn" id="closeOrdersModalBtn" aria-label="Close Orders Dialog">&times;</button>
      <div class="modal-header-strip">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <polyline points="21 8 21 21 3 21 3 8"></polyline>
          <rect x="1" y="3" width="22" height="5"></rect>
          <line x1="10" y1="12" x2="14" y2="12"></line>
        </svg>
        <h3>My Orders & Delivery History</h3>
      </div>
      <div class="orders-modal-body" id="ordersModalList">
        <!-- Rendered by JS -->
      </div>
    </div>
  </div>

  <!-- ================= TOAST NOTIFICATION CONTAINER ================= -->
  <div class="toast-container" id="toastContainer" aria-live="polite"></div>

  <!-- Pure JavaScript Application Script -->
  <script src="js/common.js"></script>
  <script src="js/index.js"></script>
</body>
</html>
