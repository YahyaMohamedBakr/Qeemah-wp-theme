<?php
/**
 * Stats Section
 */
$stats = array(
    array('icon' => 'fa-user-graduate', 'count' => 5000, 'label' => 'متدرب مسجل'),
    array('icon' => 'fa-book', 'count' => 150, 'label' => 'دورة تدريبية'),
    array('icon' => 'fa-chalkboard-teacher', 'count' => 50, 'label' => 'مدرب متخصص'),
    array('icon' => 'fa-certificate', 'count' => 1200, 'label' => 'شهادة صادرة'),
);
?>
<section class="stats" id="stats">
    <div class="container">
        <div class="stats-grid">
            <?php foreach ($stats as $i => $stat) : ?>
                <div class="stat-card" data-aos="fade-up" data-aos-delay="<?php echo ($i + 1) * 100; ?>">
                    <div class="stat-icon"><i class="fas <?php echo esc_attr($stat['icon']); ?>"></i></div>
                    <div class="stat-number" data-count="<?php echo esc_attr($stat['count']); ?>">0</div>
                    <div class="stat-label"><?php echo esc_html($stat['label']); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
