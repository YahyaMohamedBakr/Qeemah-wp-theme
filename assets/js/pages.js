/* ============================================
   QIMAH WA QUDWAH - Inner Pages JavaScript
   ============================================ */

document.addEventListener('DOMContentLoaded', () => {

    // ============ INNER PAGE HEADER SCROLL ============ 
    const header = document.getElementById('header');
    const backToTop = document.getElementById('backToTop');

    function handleScroll() {
        const scrollY = window.scrollY;

        // Inner page header already has white bg, just add shadow on scroll
        if (scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }

        // Back to top button
        if (backToTop) {
            if (scrollY > 400) {
                backToTop.classList.add('active');
            } else {
                backToTop.classList.remove('active');
            }
        }
    }

    window.addEventListener('scroll', handleScroll);
    handleScroll();

    // ============ BACK TO TOP ============
    if (backToTop) {
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // ============ MOBILE MENU ============
    const menuToggle = document.getElementById('menuToggle');
    const nav = document.getElementById('nav');

    if (menuToggle && nav) {
        menuToggle.addEventListener('click', () => {
            nav.classList.toggle('active');
            menuToggle.classList.toggle('active');
        });

        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                nav.classList.remove('active');
                menuToggle.classList.remove('active');
            });
        });

        document.addEventListener('click', (e) => {
            if (!nav.contains(e.target) && !menuToggle.contains(e.target)) {
                nav.classList.remove('active');
                menuToggle.classList.remove('active');
            }
        });
    }

    // ============ SEARCH OVERLAY ============
    const btnSearch = document.getElementById('btnSearch');
    const searchOverlay = document.getElementById('searchOverlay');
    const searchClose = document.getElementById('searchClose');

    if (btnSearch && searchOverlay && searchClose) {
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

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                searchOverlay.classList.remove('active');
            }
        });
    }

    // ============ ARCHIVE FILTER BUTTONS ============
    const filterBtns = document.querySelectorAll('.archive-filter-btn');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const filter = btn.dataset.filter;
            const cards = document.querySelectorAll('.archive-courses-grid .course-card');

            cards.forEach((card, index) => {
                const category = card.dataset.category;
                if (filter === 'all' || category === filter) {
                    card.style.display = '';
                    card.style.animation = `fadeInUp 0.4s ease forwards ${index * 0.05}s`;
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // ============ NEWSLETTER FORM ============
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const input = newsletterForm.querySelector('.newsletter-input');
            const btn = newsletterForm.querySelector('.btn span');
            const email = input.value.trim();

            if (email && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                const originalText = btn.textContent;
                btn.textContent = 'تم الاشتراك بنجاح!';
                input.value = '';
                setTimeout(() => { btn.textContent = originalText; }, 3000);
            }
        });
    }

    // ============ VIEW TOGGLE ============
    const viewBtns = document.querySelectorAll('.archive-view-toggle button');
    const coursesGrid = document.querySelector('.archive-courses-grid');

    viewBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            viewBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });

    // ============ TUTOR LMS ENROLLMENT ============
    const enrollBtn = document.getElementById('qimahEnrollBtn');
    if (enrollBtn) {
        enrollBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const btn = this;
            const courseId = btn.dataset.courseId;
            
            if (!courseId) return;
            
            // Show loading state
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري التسجيل...';
            btn.style.pointerEvents = 'none';
            
            // Use Tutor LMS enrollment AJAX
            if (typeof jQuery !== 'undefined' && jQuery.ajax) {
                jQuery.ajax({
                    url: qimah_ajax.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'tutor_enroll_in_course',
                        course_id: courseId,
                        _wpnonce: btn.dataset.nonce || qimah_ajax.nonce
                    },
                    success: function(response) {
                        if (response.success || response.data) {
                            btn.innerHTML = '<i class="fas fa-check"></i> تم التسجيل بنجاح!';
                            btn.classList.add('enrolled');
                            btn.style.pointerEvents = '';
                            // Redirect to first lesson after a brief delay
                            setTimeout(() => {
                                window.location.href = btn.href;
                            }, 1000);
                        } else {
                            btn.innerHTML = originalText;
                            btn.style.pointerEvents = '';
                            alert('حدث خطأ أثناء التسجيل. يرجى المحاولة مرة أخرى.');
                        }
                    },
                    error: function() {
                        btn.innerHTML = originalText;
                        btn.style.pointerEvents = '';
                        alert('حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.');
                    }
                });
            } else {
                // Fallback: redirect to the course page (Tutor LMS will handle enrollment)
                window.location.href = btn.href;
            }
        });
    }

    // ============ AOS INIT ============
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 700,
            easing: 'ease-out-cubic',
            once: true,
            offset: 60,
            disable: function() {
                return window.innerWidth < 768;
            }
        });
    }

});
