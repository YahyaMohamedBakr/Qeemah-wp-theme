<?php
/**
 * Instructors Section
 */
?>
<section class="instructors" id="instructors">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-badge center"><i class="fas fa-chalkboard-teacher"></i><span>المدربون</span></div>
            <h2 class="section-title center">تعرف على نخبة المدربين</h2>
            <p class="section-desc center">مدربون معتمدون بخبرات عملية وأكاديمية واسعة يشاركونك المعرفة والخبرة</p>
        </div>
        <div class="instructors-grid">
            <?php if (function_exists('tutor') && post_type_exists('courses')) :
                $instructor_query = new WP_Query(array('role__in' => tutor()->instructor_role, 'number' => 4, 'orderby' => 'registered', 'order' => 'DESC'));
                if ($instructor_query->have_posts()) :
                    while ($instructor_query->have_posts()) : $instructor_query->the_post();
                        $author_id = get_the_author_meta('ID');
                        $avatar_url = get_avatar_url($author_id, 200);
            ?>
                        <div class="instructor-card" data-aos="fade-up">
                            <div class="instructor-avatar">
                                <img src="<?php echo esc_url($avatar_url); ?>" alt="<?php echo esc_attr(get_the_author()); ?>" style="width:100%;height:100%;object-fit:cover;border-radius:var(--radius-full);">
                                <div class="instructor-social">
                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fas fa-envelope"></i></a>
                                </div>
                            </div>
                            <h3 class="instructor-name"><?php the_author(); ?></h3>
                            <p class="instructor-role"><?php echo esc_html(get_the_author_meta('description') ?: 'مدرب معتمد'); ?></p>
                            <div class="instructor-stats">
                                <span><i class="fas fa-book"></i> <?php echo count_user_posts($author_id, 'courses'); ?> دورة</span>
                                <span><i class="fas fa-users"></i> متدرب</span>
                            </div>
                        </div>
            <?php endwhile; endif; else : ?>
                <div class="section-desc center" style="grid-column:1/-1;">قم بتفعيل بلاجين Tutor LMS وإنشاء حسابات المدربين</div>
            <?php endif; ?>
        </div>
    </div>
</section>
