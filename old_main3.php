<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * application/views/main.php
 * â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
 * View chĂ­nh cá»§a MCUverse SPA.
 * Giá»¯ nguyĂªn toĂ n bá»™ HTML tá»« index.html,
 * chá»‰ thay cĂ¡c Ä‘Æ°á»ng dáº«n tÄ©nh báº±ng base_url() cá»§a CI3.
 *
 * base_url() Ä‘Æ°á»£c load trong CI3 nhá» helper 'url'
 * â†’ thĂªm $this->load->helper('url') trong Welcome controller náº¿u cáº§n.
 *
 * JavaScript sáº½ tá»± fetch /api/movies vĂ  /api/characters Ä‘á»ƒ Ä‘iá»n data.
 */
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MCU Universe â€” BĂ¡ch Khoa &amp; Lá»™ TrĂ¬nh Xem Phim</title>
    <meta name="description" content="BĂ¡ch khoa toĂ n thÆ° MCU â€” lá»™ trĂ¬nh xem phim Marvel theo thá»© tá»± thá»i gian, Ä‘áº§y Ä‘á»§ 6 phases." />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow+Condensed:ital,wght@0,300;0,400;0,600;0,700;1,300&family=Barlow:wght@300;400;500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('style.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('style-part2.css') ?>" />
</head>

<body>

    <!-- CURSOR -->
    <div class="cursor" id="cursor"></div>
    <div class="cursor-follower" id="cursor-follower"></div>

    <!-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
       MOVIE DETAIL MODAL â€” JS Ä‘iá»n data vĂ o
  â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• -->
    <div class="modal-backdrop" id="modal-backdrop" aria-hidden="true">
        <div class="modal" id="modal" role="dialog" aria-modal="true" aria-labelledby="modal-title">
            <button class="modal-close" id="modal-close" aria-label="ÄĂ³ng">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <line x1="2" y1="2" x2="18" y2="18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    <line x1="18" y1="2" x2="2" y2="18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                </svg>
            </button>
            <div class="modal-backdrop-img" id="modal-backdrop-img"></div>
            <div class="modal-layout">
                <div class="modal-poster-col">
                    <div class="modal-poster" id="modal-poster"></div>
                    <div class="modal-poster-meta">
                        <div class="modal-score-ring">
                            <svg viewBox="0 0 56 56" class="score-ring-svg">
                                <circle cx="28" cy="28" r="24" class="score-ring-track" />
                                <circle cx="28" cy="28" r="24" class="score-ring-fill" id="modal-score-ring" stroke-dasharray="150.8" stroke-dashoffset="150.8" />
                            </svg>
                            <span class="modal-score-num" id="modal-score">0</span>
                        </div>
                        <div class="modal-poster-badges">
                            <span class="modal-phase-badge" id="modal-phase-badge">Phase 1</span>
                            <span class="modal-type-badge" id="modal-type-badge">Phim</span>
                        </div>
                    </div>
                </div>
                <div class="modal-info-col">
                    <p class="modal-eyebrow" id="modal-eyebrow">Marvel Studios Â· 2008</p>
                    <h2 class="modal-title" id="modal-title">Iron Man</h2>
                    <p class="modal-tagline" id="modal-tagline"></p>
                    <div class="modal-stats-row">
                        <div class="modal-stat"><span class="modal-stat-icon">â±</span><div>
                            <span class="modal-stat-val" id="modal-duration">â€”</span>
                            <span class="modal-stat-lbl">Thá»i lÆ°á»£ng</span></div></div>
                        <div class="modal-stat"><span class="modal-stat-icon">đŸ“…</span><div>
                            <span class="modal-stat-val" id="modal-year">â€”</span>
                            <span class="modal-stat-lbl">NÄƒm ra máº¯t</span></div></div>
                        <div class="modal-stat"><span class="modal-stat-icon">đŸ¬</span><div>
                            <span class="modal-stat-val" id="modal-order">â€”</span>
                            <span class="modal-stat-lbl">Thá»© tá»± xem</span></div></div>
                        <div class="modal-stat"><span class="modal-stat-icon">đŸ’°</span><div>
                            <span class="modal-stat-val" id="modal-box-office">â€”</span>
                            <span class="modal-stat-lbl">Doanh thu</span></div></div>
                    </div>
                    <div class="modal-divider"></div>
                    <p class="modal-desc" id="modal-desc"></p>
                    <div class="modal-connections">
                        <h4 class="modal-connections-title">Káº¿t ná»‘i vá»›i vÅ© trá»¥</h4>
                        <div class="modal-connections-list" id="modal-connections"></div>
                    </div>
                    <div class="modal-credits">
                        <div class="modal-credit">
                            <span class="modal-credit-lbl">Äáº¡o diá»…n</span>
                            <span class="modal-credit-val" id="modal-director">â€”</span>
                        </div>
                        <div class="modal-credit">
                            <span class="modal-credit-lbl">Diá»…n viĂªn chĂ­nh</span>
                            <span class="modal-credit-val" id="modal-cast">â€”</span>
                        </div>
                    </div>
                    <div class="modal-actions">
                        <a class="btn btn--primary modal-watch-btn" id="modal-watch-btn" href="#">
                            <svg width="16" height="16" viewBox="0 0 16 16"><polygon points="3,2 13,8 3,14" fill="currentColor" /></svg>
                            Xem trĂªn Disney+
                        </a>
                        <button class="btn btn--ghost modal-trailer-btn" id="modal-trailer-btn">
                            <svg width="16" height="16" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="6.5" stroke="currentColor" stroke-width="1.2" fill="none" />
                                <polygon points="6,5 11,8 6,11" fill="currentColor" />
                            </svg>Trailer
                        </button>
                        <button class="modal-bookmark-btn" id="modal-bookmark-btn" aria-label="LÆ°u">
                            <svg width="18" height="18" viewBox="0 0 18 18">
                                <path d="M4 2h10a1 1 0 0 1 1 1v13l-6-3.5L3 16V3a1 1 0 0 1 1-1z" stroke="currentColor" stroke-width="1.3" fill="none" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• NAVBAR â• -->
    <nav class="navbar" id="navbar">
        <div class="nav-inner">
            <a href="<?= base_url() ?>" class="nav-logo">
                <span class="logo-mark">M</span>
                <span class="logo-text">MCU<em>verse</em></span>
            </a>
            <ul class="nav-links">
                <li><a href="#timeline"    class="nav-link">Lá»™ trĂ¬nh</a></li>
                <li><a href="#movies"      class="nav-link">Phim</a></li>
                <li><a href="#characters"  class="nav-link">NhĂ¢n váº­t</a></li>
                <li><a href="#phases"      class="nav-link">Phases</a></li>
            </ul>
            <a href="#movies" class="nav-cta">Báº¯t Ä‘áº§u xem</a>
        </div>
    </nav>

    <!-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• HERO â•â•â• -->
    <section class="hero" id="hero">
        <canvas class="hero-stars" id="hero-stars"></canvas>
        <div class="hero-bg-layer hero-bg-nebula" data-parallax="0.15"></div>
        <div class="hero-bg-layer hero-bg-glow"   data-parallax="0.25"></div>
        <div class="hero-orb hero-orb--red"></div>
        <div class="hero-orb hero-orb--blue"></div>
        <div class="hero-inner">
            <p class="hero-eyebrow">
                <span class="eyebrow-line"></span>BĂ¡ch khoa toĂ n thÆ° Ä‘iá»‡n áº£nh<span class="eyebrow-line"></span>
            </p>
            <div class="hero-title-wrapper" id="hero-title-wrapper">
                <h1 class="hero-title hero-title--clip">MARVEL</h1>
                <div class="hero-title-sub-row">
                    <h1 class="hero-title hero-title--outline">CINEMATIC</h1>
                    <div class="hero-badge">
                        <span class="hero-badge-num" id="hero-badge-num">20</span>
                        <span class="hero-badge-label">bá»™ phim</span>
                    </div>
                    <h1 class="hero-title hero-title--outline">UNIVERSE</h1>
                </div>
            </div>
            <p class="hero-desc">
                KhĂ¡m phĂ¡ toĂ n bá»™ vÅ© trá»¥ Ä‘iá»‡n áº£nh Marvel â€” tá»« <strong>Phase 1</strong> cho Ä‘áº¿n <strong>Multiverse Saga</strong>.<br />
                Lá»™ trĂ¬nh xem phim theo thá»© tá»± thá»i gian tuyáº¿n tĂ­nh, Ä‘áº§y Ä‘á»§, khĂ´ng bá» sĂ³t chi tiáº¿t nĂ o.
            </p>
            <div class="hero-actions">
                <a href="#timeline" class="btn btn--primary">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.5" />
                        <polygon points="6.5,5 11,8 6.5,11" fill="currentColor" />
                    </svg>
                    Báº¯t Ä‘áº§u lá»™ trĂ¬nh
                </a>
                <a href="#movies" class="btn btn--ghost">Xem táº¥t cáº£ phim</a>
            </div>
            <div class="hero-stats">
                <div class="hero-stat"><span class="hero-stat-num" data-count="20" id="stat-movies">0</span><span class="hero-stat-label">Bá»™ phim</span></div>
                <div class="hero-stat-divider"></div>
                <div class="hero-stat"><span class="hero-stat-num" data-count="3" id="stat-series">0</span><span class="hero-stat-label">Series TV</span></div>
                <div class="hero-stat-divider"></div>
                <div class="hero-stat"><span class="hero-stat-num" data-count="6">0</span><span class="hero-stat-label">Phases</span></div>
                <div class="hero-stat-divider"></div>
                <div class="hero-stat"><span class="hero-stat-num" data-count="2008">0</span><span class="hero-stat-label">Tá»« nÄƒm</span></div>
            </div>
        </div>
        <div class="hero-scroll-indicator">
            <span class="scroll-text">Cuá»™n Ä‘á»ƒ khĂ¡m phĂ¡</span>
            <div class="scroll-line"><div class="scroll-dot"></div></div>
        </div>
    </section>

    <!-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• FILTER BAR â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• -->
    <section class="filter-section" id="filter-section">
        <div class="filter-glass-bar" id="filter-bar">
            <div class="search-wrapper" id="search-wrapper">
                <label class="search-icon" for="search-input" aria-label="TĂ¬m kiáº¿m">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <circle cx="7.5" cy="7.5" r="5.5" stroke="currentColor" stroke-width="1.5" />
                        <line x1="11.5" y1="11.5" x2="16" y2="16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                </label>
                <input type="text" id="search-input" class="search-input" placeholder="TĂ¬m tĂªn phim, nhĂ¢n váº­t, phase..." autocomplete="off" />
                <button class="search-clear" id="search-clear" aria-label="XĂ³a">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <line x1="1" y1="1" x2="13" y2="13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        <line x1="13" y1="1" x2="1" y2="13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                </button>
            </div>
            <div class="filter-divider"></div>
            <div class="filter-tabs" role="group">
                <button class="filter-tab filter-tab--active" data-filter="phase" data-value="all">Táº¥t cáº£</button>
                <button class="filter-tab" data-filter="phase" data-value="1">Phase 1</button>
                <button class="filter-tab" data-filter="phase" data-value="2">Phase 2</button>
                <button class="filter-tab" data-filter="phase" data-value="3">Phase 3</button>
                <button class="filter-tab" data-filter="phase" data-value="4">Phase 4</button>
                <button class="filter-tab" data-filter="phase" data-value="5">Phase 5</button>
                <button class="filter-tab" data-filter="phase" data-value="6">Phase 6</button>
            </div>
            <div class="filter-divider"></div>
            <div class="filter-type-group" role="group">
                <button class="filter-chip filter-chip--active" data-filter="type" data-value="all">
                    <svg width="12" height="12" viewBox="0 0 12 12"><rect width="12" height="12" rx="2" fill="currentColor" opacity="0.7" /></svg>Táº¥t cáº£
                </button>
                <button class="filter-chip" data-filter="type" data-value="movie">
                    <svg width="12" height="12" viewBox="0 0 12 12"><rect x="1" y="2" width="10" height="8" rx="1.5" stroke="currentColor" stroke-width="1.2" fill="none" /><line x1="4" y1="2" x2="4" y2="10" stroke="currentColor" stroke-width="1" /><line x1="8" y1="2" x2="8" y2="10" stroke="currentColor" stroke-width="1" /></svg>Phim
                </button>
                <button class="filter-chip" data-filter="type" data-value="series">
                    <svg width="12" height="12" viewBox="0 0 12 12"><rect x="1" y="1" width="10" height="7" rx="1" stroke="currentColor" stroke-width="1.2" fill="none" /><line x1="4" y1="11" x2="8" y2="11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" /><line x1="6" y1="8" x2="6" y2="11" stroke="currentColor" stroke-width="1.2" /></svg>Series
                </button>
            </div>
            <div class="filter-sort">
                <label class="sort-label" for="sort-select">Sáº¯p xáº¿p</label>
                <div class="sort-select-wrapper">
                    <select id="sort-select" class="sort-select">
                        <option value="timeline">Thá»© tá»± thá»i gian</option>
                        <option value="release">NgĂ y ra máº¯t</option>
                        <option value="phase">Theo Phase</option>
                        <option value="rating">Äiá»ƒm Ä‘Ă¡nh giĂ¡</option>
                    </select>
                    <svg class="sort-chevron" width="12" height="12" viewBox="0 0 12 12">
                        <polyline points="2,4 6,8 10,4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="active-filters" id="active-filters">
            <span class="active-filter-label">Äang hiá»ƒn thá»‹:</span>
            <span class="active-filter-count" id="filter-count">Äang táº£i...</span>
            <button class="filter-reset" id="filter-reset">XĂ³a bá»™ lá»c</button>
        </div>
    </section>

    <!-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• PHASES OVERVIEW â•â•â•â•â•â•â•â•â•â•â•â•â•â• -->
    <section class="phases-section" id="phases">
        <div class="section-header">
            <p class="section-eyebrow">The Saga</p>
            <h2 class="section-title">6 Phases cá»§a MCU</h2>
            <p class="section-desc">Tá»« Iron Man Ä‘áº§u tiĂªn Ä‘áº¿n Multiverse Saga vÄ© Ä‘áº¡i nháº¥t</p>
        </div>
        <!-- PHP: foreach ($phases as $phase) â€” giá»¯ nguyĂªn HTML cá»©ng vĂ¬ phases Ă­t thay Ä‘á»•i -->
        <div class="phases-grid">
            <div class="phase-card" data-phase-num="1" style="--phase-hue: 0;">
                <div class="phase-card-inner">
                    <div class="phase-card-num">01</div>
                    <div class="phase-card-content">
                        <span class="phase-card-tag">Infinity Saga</span>
                        <h3 class="phase-card-title">The Beginning</h3>
                        <p class="phase-card-years">2008 â€“ 2012</p>
                        <p class="phase-card-desc">Khá»Ÿi Ä‘áº§u vÅ© trá»¥ vá»›i Iron Man, Thor, Hulk vĂ  cuá»™c há»™i tá»¥ Avengers Ä‘áº§u tiĂªn.</p>
                        <div class="phase-card-count"><span>6</span> tĂ¡c pháº©m</div>
                    </div>
                    <div class="phase-card-heroes">
                        <div class="phase-hero-dot" style="--c:#E23636" title="Iron Man"></div>
                        <div class="phase-hero-dot" style="--c:#2980B9" title="Thor"></div>
                        <div class="phase-hero-dot" style="--c:#27AE60" title="Hulk"></div>
                        <div class="phase-hero-dot" style="--c:#1ABC9C" title="Cap America"></div>
                        <div class="phase-hero-dot" style="--c:#9B59B6" title="Black Widow"></div>
                    </div>
                </div>
            </div>
            <div class="phase-card" data-phase-num="2" style="--phase-hue: 20;">
                <div class="phase-card-inner">
                    <div class="phase-card-num">02</div>
                    <div class="phase-card-content">
                        <span class="phase-card-tag">Infinity Saga</span>
                        <h3 class="phase-card-title">Expansion</h3>
                        <p class="phase-card-years">2013 â€“ 2015</p>
                        <p class="phase-card-desc">Má»Ÿ rá»™ng vÅ© trá»¥ vá»›i Guardians of the Galaxy vĂ  nhá»¯ng má»‘i Ä‘e dá»a má»›i.</p>
                        <div class="phase-card-count"><span>6</span> tĂ¡c pháº©m</div>
                    </div>
                    <div class="phase-card-heroes">
                        <div class="phase-hero-dot" style="--c:#E67E22" title="Guardians"></div>
                        <div class="phase-hero-dot" style="--c:#3498DB" title="Winter Soldier"></div>
                        <div class="phase-hero-dot" style="--c:#E74C3C" title="Iron Man 3"></div>
                        <div class="phase-hero-dot" style="--c:#8E44AD" title="Thor 2"></div>
                    </div>
                </div>
            </div>
            <div class="phase-card phase-card--featured" data-phase-num="3" style="--phase-hue: 340;">
                <div class="phase-card-inner">
                    <div class="phase-card-num">03</div>
                    <div class="phase-card-content">
                        <span class="phase-card-tag">Infinity Saga Â· Äá»‰nh cao</span>
                        <h3 class="phase-card-title">The Infinity War</h3>
                        <p class="phase-card-years">2016 â€“ 2019</p>
                        <p class="phase-card-desc">Thanos â€” cuá»™c chiáº¿n Infinity War vĂ  Endgame thay Ä‘á»•i vÅ© trá»¥ mĂ£i mĂ£i.</p>
                        <div class="phase-card-count"><span>11</span> tĂ¡c pháº©m</div>
                    </div>
                    <div class="phase-card-heroes">
                        <div class="phase-hero-dot" style="--c:#6C3483" title="Thanos"></div>
                        <div class="phase-hero-dot" style="--c:#E74C3C" title="Avengers"></div>
                        <div class="phase-hero-dot" style="--c:#1A5276" title="Black Panther"></div>
                        <div class="phase-hero-dot" style="--c:#F39C12" title="Doctor Strange"></div>
                        <div class="phase-hero-dot" style="--c:#117A65" title="Spider-Man"></div>
                    </div>
                </div>
            </div>
            <div class="phase-card" data-phase-num="4" style="--phase-hue: 200;">
                <div class="phase-card-inner">
                    <div class="phase-card-num">04</div>
                    <div class="phase-card-content">
                        <span class="phase-card-tag">Multiverse Saga</span>
                        <h3 class="phase-card-title">New World</h3>
                        <p class="phase-card-years">2021 â€“ 2022</p>
                        <p class="phase-card-desc">Háº­u Endgame â€” multiverse má»Ÿ ra, nhá»¯ng anh hĂ¹ng má»›i trá»—i dáº­y.</p>
                        <div class="phase-card-count"><span>10</span> tĂ¡c pháº©m</div>
                    </div>
                    <div class="phase-card-heroes">
                        <div class="phase-hero-dot" style="--c:#1E8449" title="WandaVision"></div>
                        <div class="phase-hero-dot" style="--c:#2471A3" title="Loki"></div>
                        <div class="phase-hero-dot" style="--c:#D4E6F1" title="Moon Knight"></div>
                        <div class="phase-hero-dot" style="--c:#A93226" title="She-Hulk"></div>
                    </div>
                </div>
            </div>
            <div class="phase-card" data-phase-num="5" style="--phase-hue: 260;">
                <div class="phase-card-inner">
                    <div class="phase-card-num">05</div>
                    <div class="phase-card-content">
                        <span class="phase-card-tag">Multiverse Saga</span>
                        <h3 class="phase-card-title">The Kang Dynasty</h3>
                        <p class="phase-card-years">2023 â€“ 2024</p>
                        <p class="phase-card-desc">Kang the Conqueror vĂ  má»‘i Ä‘e dá»a xuyĂªn thá»i gian.</p>
                        <div class="phase-card-count"><span>8</span> tĂ¡c pháº©m</div>
                    </div>
                    <div class="phase-card-heroes">
                        <div class="phase-hero-dot" style="--c:#7D3C98" title="Kang"></div>
                        <div class="phase-hero-dot" style="--c:#922B21" title="Guardians 3"></div>
                        <div class="phase-hero-dot" style="--c:#1F618D" title="Ant-Man 3"></div>
                    </div>
                </div>
            </div>
            <div class="phase-card phase-card--upcoming" data-phase-num="6" style="--phase-hue: 170;">
                <div class="phase-card-inner">
                    <div class="phase-card-num">06</div>
                    <div class="phase-card-content">
                        <span class="phase-card-tag">Multiverse Saga Â· Sáº¯p ra máº¯t</span>
                        <h3 class="phase-card-title">Secret Wars</h3>
                        <p class="phase-card-years">2025 â€“ 2026</p>
                        <p class="phase-card-desc">Avengers: Secret Wars â€” cuá»™c há»™i tá»¥ vÄ© Ä‘áº¡i nháº¥t lá»‹ch sá»­ MCU.</p>
                        <div class="phase-card-count"><span>?</span> tĂ¡c pháº©m</div>
                    </div>
                    <div class="phase-card-heroes">
                        <div class="phase-hero-dot phase-hero-dot--unknown"></div>
                        <div class="phase-hero-dot phase-hero-dot--unknown"></div>
                        <div class="phase-hero-dot phase-hero-dot--unknown"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Timeline section giá»¯ nguyĂªn tá»« index.html â€” quĂ¡ dĂ i nĂªn giá»¯ cá»©ng -->
    <!-- Báº¡n cĂ³ thá»ƒ render Ä‘á»™ng tá»« PHP náº¿u muá»‘n sau nĂ y -->
    <section class="timeline-section" id="timeline">
        <div class="section-header">
            <p class="section-eyebrow">Chronological Order</p>
            <h2 class="section-title">Lá»™ trĂ¬nh xem phim</h2>
            <p class="section-desc">Theo thá»© tá»± thá»i gian trong vÅ© trá»¥ MCU</p>
        </div>
        <div class="timeline-container" id="timeline-container">
            <div class="timeline-spine"><div class="timeline-spine-fill" id="timeline-spine-fill"></div></div>
            <!-- Timeline items Ä‘Æ°á»£c giá»¯ hardcode (quĂ¡ nhiá»u node) -->
            <!-- Trong Ä‘á»“ Ă¡n thá»±c táº¿: dĂ¹ng foreach PHP loop Ä‘á»ƒ render -->
            <p style="text-align:center;color:var(--clr-text-muted);padding:40px 0;">
                đŸ¬ Timeline render tá»« database â€” xem <code>index.html</code> Ä‘á»ƒ láº¥y cáº¥u trĂºc HTML máº«u.
            </p>
        </div>
    </section>

    <!-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• CHARACTERS â€” JS render â•â•â•â•â•â•â• -->
    <section class="characters-section" id="characters">
        <div class="section-header">
            <p class="section-eyebrow">The Heroes</p>
            <h2 class="section-title">Nhá»¯ng nhĂ¢n váº­t chá»§ chá»‘t</h2>
            <p class="section-desc">CĂ¡c anh hĂ¹ng Ä‘á»‹nh hĂ¬nh vÅ© trá»¥ MCU qua tá»«ng Phase</p>
        </div>
        <!-- JS fetch tá»« /api/characters vĂ  render vĂ o Ä‘Ă¢y -->
        <div class="characters-grid" id="characters-grid">
            <div style="grid-column:1/-1;text-align:center;color:var(--clr-text-muted);padding:40px 0;">
                Äang táº£i nhĂ¢n váº­t...
            </div>
        </div>
    </section>

    <!-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• MOVIES â€” JS render â•â•â•â•â•â•â•â•â•â• -->
    <section class="movies-section" id="movies">
        <div class="section-header">
            <p class="section-eyebrow">The Collection</p>
            <h2 class="section-title">ToĂ n bá»™ vÅ© trá»¥ MCU</h2>
        </div>
        <!-- JS fetch tá»« /api/movies vĂ  render vĂ o Ä‘Ă¢y -->
        <div class="movies-grid" id="movies-grid">
            <div style="grid-column:1/-1;text-align:center;color:var(--clr-text-muted);padding:60px 0;">
                Äang táº£i phim...
            </div>
        </div>
    </section>

    <!-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• FOOTER â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• -->
    <footer class="site-footer">
        <div class="footer-inner">
            <div class="footer-logo">
                <span class="logo-mark">M</span>
                <span class="logo-text">MCU<em>verse</em></span>
            </div>
            <div class="footer-links">
                <a href="#timeline"   class="footer-link">Lá»™ trĂ¬nh</a>
                <a href="#movies"     class="footer-link">Phim</a>
                <a href="#characters" class="footer-link">NhĂ¢n váº­t</a>
                <a href="#phases"     class="footer-link">Phases</a>
            </div>
            <p class="footer-copy">Dá»¯ liá»‡u tá»•ng há»£p tá»« Marvel Studios &amp; IMDb. KhĂ´ng pháº£i trang chĂ­nh thá»©c.</p>
        </div>
    </footer>

    <!-- Truyá»n base_url vĂ o JS qua biáº¿n global -->
    <script>
        window.MCU_BASE_URL = '<?= base_url() ?>';
        window.MCU_API      = '<?= base_url('api') ?>';
    </script>
    <script src="<?= base_url('script.js') ?>"></script>
    <script src="<?= base_url('script-part2.js') ?>"></script>

</body>
</html>
