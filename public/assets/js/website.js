// ========================================
// CV. BKC - Premium Website JavaScript
// ========================================

document.addEventListener('DOMContentLoaded', function() {

    // ====== LOADING SCREEN ======
    const loading = document.getElementById('loadingScreen');
    if (loading) {
        setTimeout(() => { loading.classList.add('hidden'); }, 1800);
    }

    // ====== NAVBAR SCROLL ======
    const navbar = document.querySelector('.bkc-navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 60);
        });
    }

    // ====== SCROLL TO TOP ======
    const scrollBtn = document.querySelector('.scroll-top-btn');
    if (scrollBtn) {
        window.addEventListener('scroll', () => {
            scrollBtn.classList.toggle('visible', window.scrollY > 400);
        });
        scrollBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
    }

    // ====== COUNTER ANIMATION ======
    function animateCounter(el) {
        const target = parseInt(el.dataset.target);
        const duration = 2000;
        const start = Date.now();

        const timer = setInterval(() => {
            const elapsed = Date.now() - start;
            const progress = Math.min(elapsed / duration, 1);
            const ease = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.round(ease * target);
            if (progress >= 1) clearInterval(timer);
        }, 16);
    }

    const counters = document.querySelectorAll('.counter-num');
    if (counters.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.dataset.counted) {
                    entry.target.dataset.counted = 'true';
                    animateCounter(entry.target);
                }
            });
        }, { threshold: 0.5 });
        counters.forEach(el => observer.observe(el));
    }

    // ====== COUNTDOWN TIMER ======
    function updateCountdown(targetDate, elements) {
        function tick() {
            const now = new Date().getTime();
            const distance = new Date(targetDate).getTime() - now;

            if (distance < 0) {
                elements.days.textContent = '00';
                elements.hours.textContent = '00';
                elements.minutes.textContent = '00';
                elements.seconds.textContent = '00';
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            elements.days.textContent = String(days).padStart(2, '0');
            elements.hours.textContent = String(hours).padStart(2, '0');
            elements.minutes.textContent = String(minutes).padStart(2, '0');
            elements.seconds.textContent = String(seconds).padStart(2, '0');
        }

        tick();
        setInterval(tick, 1000);
    }

    const countdownEl = document.getElementById('countdownTimer');
    if (countdownEl) {
        const targetDate = countdownEl.dataset.date;
        updateCountdown(targetDate, {
            days: document.getElementById('cdDays'),
            hours: document.getElementById('cdHours'),
            minutes: document.getElementById('cdMinutes'),
            seconds: document.getElementById('cdSeconds'),
        });
    }

    // ====== FAQ ACCORDION ======
    document.querySelectorAll('.faq-question').forEach(btn => {
        btn.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const isOpen = answer.classList.contains('open');

            // Close all
            document.querySelectorAll('.faq-answer.open').forEach(a => {
                a.classList.remove('open');
                a.previousElementSibling.setAttribute('aria-expanded', 'false');
            });

            // Open clicked if was closed
            if (!isOpen) {
                answer.classList.add('open');
                this.setAttribute('aria-expanded', 'true');
            }
        });
    });

    // ====== TRAINING FILTER ======
    const filterBtns = document.querySelectorAll('.filter-btn');
    const trainingCards = document.querySelectorAll('.training-card-wrap');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filter = this.dataset.filter;
            trainingCards.forEach(card => {
                if (filter === 'all' || card.dataset.category === filter) {
                    card.style.display = '';
                    card.style.animation = 'fadeInUp 0.4s ease';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // ====== LIVE SEARCH ======
    const searchInput = document.getElementById('trainingSearch');
    if (searchInput) {
        let searchTimer;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimer);
            const query = this.value.trim();

            if (query.length < 2) {
                trainingCards.forEach(card => card.style.display = '');
                return;
            }

            searchTimer = setTimeout(() => {
                trainingCards.forEach(card => {
                    const title = card.querySelector('.training-card-title')?.textContent.toLowerCase() || '';
                    const desc = card.querySelector('.training-card-desc')?.textContent.toLowerCase() || '';
                    const match = title.includes(query.toLowerCase()) || desc.includes(query.toLowerCase());
                    card.style.display = match ? '' : 'none';
                });
            }, 300);
        });
    }

    // ====== SMOOTH SCROLL ======
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // ====== CONTACT FORM ======
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const btn = this.querySelector('[type="submit"]');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
            btn.disabled = true;

            try {
                const res = await fetch(this.action, { method: 'POST', body: new FormData(this) });
                const data = await res.json();
                if (data.status === 'success') {
                    Swal.fire({ icon: 'success', title: 'Pesan Terkirim!', text: data.message, confirmButtonColor: '#C8A34D' });
                    this.reset();
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal!', text: data.message, confirmButtonColor: '#C8A34D' });
                }
            } catch (err) {
                Swal.fire({ icon: 'error', title: 'Error!', text: 'Gagal mengirim pesan. Coba lagi.', confirmButtonColor: '#C8A34D' });
            } finally {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        });
    }

    // ====== IMAGE LAZY LOAD ======
    const lazyImages = document.querySelectorAll('img[data-src]');
    if ('IntersectionObserver' in window) {
        const imgObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    imgObserver.unobserve(img);
                }
            });
        });
        lazyImages.forEach(img => imgObserver.observe(img));
    }

    // ====== AOS INIT ======
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 700,
            easing: 'ease-out-cubic',
            once: true,
            offset: 60,
        });
    }

    // ====== NAVBAR MOBILE CLOSE ======
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            const navbarCollapse = document.querySelector('.navbar-collapse');
            if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                if (bsCollapse) bsCollapse.hide();
            }
        });
    });

});

// WhatsApp redirect with training info
function waRegister(trainingTitle, trainingDate) {
    const phone = '6281803867430';
    const msg = encodeURIComponent(
        `Halo Admin CV Bagus Kencana Cakrada.\n` +
        `Saya ingin mendaftar pelatihan:\n` +
        `📚 *${trainingTitle}*\n` +
        `📅 Tanggal: ${trainingDate}\n\n` +
        `Mohon informasi lebih lanjut. Terima kasih.`
    );
    window.open(`https://wa.me/${phone}?text=${msg}`, '_blank');
}
