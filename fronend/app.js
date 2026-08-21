/* ==========================================================================
   AETHERIA BOOKS - MAIN APPLICATION SCRIPT
   ========================================================================== */

// 1. Initialize cart from LocalStorage
let cart = JSON.parse(localStorage.getItem('aetheria_cart')) || [];

document.addEventListener('DOMContentLoaded', () => {
  setupCatalogueFilter();
  updateCartBadge();
  renderCartPage();
});

// ==========================================
// CATALOGUE FILTER LOGIC
// ==========================================
function setupCatalogueFilter() {
  const searchInput = document.getElementById('catalogueSearch');
  const categorySelect = document.getElementById('categorySelect');
  const bookCards = document.querySelectorAll('.book-card');

  function filterCards() {
    const q = searchInput ? searchInput.value.toLowerCase().trim() : '';
    const cat = categorySelect ? categorySelect.value.toLowerCase() : 'all';

    bookCards.forEach(card => {
      const title = card.getAttribute('data-title') || '';
      const author = card.getAttribute('data-author') || '';
      const cardCat = card.getAttribute('data-category') || '';

      const matchesSearch = q === '' || title.includes(q) || author.includes(q);
      const matchesCategory = cat === 'all' || cardCat.toLowerCase() === cat;

      if (matchesSearch && matchesCategory) {
        card.style.display = 'flex';
      } else {
        card.style.display = 'none';
      }
    });
  }

  if (searchInput) searchInput.addEventListener('input', filterCards);
  if (categorySelect) categorySelect.addEventListener('change', filterCards);
}

// ==========================================
// CART MANAGEMENT SYSTEM
// ==========================================

// Add Item to Cart (Triggered by your HTML buttons)
function addToCart(id, title, price) {
  const existingItem = cart.find(item => item.id === id);

  if (existingItem) {
    existingItem.quantity += 1;
  } else {
    cart.push({ id: id, title: title, price: parseFloat(price), quantity: 1 });
  }

  localStorage.setItem('aetheria_cart', JSON.stringify(cart));
  alert(`${title} has been added to your cart!`);
  updateCartBadge();
}

// Remove Item from Cart
function removeFromCart(id) {
  cart = cart.filter(item => item.id !== id);
  localStorage.setItem('aetheria_cart', JSON.stringify(cart));
  renderCartPage(); // Refresh the UI
  updateCartBadge();
}

// Update the Cart Notification Badge
function updateCartBadge() {
  const badge = document.getElementById('cartBadgeCount');
  if (badge) {
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    badge.innerText = totalItems;
    badge.style.display = totalItems > 0 ? 'inline-block' : 'none';
  }
}

// Render the Cart Page dynamically
function renderCartPage() {
  const cartContainer = document.getElementById('cart-items-container');
  const cartTotalDisplay = document.getElementById('cart-total-display');
  const hiddenCartInput = document.getElementById('hidden-cart-data');
  const checkoutBtn = document.getElementById('checkout-btn');

  if (!cartContainer) return; // Exit if we aren't on the cart.php page

  cartContainer.innerHTML = ''; // Clear current display
  let grandTotal = 0;

  if (cart.length === 0) {
    cartContainer.innerHTML = '<p style="text-align:center; padding: 2rem;">Your cart is currently empty.</p>';
    cartTotalDisplay.innerText = '$0.00';
    if (checkoutBtn) checkoutBtn.disabled = true;
    if (hiddenCartInput) hiddenCartInput.value = '';
    return;
  }

  if (checkoutBtn) checkoutBtn.disabled = false;

  // Build the cart rows
  cart.forEach(item => {
    const itemTotal = item.price * item.quantity;
    grandTotal += itemTotal;

    const row = document.createElement('div');
    row.style.cssText = "display: flex; justify-content: space-between; align-items: center; padding: 1rem 0; border-bottom: 1px solid var(--border-subtle);";

    row.innerHTML = `
            <div>
                <strong style="color: var(--text-main); font-size: 1.1rem;">${item.title}</strong>
                <div style="font-size: 0.85rem; color: var(--text-muted);">ID: bk_${item.id} | Unit Price: $${item.price.toFixed(2)}</div>
            </div>
            <div style="display: flex; align-items: center; gap: 1rem;">
                <span>Qty: <strong>${item.quantity}</strong></span>
                <span style="color: var(--accent-gold); font-weight: 700; width: 80px; text-align: right;">$${itemTotal.toFixed(2)}</span>
                <button onclick="removeFromCart(${item.id})" class="btn-icon" style="color: var(--accent-red); background: transparent; border: none; cursor: pointer; font-size: 1.2rem;">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        `;
    cartContainer.appendChild(row);
  });

  cartTotalDisplay.innerText = '$' + grandTotal.toFixed(2);

  // Inject the cart data into the hidden form field so PHP can read it upon checkout
  if (hiddenCartInput) {
    hiddenCartInput.value = JSON.stringify(cart);
  }
}