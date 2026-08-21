# 📚 Aetheria Books — Full-Stack E-Commerce Bookstore

A modern, responsive, and secure single-page bookstore application built with **PHP (PDO)**, **MySQL**, **HTML5/CSS3**, and **Vanilla JavaScript**. 

This application features a dynamic client-side storefront, secure cart management via browser storage, backend SQL filtering, and a robust administrative CRUD portal with password hashing and session-based access control.

---

## 🚀 Key Features

* **Dynamic Storefront (`index.php` & `book-catalogue.php`):**
  * Real-time server-side categorization and SQL filtering.
  * Dedicated **Trending Books** section powered by a dynamic database `trending_score`.
  * Single-book details view (`book-details.php`) populated dynamically via URL parameters (`?id=X`).
* **Interactive Shopping Cart & Checkout (`cart.php` & `app.js`):**
  * Browser-persistent cart management via `localStorage`.
  * Live quantity tracking and price calculation.
  * Seamless conversion of client-side cart data to SQL orders upon secure checkout.
* **Role-Based Authentication (`login.php`):**
  * Secure password hashing (`password_hash`) and verification (`password_verify`).
  * PHP session management for role-based redirection (Admins route to the dashboard, customers route to the store).
* **Administrator CRUD Portal (`admin-dashboard.php`):**
  * **Create:** Add new books to the inventory with custom cover images and trending scores.
  * **Read:** View complete inventory tables and live customer orders.
  * **Update:** Edit existing book details and prices.
  * **Delete:** Remove obsolete book entries with confirmation prompts.

---

## 📁 Project Directory Structure

```text
OnlineBookStore/
│
├── backend/
│   └── php/
│       └── connection.php      # Secure PDO database connection
│
├── fronend/                    # Note: preserves user folder naming convention
│   ├── assets/                 # Book cover images & graphics
│   ├── index.php               # Homepage with Trending & Catalogue sections
│   ├── book-catalogue.php      # Dedicated searchable & filterable catalogue
│   ├── book-details.php        # Dynamic single-book info view
│   ├── cart.php                # Shopping cart & secure checkout processing
│   ├── login.php               # Role-based user authentication portal
│   ├── admin-dashboard.php     # Protected admin CRUD & order management panel
│   ├── user-dashboard.php      # Customer profile & personal order history
│   ├── app.js                  # Frontend cart logic & DOM search/filter engine
│   └── styles.css              # Global custom CSS design system
│
└── README.md