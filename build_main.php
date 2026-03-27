<?php
$html = file_get_contents('old_main_perfect.php');

// 1. Move Filter Section down
if (preg_match('/(    <!-- ═══════════════════════ FILTER BAR.*?    <\/section>)/s', $html, $matches)) {
    $filter_html = $matches[1];
    $html = str_replace($filter_html, '', $html); // remove from top
    
    // Inject it just before MOVIES section
    $movies_marker = '    <!-- ═══════════════════════ MOVIES — JS render ══════════ -->';
    if (strpos($html, $movies_marker) === false) {
        $movies_marker = '    <!-- ═══════════════════════ MOVIE GRID ══════════════════ -->';
    }
    $html = str_replace($movies_marker, $filter_html . "\n\n" . $movies_marker, $html);
}

// 2. Inject Dynamic Timeline PHP
$timeline_template = file_get_contents('timeline_template.php');
$timeline_start = "    <!-- ═══════════════════════════════════════════\n       TIMELINE SECTION — DYNAMIC PHP\n    ═══════════════════════════════════════════ -->\n    <section class=\"timeline-section\" id=\"timeline\">\n        <div class=\"section-header\">\n            <p class=\"section-eyebrow\">Chronological Order</p>\n            <h2 class=\"section-title\">Lộ trình xem phim</h2>\n            <p class=\"section-desc\">Theo thứ tự thời gian trong vũ trụ MCU</p>\n        </div>\n\n        <div class=\"timeline-container\" id=\"timeline-container\">\n            <div class=\"timeline-spine\"><div class=\"timeline-spine-fill\" id=\"timeline-spine-fill\"></div></div>\n\n";

$timeline_end = "\n        </div>\n    </section>";
$full_timeline = $timeline_start . $timeline_template . $timeline_end;

// Replace the old timeline section
if (preg_match('/    <!-- Timeline section giữ nguyên.*?</s', $html)) {
    // Tùy thuộc vào version comment, ta có thể replace trực tiếp <section ... id="timeline"> tới </section>
    $html = preg_replace('/    <!-- Timeline section giữ nguyên.*?<\/section>/s', $full_timeline, $html);
}

// 3. Fix API URL if it's currently hardcoded to base_url('api') to use site_url('api') instead.
$html = str_replace('window.MCU_API      = \'<?= base_url(\'api\') ?>\';', 'window.MCU_API      = \'<?= site_url(\'api\') ?>\';', $html);
$html = str_replace('window.MCU_API      = \'<?= site_url(\'api\') ?>\';', 'window.MCU_API      = \'<?= site_url(\'api\') ?>\';', $html); // double safe

file_put_contents('application/views/main.php', $html);
echo "main.php perfectly rebuilt from old_main_perfect.php.\n";
