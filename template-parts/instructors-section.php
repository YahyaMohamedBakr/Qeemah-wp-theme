<?php
/**
 * Instructors Section — Dynamic from CPT: qimah_instructor
 */
$count = get_theme_mod('qimah_instructors_count', 8);
$instructor_query = new WP_Query(array(
    'post_type'      => 'qimah_instructor',
    'posts_per_page' => $count,
    'orderby'        => 'menu_order date',
    'order'          => 'ASC',
    'post_status'    => 'publish',
));
?>
<section class="instructors" id="instructors">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-badge center"><i class="fas fa-chalkboard-teacher"></i><span>المدربون</span></div>
            <h2 class="section-title center">تعرف على نخبة المدربين</h2>
            <p class="section-desc center">مدربون معتمدون بخبرات عملية وأكاديمية واسعة يشاركونك المعرفة والخبرة</p>
        </div>
        <?php if ($instructor_query->have_posts()) : ?>
        <div class="instructors-grid">
            <?php while ($instructor_query->have_posts()) : $instructor_query->the_post();
                $post_id        = get_the_ID();
                $avatar_url     = get_the_post_thumbnail_url($post_id, 'instructor-thumb');
                $specialization = get_post_meta($post_id, '_qimah_instructor_specialization', true);
                $courses_count  = get_post_meta($post_id, '_qimah_instructor_courses_count', true);
                $students_count = get_post_meta($post_id, '_qimah_instructor_students_count', true);
                $rating         = get_post_meta($post_id, '_qimah_instructor_rating', true);
                $linkedin       = get_post_meta($post_id, '_qimah_instructor_linkedin', true);
                $twitter        = get_post_meta($post_id, '_qimah_instructor_twitter', true);
                $email          = get_post_meta($post_id, '_qimah_instructor_email', true);

                if (!$avatar_url) {
                    $avatar_url = QIMAH_URI . '/assets/images/default-avatar.png';
                }
            ?>
                <div class="instructor-card" data-aos="fade-up">
                    <div class="instructor-avatar">
                        <img src="<?php echo esc_url($avatar_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" style="width:100%;height:100%;object-fit:cover;border-radius:var(--radius-full);">
                        <?php if ($linkedin || $twitter || $email) : ?>
                        <div class="instructor-social">
                            <?php if ($linkedin) : ?><a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener"><i class="fab fa-linkedin-in"></i></a><?php endif; ?>
                            <?php if ($twitter) : ?><a href="<?php echo esc_url($twitter); ?>" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a><?php endif; ?>
                            <?php if ($email) : ?><a href="mailto:<?php echo esc_attr($email); ?>"><i class="fas fa-envelope"></i></a><?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <h3 class="instructor-name"><?php the_title(); ?></h3>
                    <p class="instructor-role"><?php echo esc_html($specialization ?: get_the_excerpt()); ?></p>
                    <div class="instructor-stats">
                        <?php if ($courses_count) : ?>
                            <span><i class="fas fa-book"></i> <?php echo intval($courses_count); ?> دورة</span>
                        <?php endif; ?>
                        <?php if ($students_count) : ?>
                            <span><i class="fas fa-users"></i> <?php echo intval($students_count); ?> متدرب</span>
                        <?php endif; ?>
                        <?php if ($rating) : ?>
                            <span><i class="fas fa-star"></i> <?php echo esc_html($rating); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
        <?php else : ?>
            <div class="section-desc center" style="grid-column:1/-1;">
                <p>لم يتم إضافة مدربين بعد. <a href="<?php echo esc_url(admin_url('post-new.php?post_type=qimah_instructor')); ?>">إضافة مدرب جديد</a></p>
            </div>
        <?php endif; ?>
    </div>
</section>
