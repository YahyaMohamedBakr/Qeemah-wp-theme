<?php
/**
 * Categories Section - Uses Tutor LMS course categories if available
 */
$categories = array();
if (taxonomy_exists('course-category')) {
    $terms = get_terms(array('taxonomy' => 'course-category', 'hide_empty' => true, 'number' => 6));
    if (!is_wp_error($terms)) {
        $categories = $terms;
    }
}
if (empty($categories)) {
    $categories = array(
        (object) array('name' => 'بناء الأسرة', 'count' => 12, 'slug' => ''),
        (object) array('name' => 'الإدارة والقيادة', 'count' => 18, 'slug' => ''),
        (object) array('name' => 'إدارة المشاريع', 'count' => 8, 'slug' => ''),
        (object) array('name' => 'التطوير الذاتي', 'count' => 22, 'slug' => ''),
        (object) array('name' => 'المهارات الرقمية', 'count' => 15, 'slug' => ''),
        (object) array('name' => 'مهارات التواصل', 'count' => 10, 'slug' => ''),
    );
}
$icons = array('fa-home', 'fa-briefcase', 'fa-project-diagram', 'fa-heart', 'fa-laptop-code', 'fa-comments');
?>
<section class="categories" id="categories">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-badge center"><i class="fas fa-layer-group"></i><span>التصنيفات</span></div>
            <h2 class="section-title center">تصنيفات الدورات التدريبية</h2>
            <p class="section-desc center">اختر من بين مجموعة متنوعة من التصنيفات التي تناسب احتياجاتك التدريبية وتطلعاتك المهنية</p>
        </div>
        <div class="categories-grid">
            <?php foreach ($categories as $i => $cat) :
                $icon = isset($icons[$i]) ? $icons[$i] : 'fa-folder';
                $count = is_object($cat) ? ($cat->count ?? 0) : $cat['count'];
                $name = is_object($cat) ? $cat->name : $cat['name'];
                $link = is_object($cat) && isset($cat->slug) && $cat->slug ? get_term_link($cat) : '#';
                ?>
                <a href="<?php echo esc_url($link); ?>" class="category-card" data-aos="fade-up" data-aos-delay="<?php echo ($i + 1) * 100; ?>">
                    <div class="category-icon"><i class="fas <?php echo esc_attr($icon); ?>"></i></div>
                    <h3 class="category-name"><?php echo esc_html($name); ?></h3>
                    <p class="category-count"><?php echo intval($count); ?> دورة</p>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
