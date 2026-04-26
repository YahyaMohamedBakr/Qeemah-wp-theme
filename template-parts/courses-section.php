<?php
/**
 * Courses Section - Shows latest Tutor LMS courses
 */
$courses_count = get_theme_mod('qimah_courses_count', 6);
$courses = array();
if (post_type_exists('courses')) {
    $courses = get_posts(array('post_type' => 'courses', 'posts_per_page' => $courses_count, 'post_status' => 'publish'));
}
?>
<section class="courses" id="courses">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-badge center"><i class="fas fa-book-open"></i><span>الدورات</span></div>
            <h2 class="section-title center">الدورات التدريبية المميزة</h2>
            <p class="section-desc center">اكتشف مجموعتنا المتميزة من الدورات التدريبية المصممة بعناية لتلبية احتياجاتك التعليمية والمهنية</p>
        </div>
        <div class="courses-filter" data-aos="fade-up">
            <button class="filter-btn active" data-filter="all">الكل</button>
            <button class="filter-btn" data-filter="remote">عن بعد</button>
            <button class="filter-btn" data-filter="recorded">مسجلة</button>
            <button class="filter-btn" data-filter="free">مجانية</button>
        </div>
        <div class="courses-grid">
            <?php if (!empty($courses)) : foreach ($courses as $course) : qimah_course_card($course->ID); endforeach; else : ?>
                <div class="section-desc center" style="grid-column:1/-1;padding:40px 0;">
                    <p>قم بتفعيل بلاجين Tutor LMS وإضافة دورات من <a href="<?php echo esc_url(admin_url('post-new.php?post_type=courses')); ?>">هنا</a></p>
                </div>
            <?php endif; ?>
        </div>
        <div class="section-action" data-aos="fade-up">
            <a href="<?php echo esc_url(get_post_type_archive_link('courses')); ?>" class="btn btn-primary btn-lg">
                <span>عرض جميع الدورات</span>
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
    </div>
</section>
