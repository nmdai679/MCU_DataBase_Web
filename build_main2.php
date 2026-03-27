<?php
$html = file_get_contents('old_main_perfect.php');

// 1. Extract Filter Bar
$filter_html = '';
if (preg_match('/(    <!-- ═══════════════════════ FILTER BAR.*?    <\/section>)/s', $html, $matches)) {
    $filter_html = $matches[1];
    // Remove it from current position
    $html = str_replace($filter_html, '', $html);
}

// 2. Inject Dynamic Timeline PHP
$timeline_template = file_get_contents('timeline_template.php');
$timeline_start = "    <!-- ═══════════════════════════════════════════\n       TIMELINE SECTION — DYNAMIC PHP\n    ═══════════════════════════════════════════ -->\n    <section class=\"timeline-section\" id=\"timeline\">\n        <div class=\"section-header\">\n            <p class=\"section-eyebrow\">Chronological Order</p>\n            <h2 class=\"section-title\">Lộ trình xem phim</h2>\n            <p class=\"section-desc\">Theo thứ tự thời gian trong vũ trụ MCU</p>\n        </div>\n\n        <div class=\"timeline-container\" id=\"timeline-container\">\n            <div class=\"timeline-spine\"><div class=\"timeline-spine-fill\" id=\"timeline-spine-fill\"></div></div>\n\n";
$timeline_end = "\n        </div>\n    </section>";
$full_timeline = $timeline_start . $timeline_template . $timeline_end;

$html = preg_replace('/    <!-- Timeline section giữ nguyên.*?<\/section>/s', $full_timeline, $html);

// 3. Inject Filter Bar right before the Movies section
if ($filter_html !== '') {
    $movies_marker = "    <!-- ═══════════════════════ MOVIES — JS render ══════════ -->";
    if (strpos($html, $movies_marker) !== false) {
        $html = str_replace($movies_marker, $filter_html . "\n\n" . $movies_marker, $html);
    } else {
        echo "Movies marker not found!\n";
    }
} else {
    echo "Filter HTML not found!\n";
}

// 4. Empty the JS rendered grids (keep characters section)
$html = preg_replace(
    '/(<div class="characters-grid" id="characters-grid">).*?(    <\/section>)/s',
    "$1\n            <!-- JS fetch từ /api/characters và render vào đây -->\n            <div style=\"grid-column:1/-1;text-align:center;color:var(--clr-text-muted);padding:40px 0;\">Đang tải nhân vật...</div>\n        </div>\n$2",
    $html
);

$html = preg_replace(
    '/(<div class="movies-grid" id="movies-grid">).*?(    <\/section>)/s',
    "$1\n            <!-- JS fetch từ /api/movies và render vào đây -->\n            <div style=\"grid-column:1/-1;text-align:center;color:var(--clr-text-muted);padding:60px 0;\">Đang tải phim...</div>\n        </div>\n$2",
    $html
);

// 5. Fix API URL
$html = str_replace('window.MCU_API      = \'<?= base_url(\'api\') ?>\';', 'window.MCU_API      = \'<?= site_url(\'api\') ?>\';', $html);

file_put_contents('application/views/main.php', $html);
echo "main.php functionally rebuilt.\n";
