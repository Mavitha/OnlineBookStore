document.addEventListener('DOMContentLoaded', () => {
    // Hamburger Menu
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const categoryDrawer = document.getElementById('categoryDrawer');
    const drawerBackdrop = document.getElementById('drawerBackdrop');
    const closeDrawerBtn = document.getElementById('closeDrawerBtn');

    if (hamburgerBtn && categoryDrawer) {
        hamburgerBtn.addEventListener('click', () => {
            categoryDrawer.classList.add('open');
            drawerBackdrop.classList.add('show');
        });
        const closeDrawer = () => {
            categoryDrawer.classList.remove('open');
            drawerBackdrop.classList.remove('show');
        };
        closeDrawerBtn?.addEventListener('click', closeDrawer);
        drawerBackdrop?.addEventListener('click', closeDrawer);
    }

    // Profile Dropdown
    const profileBtn = document.getElementById('profileBtn');
    const profileDropdown = document.getElementById('profileDropdown');
    
    if (profileBtn && profileDropdown) {
        profileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            profileDropdown.classList.toggle('show');
        });
        document.addEventListener('click', (e) => {
            if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                profileDropdown.classList.remove('show');
            }
        });
    }

    // Modals (Auth, Orders)
    const modals = [
        { id: 'authModal', btnId: 'menuLoginBtn', closeId: 'closeAuthModalBtn' },
        { id: 'ordersModal', btnId: 'menuOrdersBtn', closeId: 'closeOrdersModalBtn' },
        { id: 'bookModal', btnId: null, closeId: 'closeBookModalBtn' }
    ];

    modals.forEach(m => {
        const modalCard = document.getElementById(`${m.id}Card`);
        const backdrop = document.getElementById(`${m.id}Backdrop`);
        const openBtn = document.getElementById(m.btnId);
        const closeBtn = document.getElementById(m.closeId);

        const openModal = () => {
            if (backdrop) backdrop.classList.add('show');
            if (modalCard) modalCard.classList.add('show');
        };
        const closeModal = () => {
            if (backdrop) backdrop.classList.remove('show');
            if (modalCard) modalCard.classList.remove('show');
        };

        if (openBtn) openBtn.addEventListener('click', openModal);
        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        if (backdrop) {
            backdrop.addEventListener('click', (e) => {
                if (e.target === backdrop) closeModal();
            });
        }
    });

    // Quick Cart Drawer
    const quickCartBtn = document.getElementById('quickCartBtn');
    const cartDrawer = document.getElementById('cartDrawer');
    const cartDrawerBackdrop = document.getElementById('cartDrawerBackdrop');
    const closeCartBtn = document.getElementById('closeCartBtn');

    if (quickCartBtn && cartDrawer) {
        quickCartBtn.addEventListener('click', () => {
            cartDrawer.classList.add('open');
            cartDrawerBackdrop.classList.add('show');
        });
        const closeCart = () => {
            cartDrawer.classList.remove('open');
            cartDrawerBackdrop.classList.remove('show');
        };
        closeCartBtn?.addEventListener('click', closeCart);
        cartDrawerBackdrop?.addEventListener('click', closeCart);
    }
});
