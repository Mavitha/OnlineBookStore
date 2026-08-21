/* ==========================================================================
   AETHERIA BOOKS - TRADITIONAL SINGLE PAGE HELPER
   (Zero DOM Manipulation / Template Generation)
   ========================================================================== */

document.addEventListener('DOMContentLoaded', () => {
  setupCatalogueFilter();
});

// Simple native filter toggling existing HTML cards without DOM manipulation
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
