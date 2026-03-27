/**
 * MCUverse — JavaScript Part 2
 * ════════════════════════════════════════════════════
 * Modules:
 *  1. Movie Data Store (PHP replacement for demo)
 *  2. Modal System (open / close / animate)
 *  3. Phases Section Reveal
 *  4. Characters Section Reveal
 *  5. Infinity Gems tracker (Easter Egg)
 * ════════════════════════════════════════════════════
 */

(function () {
    'use strict';

    /* ═══════════════════════════════════════════════════
       1. MOVIE DATA STORE
       In production: này sẽ được PHP inject qua JSON hoặc data-attributes
       Format: movieId -> object
    ═══════════════════════════════════════════════════ */
    const MOVIE_DB = {
        'iron-man': {
            title: 'Iron Man',
            year: 2008,
            phase: 1,
            type: 'Phim điện ảnh',
            duration: '126 phút',
            rating: 8.0,
            order: '01',
            boxOffice: '$585M',
            director: 'Jon Favreau',
            cast: 'Robert Downey Jr., Gwyneth Paltrow, Jeff Bridges, Terrence Howard',
            tagline: '"Genius. Billionaire. Playboy. Philanthropist."',
            desc: 'Tony Stark, một thiên tài chế tạo vũ khí và tỷ phú tự kiêu, bị bắt cóc bởi tổ chức khủng bố và buộc phải chế tạo vũ khí hủy diệt. Thay vào đó, ông xây dựng một bộ giáp chiến đấu để thoát khỏi tù giam — và sau đó hoàn thiện nó thành Iron Man, khởi động vũ trụ MCU.',
            bgColor: '#C0392B',
            connections: ['The Incredible Hulk', 'Iron Man 2', 'The Avengers', 'Avengers: Endgame'],
            watchUrl: 'https://disneyplus.com',
            trailerUrl: 'https://youtube.com',
        },
        'incredible-hulk': {
            title: 'The Incredible Hulk',
            year: 2008,
            phase: 1,
            type: 'Phim điện ảnh',
            duration: '112 phút',
            rating: 6.7,
            order: '02',
            boxOffice: '$264M',
            director: 'Louis Leterrier',
            cast: 'Edward Norton, Liv Tyler, Tim Roth, William Hurt',
            tagline: '"This is not who I am."',
            desc: 'Bruce Banner lang thang khắp thế giới để tìm cách chữa khỏi tình trạng biến đổi thành Hulk khi cơn giận nổi lên. Trong khi đó, Tướng Thaddeus Ross truy đuổi anh để dùng khả năng đó cho quân đội. Emil Blonsky trở thành Abomination.',
            bgColor: '#27AE60',
            connections: ['The Avengers', 'Avengers: Age of Ultron', 'Thor: Ragnarok'],
            watchUrl: 'https://disneyplus.com',
            trailerUrl: 'https://youtube.com',
        },
        'iron-man-2': {
            title: 'Iron Man 2',
            year: 2010,
            phase: 1,
            type: 'Phim điện ảnh',
            duration: '124 phút',
            rating: 7.0,
            order: '03',
            boxOffice: '$624M',
            director: 'Jon Favreau',
            cast: 'Robert Downey Jr., Mickey Rourke, Gwyneth Paltrow, Don Cheadle, Scarlett Johansson',
            tagline: '"I am Iron Man."',
            desc: 'Tony Stark tiết lộ danh tính là Iron Man với thế giới và phải đối mặt với sức ép từ chính phủ, đồng thời đương đầu với Ivan Vanko/Whiplash, kẻ thù mang mối hận thù từ cha mình. Chất độc palladium trong lồng ngực từ từ giết chết anh.',
            bgColor: '#E74C3C',
            connections: ['Iron Man', 'Thor', 'The Avengers', 'Black Widow'],
            watchUrl: 'https://disneyplus.com',
            trailerUrl: 'https://youtube.com',
        },
    };


    /* ═══════════════════════════════════════════════════
       2. MODAL SYSTEM
    ═══════════════════════════════════════════════════ */
    const modalBackdrop = document.getElementById('modal-backdrop');
    const modal = document.getElementById('modal');
    const modalClose = document.getElementById('modal-close');
    let savedScrollY = 0;

    function openModal(movieId) {
        const data = MOVIE_DB[movieId];
        if (!data) {
            console.warn(`[MCUverse] No data found for movieId: "${movieId}"`);
            // Still open with a generic fallback
            populateModal({
                title: movieId.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase()),
                year: '—', phase: '—', type: '—', duration: '—',
                rating: 0, order: '—', boxOffice: '—',
                director: '—', cast: '—', tagline: '', desc: 'Dữ liệu đang được cập nhật...',
                bgColor: '#333', connections: [], watchUrl: '#', trailerUrl: '#',
            });
        } else {
            populateModal(data);
        }

        savedScrollY = window.scrollY;
        document.body.style.overflow = 'hidden';
        modalBackdrop.classList.add('is-open');
        modalBackdrop.setAttribute('aria-hidden', 'false');
        modal.scrollTop = 0;

        // Trap focus
        setTimeout(() => modalClose.focus(), 300);
    }

    function closeModal() {
        modalBackdrop.classList.remove('is-open');
        modalBackdrop.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        window.scrollTo(0, savedScrollY);
    }

    function populateModal(data) {
        // Blurred background
        const bgImg = document.getElementById('modal-backdrop-img');
        bgImg.style.background = `radial-gradient(ellipse at 50% 0%, ${data.bgColor}33 0%, #0a0a0a 70%)`;

        // Poster placeholder
        const posterEl = document.getElementById('modal-poster');
        posterEl.innerHTML = `<div class="poster-placeholder" data-title="${data.title}" style="--ph-color: ${data.bgColor}; width:100%; height:100%;"></div>`;

        // Score ring
        const circumference = 150.8; // 2 * π * 24
        const offset = circumference - (data.rating / 10) * circumference;
        const scoreRing = document.getElementById('modal-score-ring');
        scoreRing.style.strokeDashoffset = circumference; // reset
        // Animate after a brief delay
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                scoreRing.style.strokeDashoffset = offset;
                // Color based on score
                if (data.rating >= 8) scoreRing.style.stroke = '#F5C842';
                else if (data.rating >= 7) scoreRing.style.stroke = '#00d4ff';
                else scoreRing.style.stroke = '#E23636';
            });
        });

        document.getElementById('modal-score').textContent = data.rating;

        // Badges
        document.getElementById('modal-phase-badge').textContent = `Phase ${data.phase}`;
        document.getElementById('modal-type-badge').textContent = data.type;

        // Text content
        document.getElementById('modal-eyebrow').textContent = `Marvel Studios · ${data.year}`;
        document.getElementById('modal-title').textContent = data.title;
        document.getElementById('modal-tagline').textContent = data.tagline || '';
        document.getElementById('modal-duration').textContent = data.duration;
        document.getElementById('modal-year').textContent = data.year;
        document.getElementById('modal-order').textContent = data.order;
        document.getElementById('modal-box-office').textContent = data.boxOffice;
        document.getElementById('modal-desc').textContent = data.desc;
        document.getElementById('modal-director').textContent = data.director;
        document.getElementById('modal-cast').textContent = data.cast;

        // Connections
        const connList = document.getElementById('modal-connections');
        connList.innerHTML = data.connections
            .map(c => `<span class="modal-connection-tag">${c}</span>`)
            .join('');

        // Watch / trailer buttons
        document.getElementById('modal-watch-btn').href = data.watchUrl;
        document.getElementById('modal-trailer-btn').onclick = () => window.open(data.trailerUrl, '_blank');

        // Reset bookmark
        document.getElementById('modal-bookmark-btn').classList.remove('is-saved');
    }

    // Close events
    if (modalClose) {
        modalClose.addEventListener('click', closeModal);
    }

    if (modalBackdrop) {
        modalBackdrop.addEventListener('click', (e) => {
            if (e.target === modalBackdrop) closeModal();
        });
    }

    // Keyboard close
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modalBackdrop?.classList.contains('is-open')) {
            closeModal();
        }
    });

    // Bookmark toggle
    const bookmarkBtn = document.getElementById('modal-bookmark-btn');
    if (bookmarkBtn) {
        bookmarkBtn.addEventListener('click', () => {
            bookmarkBtn.classList.toggle('is-saved');
            // PHP integration point: send AJAX/fetch to save to user's watchlist
        });
    }

    // ── Open modal from cards and timeline items ──
    // PHP will render data-open-modal="<?= $movie['slug'] ?>" on cards
    document.addEventListener('click', (e) => {
        const trigger = e.target.closest('[data-open-modal]');
        if (trigger) {
            e.preventDefault();
            const movieId = trigger.dataset.openModal;
            openModal(movieId);
        }
    });


    /* ═══════════════════════════════════════════════════
       3. PHASES SECTION — STAGGERED REVEAL
    ═══════════════════════════════════════════════════ */
    function initPhasesReveal() {
        const cards = document.querySelectorAll('.phase-card');
        if (!cards.length) return;

        cards.forEach(c => {
            c.style.opacity = '0';
            c.style.transform = 'translateY(30px)';
            c.style.transition = 'opacity 0.6s cubic-bezier(0.19,1,0.22,1), transform 0.6s cubic-bezier(0.19,1,0.22,1)';
        });

        const obs = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const idx = [...cards].indexOf(entry.target);
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, idx * 80);
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        cards.forEach(c => obs.observe(c));
    }


    /* ═══════════════════════════════════════════════════
       4. CHARACTERS SECTION — REVEAL + HOVER GLOW
    ═══════════════════════════════════════════════════ */
    function initCharactersReveal() {
        const cards = document.querySelectorAll('.char-card');
        if (!cards.length) return;

        // Initial state
        cards.forEach(c => {
            c.style.opacity = '0';
            c.style.transform = 'translateY(24px) scale(0.97)';
            c.style.transition = 'opacity 0.5s cubic-bezier(0.19,1,0.22,1), transform 0.5s cubic-bezier(0.19,1,0.22,1), border-color 0.2s';
        });

        const obs = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const idx = [...cards].indexOf(entry.target);
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0) scale(1)';
                    }, idx * 60);
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -60px 0px' });

        cards.forEach(c => obs.observe(c));

        // Color-tinted hover glow using CSS custom property
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                const bg = card.querySelector('.char-card-bg');
                const clr = getComputedStyle(card).getPropertyValue('--char-clr') || '';
                if (bg && clr) {
                    bg.style.opacity = '1';
                }
            });
        });
    }


    /* ═══════════════════════════════════════════════════
       5. INFINITY STONES TRACKER — Easter Egg
       Counts how many "gem" tags are currently visible
       Shows a mini tracker in the corner
    ═══════════════════════════════════════════════════ */
    function initInfinityTracker() {
        const gemTags = document.querySelectorAll('.tl-tag--gem');
        if (gemTags.length < 2) return; // not enough for the easter egg

        // Create tracker element
        const tracker = document.createElement('div');
        tracker.className = 'infinity-tracker';
        tracker.innerHTML = `
      <div class="it-label">Infinity Stones</div>
      <div class="it-gems" id="it-gems">
        <div class="it-gem it-gem--space"  title="Space Stone (Tesseract)"></div>
        <div class="it-gem it-gem--mind"   title="Mind Stone (Scepter/Vision)"></div>
        <div class="it-gem it-gem--reality" title="Reality Stone (Aether)"></div>
        <div class="it-gem it-gem--power"  title="Power Stone"></div>
        <div class="it-gem it-gem--time"   title="Time Stone (Eye of Agamotto)"></div>
        <div class="it-gem it-gem--soul"   title="Soul Stone"></div>
      </div>
    `;
        document.body.appendChild(tracker);

        // Add styles
        const style = document.createElement('style');
        style.textContent = `
      .infinity-tracker {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 800;
        background: rgba(10,10,10,0.9);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 12px;
        padding: 10px 14px;
        backdrop-filter: blur(16px);
        opacity: 0;
        transform: translateY(10px);
        transition: opacity 0.4s, transform 0.4s;
        pointer-events: none;
      }
      .infinity-tracker.is-visible {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
      }
      .it-label {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: rgba(255,255,255,0.3);
        margin-bottom: 8px;
        text-align: center;
      }
      .it-gems {
        display: flex;
        gap: 8px;
        align-items: center;
        justify-content: center;
      }
      .it-gem {
        width: 18px; height: 18px;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,0.1);
        transition: box-shadow 0.4s, transform 0.3s;
        position: relative;
      }
      .it-gem::after {
        content: '';
        position: absolute;
        inset: 3px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
      }
      .it-gem.is-found { border-color: transparent; }
      .it-gem.is-found::after { display: none; }
      .it-gem--space  { background: #4fc3f7; }
      .it-gem--mind   { background: #ffee00; }
      .it-gem--reality{ background: #e53935; }
      .it-gem--power  { background: #9c27b0; }
      .it-gem--time   { background: #00ff88; }
      .it-gem--soul   { background: #ff9800; }
      .it-gem:not(.is-found) { filter: grayscale(1) brightness(0.3); }
      .it-gem.is-found {
        box-shadow: 0 0 12px currentColor;
        transform: scale(1.1);
      }
    `;
        document.head.appendChild(style);

        // Show after some scroll
        window.addEventListener('scroll', () => {
            tracker.classList.toggle('is-visible', window.scrollY > 400);
        }, { passive: true });

        // Observe gem tags — light up stones as user scrolls to them
        const gemMap = {
            'Space Stone': 'it-gem--space',
            'Reality Stone': 'it-gem--reality',
            'Mind Stone': 'it-gem--mind',
            'Power Stone': 'it-gem--power',
            'Time Stone': 'it-gem--time',
            'Soul Stone': 'it-gem--soul',
        };

        const gemObs = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const text = entry.target.textContent;
                    for (const [stone, cls] of Object.entries(gemMap)) {
                        if (text.includes(stone)) {
                            const gemEl = tracker.querySelector(`.${cls}`);
                            if (gemEl) {
                                gemEl.classList.add('is-found');
                                // Pulse animation
                                gemEl.animate([
                                    { transform: 'scale(1.5)', opacity: 1 },
                                    { transform: 'scale(1.1)', opacity: 1 }
                                ], { duration: 400, easing: 'cubic-bezier(0.19,1,0.22,1)', fill: 'forwards' });
                            }
                        }
                    }
                }
            });
        }, { threshold: 0.8 });

        gemTags.forEach(tag => gemObs.observe(tag));
    }


    /* ═══════════════════════════════════════════════════
       6. SMOOTH HORIZONTAL SCROLL for Phase Filter (mobile)
    ═══════════════════════════════════════════════════ */
    function initFilterTabsDrag() {
        const tabs = document.querySelector('.filter-tabs');
        if (!tabs) return;

        let isDown = false, startX, scrollLeft;

        tabs.addEventListener('mousedown', (e) => {
            isDown = true;
            tabs.style.cursor = 'grabbing';
            startX = e.pageX - tabs.offsetLeft;
            scrollLeft = tabs.scrollLeft;
        });

        tabs.addEventListener('mouseleave', () => { isDown = false; tabs.style.cursor = 'default'; });
        tabs.addEventListener('mouseup', () => { isDown = false; tabs.style.cursor = 'default'; });
        tabs.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - tabs.offsetLeft;
            tabs.scrollLeft = scrollLeft - (x - startX) * 1.5;
        });
    }


    /* ═══════════════════════════════════════════════════
       INIT
    ═══════════════════════════════════════════════════ */
    function init() {
        initPhasesReveal();
        initCharactersReveal();
        initInfinityTracker();
        initFilterTabsDrag();

        console.log(
            '%cMCUverse Part 2 loaded ✓',
            'color: #00d4ff; font-family: monospace; font-size: 13px; font-weight: bold;'
        );
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();