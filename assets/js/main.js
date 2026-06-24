/* ============================================
   QIMAH WA QUDWAH - Main JavaScript
   ============================================ */

document.addEventListener('DOMContentLoaded', () => {

    // ============ PRELOADER ============
    const preloader = document.getElementById('preloader');
    if (preloader) {
        const hidePreloader = () => preloader.classList.add('hidden');
        window.addEventListener('load', () => setTimeout(hidePreloader, 800));
        setTimeout(hidePreloader, 3000);
    }

    // ============ HEADER SCROLL ============
    const header = document.getElementById('header');
    const backToTop = document.getElementById('backToTop');

    function handleScroll() {
        const scrollY = window.scrollY;

        // Header background
        if (scrollY > 80) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }

        // Back to top button
        if (scrollY > 500) {
            backToTop.classList.add('active');
        } else {
            backToTop.classList.remove('active');
        }

        // Active nav link based on scroll position
        updateActiveNavLink();
    }

    window.addEventListener('scroll', handleScroll);
    handleScroll(); // Initial check

    // ============ BACK TO TOP ============
    backToTop.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // ============ MOBILE MENU ============
    const menuToggle = document.getElementById('menuToggle');
    const nav = document.getElementById('nav');
    const navOverlay = document.getElementById('navOverlay');
    const navClose = document.getElementById('navClose');

    function toggleNav(show) {
        nav.classList.toggle('active', show);
        menuToggle.classList.toggle('active', show);
        if (navOverlay) navOverlay.classList.toggle('active', show);
        document.body.style.overflow = show ? 'hidden' : '';
    }

    menuToggle.addEventListener('click', () => {
        const isActive = !nav.classList.contains('active');
        toggleNav(isActive);
    });

    if (navOverlay) {
        navOverlay.addEventListener('click', () => toggleNav(false));
    }

    if (navClose) {
        navClose.addEventListener('click', () => toggleNav(false));
    }

    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', () => toggleNav(false));
    });

    // ============ SEARCH OVERLAY ============
    const btnSearch = document.getElementById('btnSearch');
    const searchOverlay = document.getElementById('searchOverlay');
    const searchClose = document.getElementById('searchClose');
    const searchInput = searchOverlay.querySelector('.search-input');

    btnSearch.addEventListener('click', () => {
        searchOverlay.classList.toggle('active');
        if (searchOverlay.classList.contains('active')) {
            setTimeout(() => searchInput.focus(), 300);
        }
    });

    searchClose.addEventListener('click', () => {
        searchOverlay.classList.remove('active');
    });

    // Close search on Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            searchOverlay.classList.remove('active');
        }
    });

    // ============ ACTIVE NAV LINK ============
    function updateActiveNavLink() {
        const sections = document.querySelectorAll('section[id]');
        const scrollPos = window.scrollY + 120;

        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.offsetHeight;
            const sectionId = section.getAttribute('id');

            if (scrollPos >= sectionTop && scrollPos < sectionTop + sectionHeight) {
                document.querySelectorAll('.nav-item').forEach(item => {
                    item.classList.remove('active');
                });
                const activeLink = document.querySelector(`.nav-link[href="#${sectionId}"]`);
                if (activeLink) {
                    activeLink.parentElement.classList.add('active');
                }
            }
        });
    }

    // ============ COUNTER ANIMATION ============
    function animateCounters() {
        const counters = document.querySelectorAll('.stat-number[data-count]');
        counters.forEach(counter => {
            if (counter.dataset.animated) return;

            const rect = counter.getBoundingClientRect();
            const isVisible = rect.top < window.innerHeight && rect.bottom > 0;

            if (isVisible) {
                counter.dataset.animated = 'true';
                const target = parseInt(counter.dataset.count);
                const duration = 2000;
                const step = target / (duration / 16);
                let current = 0;

                const updateCounter = () => {
                    current += step;
                    if (current < target) {
                        counter.textContent = Math.floor(current).toLocaleString('ar-SA');
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target.toLocaleString('ar-SA');
                    }
                };

                updateCounter();
            }
        });
    }

    window.addEventListener('scroll', animateCounters);
    animateCounters(); // Check on load

    // ============ COURSE FILTER ============
    const filterBtns = document.querySelectorAll('.filter-btn');
    const courseCards = document.querySelectorAll('.course-card');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Update active button
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const filter = btn.dataset.filter;

            courseCards.forEach((card, index) => {
                const category = card.dataset.category;

                if (filter === 'all' || category === filter) {
                    card.style.display = '';
                    card.style.animation = `fadeInUp 0.5s ease forwards ${index * 0.1}s`;
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // Add fadeInUp animation
    const styleSheet = document.createElement('style');
    styleSheet.textContent = `
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    `;
    document.head.appendChild(styleSheet);

    // ============ SMOOTH SCROLL ============
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const headerHeight = header.offsetHeight;
                const targetPosition = target.offsetTop - headerHeight;
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // ============ SWIPER - TESTIMONIALS ============
    if (typeof Swiper !== 'undefined') {
        new Swiper('.testimonials-swiper', {
            slidesPerView: 1,
            spaceBetween: 24,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                }
            }
        });
    }

    // ============ AOS INIT ============
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 80,
            disable: function() {
                return window.innerWidth < 768;
            }
        });
    }

    // ============ NEWSLETTER FORM ============
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const input = newsletterForm.querySelector('.newsletter-input');
            const email = input.value.trim();
            const btn = newsletterForm.querySelector('.btn');

            if (email && isValidEmail(email)) {
                const btnText = btn.querySelector('span');
                const originalText = btnText.textContent;
                btnText.textContent = 'جاري الاشتراك...';
                btn.style.pointerEvents = 'none';

                fetch(qimah_ajax.ajaxurl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    action: 'qimah_newsletter',
                    nonce: qimah_ajax.newsletter_nonce,
                    email: email
                })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        btnText.textContent = 'تم الاشتراك بنجاح!';
                        input.value = '';
                    } else {
                        btnText.textContent = data.data?.message || 'حدث خطأ';
                    }
                    setTimeout(() => {
                        btnText.textContent = originalText;
                        btn.style.pointerEvents = '';
                    }, 3000);
                })
                .catch(() => {
                    btnText.textContent = 'حدث خطأ';
                    setTimeout(() => {
                        btnText.textContent = originalText;
                        btn.style.pointerEvents = '';
                    }, 3000);
                });
            }
        });
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    // ============ PARALLAX EFFECT ON HERO SHAPES ============
    const heroSection = document.querySelector('.hero');
    if (heroSection) {
        heroSection.addEventListener('mousemove', (e) => {
            const shapes = heroSection.querySelectorAll('.shape');
            const x = (e.clientX / window.innerWidth - 0.5) * 2;
            const y = (e.clientY / window.innerHeight - 0.5) * 2;

            shapes.forEach((shape, i) => {
                const speed = (i + 1) * 10;
                shape.style.transform = `translate(${x * speed}px, ${y * speed}px)`;
            });
        });
    }

    // ============ INSTRUCTOR SOCIAL CLICK ============
    document.querySelectorAll('.instructor-social-link').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });

    // ============ SEARCH CLOSE ============
    const searchClose = document.getElementById('searchClose');
    if (searchClose) {
        searchClose.addEventListener('click', function() {
            document.getElementById('searchOverlay').classList.remove('active');
        });
    }

    // ============ CART BADGE UPDATE ============
    const cartBadge = document.querySelector('.cart-badge');
    if (cartBadge) {
        document.body.addEventListener('added_to_cart', () => {
            fetch(qimah_ajax.ajaxurl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    action: 'qimah_cart_count',
                    nonce: qimah_ajax.cart_nonce,
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const count = parseInt(data.data.count);
                    if (count > 0) {
                        cartBadge.textContent = count;
                        cartBadge.style.display = '';
                    } else {
                        cartBadge.style.display = 'none';
                    }
                }
            });
        });
    }

});
