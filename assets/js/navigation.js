const header = document.querySelector('[data-header]');

if (header) {
    const menuToggle = header.querySelector('[data-menu-toggle]');
    const servicesToggle = header.querySelector('.navigation__submenu-toggle');
    const navigation = header.querySelector('[data-navigation]');
    const servicesSubmenu = header.querySelector('#services-submenu');
    const mobileBreakpoint = window.matchMedia('(max-width: 767px)');

    const setServicesSubmenu = (isOpen) => {
        header.classList.toggle('is-submenu-open', isOpen);
        servicesToggle?.setAttribute('aria-expanded', String(isOpen));
    };

    const setMobileMenu = (isOpen) => {
        header.classList.toggle('is-menu-open', isOpen);
        menuToggle?.setAttribute('aria-expanded', String(isOpen));
        menuToggle?.setAttribute('aria-label', isOpen ? 'Закрыть меню' : 'Открыть меню');
        servicesToggle?.setAttribute('aria-expanded', String(isOpen));
    };

    servicesToggle?.addEventListener('click', () => {
        if (mobileBreakpoint.matches) {
            setMobileMenu(true);
            return;
        }

        setServicesSubmenu(!header.classList.contains('is-submenu-open'));
    });

    menuToggle?.addEventListener('click', () => {
        setMobileMenu(!header.classList.contains('is-menu-open'));
    });

    const closeNavigation = () => {
        setServicesSubmenu(false);
        setMobileMenu(false);
    };

    navigation?.addEventListener('click', (event) => {
        if (event.target.closest('.navigation__link')) {
            closeNavigation();
        }
    });

    servicesSubmenu?.addEventListener('click', (event) => {
        if (event.target.closest('.navigation__link')) {
            closeNavigation();
        }
    });

    document.addEventListener('click', (event) => {
        if (!header.contains(event.target)) {
            closeNavigation();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeNavigation();
            menuToggle?.focus();
        }
    });

    mobileBreakpoint.addEventListener('change', closeNavigation);
}
