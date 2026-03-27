<?php foreach ($phases as $p): ?>
    <div class="timeline-phase <?= ($p['phase_num'] == 6) ? 'timeline-phase--upcoming' : '' ?>" data-phase="<?= $p['phase_num'] ?>">
        <div class="timeline-phase-label">
            <span class="phase-tag" <?= ($p['phase_num'] == 6) ? 'style="--phase-tag-clr: #00d4ff; --phase-tag-bg: rgba(0,212,255,0.08);"' : '' ?>>Phase 0<?= $p['phase_num'] ?></span>
            <h3 class="phase-name"><?= htmlspecialchars($p['saga'] . ' — ' . $p['ten_phase']) ?></h3>
            <span class="phase-years"><?= htmlspecialchars($p['years']) ?></span>
        </div>

        <?php 
        foreach ($movies as $m): 
            if ($m['phase_id'] == $p['id']): 
                $isUpcoming = ($p['phase_num'] == 6) ? 'timeline-node--upcoming' : '';
                $isUpcomingCard = ($p['phase_num'] == 6) ? 'timeline-card--upcoming' : '';
                
                $isFeatured = (strpos(strtolower($m['title']), 'avengers') !== false) || ($p['phase_num'] == 6);
                $nodeClass = $isFeatured ? 'timeline-node--milestone' : $isUpcoming;
                $cardClass = $isFeatured ? 'timeline-card--featured' : $isUpcomingCard;
                $cardTypeClass = $isFeatured ? 'timeline-card-type--featured' : '';
        ?>
        <div class="timeline-item <?= $isFeatured ? 'timeline-item--milestone' : '' ?>" data-order="<?= $m['view_order'] ?>" data-type="<?= $m['type'] ?>" data-movie-id="<?= htmlspecialchars($m['slug']) ?>">
            <div class="timeline-node <?= $nodeClass ?>">
                <div class="timeline-node-inner"></div>
            </div>
            <div class="timeline-card <?= $cardClass ?>" data-open-modal="<?= htmlspecialchars($m['slug']) ?>">
                <div class="timeline-card-num"><?= sprintf('%02d', $m['view_order']) ?><?= ($p['phase_num'] == 6) ? '+' : '' ?></div>
                <?php if($isFeatured): ?><div class="timeline-card-milestone-badge">⚡ Sự kiện lớn</div><?php endif; ?>
                <div class="timeline-card-body">
                    <span class="timeline-card-type <?= $cardTypeClass ?>"><?= ($p['phase_num'] == 6) ? 'Sắp ra mắt' : 'Phim điện ảnh' ?></span>
                    <h4 class="timeline-card-title"><?= htmlspecialchars($m['title']) ?></h4>
                    <p class="timeline-card-meta"><?= $m['year'] ?> · Phase <?= $p['phase_num'] ?> · <?= htmlspecialchars($m['duration']) ?></p>
                    <p class="timeline-card-desc"><?= htmlspecialchars($m['description']) ?></p>
                    <div class="timeline-card-tags">
                        <?php 
                        $tags = explode(',', $m['cast_list']);
                        foreach (array_slice($tags, 0, 3) as $tag):
                        ?>
                        <span class="tl-tag"><?= htmlspecialchars(trim($tag)) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="timeline-card-poster">
                    <div class="poster-placeholder" data-title="<?= htmlspecialchars($m['title']) ?>" style="--ph-color:<?= $m['bg_color'] ?>;"></div>
                </div>
            </div>
        </div>
        <?php 
            endif;
        endforeach; 
        ?>
    </div>
<?php endforeach; ?>
