<?php
/**
 * Single Instructor Profile Page
 * Template for qimah_instructor CPT
 */
get_header();

$post_id        = get_the_ID();
$avatar_url     = get_the_post_thumbnail_url($post_id, 'large');
$specialization = get_post_meta($post_id, '_qimah_instructor_specialization', true);
$courses_count  = get_post_meta($post_id, '_qimah_instructor_courses_count', true);
$students_count = get_post_meta($post_id, '_qimah_instructor_students_count', true);
$rating         = get_post_meta($post_id, '_qimah_instructor_rating', true);
$linkedin       = get_post_meta($post_id, '_qimah_instructor_linkedin', true);
$twitter        = get_post_meta($post_id, '_qimah_instructor_twitter', true);
$email          = get_post_meta($post_id, '_qimah_instructor_email', true);
$bio            = get_the_content();

if (!$avatar_url) {
    $avatar_url = QIMAH_URI . '/assets/images/default-avatar.png';
}
?>

<!-- Page Banner -->
<div class="page-banner">
    <div class="container">
        <div class="page-banner-content" data-aos="fade-up">
            <h1><?php the_title(); ?></h1>
            <?php if ($specialization) : ?>
                <p style="color:rgba(255,255,255,0.85);font-size:1.05rem;margin-top:8px;"><?php echo esc_html($specialization); ?></p>
            <?php endif; ?>
            <?php qimah_breadcrumb(); ?>
        </div>
    </div>
</div>

<!-- Instructor Profile -->
<section class="instructor-profile-section">
    <div class="container">
        <div class="instructor-profile-layout">

            <!-- Sidebar Card -->
            <aside class="instructor-profile-sidebar" data-aos="fade-right">
                <div class="instructor-profile-card">
                    <!-- Avatar -->
                    <div class="instructor-profile-avatar-wrap">
                        <img src="<?php echo esc_url($avatar_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                        <?php if ($rating) : ?>
                            <div class="instructor-profile-badge">
                                <i class="fas fa-star"></i>
                                <span><?php echo esc_html($rating); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Name & Title -->
                    <div class="instructor-profile-info">
                        <h2><?php the_title(); ?></h2>
                        <?php if ($specialization) : ?>
                            <p class="instructor-profile-spec"><?php echo esc_html($specialization); ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Stats -->
                    <div class="instructor-profile-stats">
                        <?php if ($courses_count) : ?>
                            <div class="instructor-profile-stat">
                                <i class="fas fa-book-open"></i>
                                <span class="instructor-profile-stat-number"><?php echo intval($courses_count); ?></span>
                                <span class="instructor-profile-stat-label">دورة تدريبية</span>
                            </div>
                        <?php endif; ?>
                        <?php if ($students_count) : ?>
                            <div class="instructor-profile-stat">
                                <i class="fas fa-user-graduate"></i>
                                <span class="instructor-profile-stat-number"><?php echo intval($students_count); ?></span>
                                <span class="instructor-profile-stat-label">متدرب</span>
                            </div>
                        <?php endif; ?>
                        <?php if ($rating) : ?>
                            <div class="instructor-profile-stat">
                                <i class="fas fa-star"></i>
                                <span class="instructor-profile-stat-number"><?php echo esc_html($rating); ?></span>
                                <span class="instructor-profile-stat-label">تقييم</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Social Links -->
                    <?php if ($linkedin || $twitter || $email) : ?>
                        <div class="instructor-profile-social">
                            <?php if ($linkedin) : ?>
                                <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener" class="instructor-social-btn linkedin" aria-label="LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            <?php endif; ?>
                            <?php if ($twitter) : ?>
                                <a href="<?php echo esc_url($twitter); ?>" target="_blank" rel="noopener" class="instructor-social-btn twitter" aria-label="Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            <?php endif; ?>
                            <?php if ($email) : ?>
                                <a href="mailto:<?php echo esc_attr($email); ?>" class="instructor-social-btn email" aria-label="Email">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Contact Button -->
                    <?php if ($email) : ?>
                        <a href="mailto:<?php echo esc_attr($email); ?>" class="instructor-contact-btn">
                            <i class="fas fa-paper-plane"></i>
                            تواصل مع المدرب
                        </a>
                    <?php endif; ?>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="instructor-profile-main" data-aos="fade-left">
                <!-- Bio Section -->
                <div class="instructor-profile-block">
                    <div class="instructor-profile-block-header">
                        <i class="fas fa-user-circle"></i>
                        <h2>نبذة تعريفية</h2>
                    </div>
                    <div class="instructor-profile-bio">
                        <?php if ($bio) : ?>
                            <?php the_content(); ?>
                        <?php else : ?>
                            <p>لا توجد نبذة تعريفية متاحة حالياً.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Expertise / Specialization Section -->
                <?php if ($specialization) : ?>
                <div class="instructor-profile-block">
                    <div class="instructor-profile-block-header">
                        <i class="fas fa-award"></i>
                        <h2>مجال التخصص</h2>
                    </div>
                    <div class="instructor-profile-expertise">
                        <div class="instructor-expertise-badge">
                            <i class="fas fa-check-circle"></i>
                            <span><?php echo esc_html($specialization); ?></span>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Stats Detail Section -->
                <?php if ($courses_count || $students_count || $rating) : ?>
                <div class="instructor-profile-block">
                    <div class="instructor-profile-block-header">
                        <i class="fas fa-chart-bar"></i>
                        <h2>الإحصائيات والإنجازات</h2>
                    </div>
                    <div class="instructor-profile-achievements">
                        <?php if ($courses_count) : ?>
                            <div class="instructor-achievement-card">
                                <div class="instructor-achievement-icon" style="background:var(--primary-lighter);color:var(--primary);">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <div class="instructor-achievement-text">
                                    <span class="instructor-achievement-number"><?php echo intval($courses_count); ?></span>
                                    <span class="instructor-achievement-label">دورة تدريبية</span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ($students_count) : ?>
                            <div class="instructor-achievement-card">
                                <div class="instructor-achievement-icon" style="background:#d1fae5;color:#10b981;">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <div class="instructor-achievement-text">
                                    <span class="instructor-achievement-number"><?php echo intval($students_count); ?></span>
                                    <span class="instructor-achievement-label">متدرب مسجل</span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ($rating) : ?>
                            <div class="instructor-achievement-card">
                                <div class="instructor-achievement-icon" style="background:var(--secondary-lighter);color:var(--secondary-dark);">
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="instructor-achievement-text">
                                    <span class="instructor-achievement-number"><?php echo esc_html($rating); ?></span>
                                    <span class="instructor-achievement-label">من 5 تقييم</span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Social Media Links Section -->
                <?php if ($linkedin || $twitter || $email) : ?>
                <div class="instructor-profile-block">
                    <div class="instructor-profile-block-header">
                        <i class="fas fa-share-alt"></i>
                        <h2>تواصل مع المدرب</h2>
                    </div>
                    <div class="instructor-profile-links-list">
                        <?php if ($email) : ?>
                            <a href="mailto:<?php echo esc_attr($email); ?>" class="instructor-link-item">
                                <div class="instructor-link-icon" style="background:var(--primary-lighter);color:var(--primary);">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="instructor-link-text">
                                    <span class="instructor-link-label">البريد الإلكتروني</span>
                                    <span class="instructor-link-value" dir="ltr"><?php echo esc_html($email); ?></span>
                                </div>
                                <i class="fas fa-chevron-left instructor-link-arrow"></i>
                            </a>
                        <?php endif; ?>
                        <?php if ($linkedin) : ?>
                            <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener" class="instructor-link-item">
                                <div class="instructor-link-icon" style="background:#0077b5;color:#fff;">
                                    <i class="fab fa-linkedin-in"></i>
                                </div>
                                <div class="instructor-link-text">
                                    <span class="instructor-link-label">LinkedIn</span>
                                    <span class="instructor-link-value">ملف LinkedIn الشخصي</span>
                                </div>
                                <i class="fas fa-chevron-left instructor-link-arrow"></i>
                            </a>
                        <?php endif; ?>
                        <?php if ($twitter) : ?>
                            <a href="<?php echo esc_url($twitter); ?>" target="_blank" rel="noopener" class="instructor-link-item">
                                <div class="instructor-link-icon" style="background:#1da1f2;color:#fff;">
                                    <i class="fab fa-twitter"></i>
                                </div>
                                <div class="instructor-link-text">
                                    <span class="instructor-link-label">Twitter / X</span>
                                    <span class="instructor-link-value">حساب تويتر</span>
                                </div>
                                <i class="fas fa-chevron-left instructor-link-arrow"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Back to Instructors -->
                <div class="instructor-profile-back">
                    <a href="<?php echo esc_url(home_url('/#instructors')); ?>" class="btn btn-outline">
                        <i class="fas fa-arrow-right"></i>
                        العودة لقسم المدربين
                    </a>
                </div>
            </main>
        </div>
    </div>
</section>

<?php get_footer(); ?>
