<?php
/**
 * Template Name: صفحة الدورة المفردة
 * Description: صفحة تفاصيل الدورة متوافقة مع Tutor LMS
 */
get_header();
get_template_part('template-parts/page-banner');
?>
<main class="course-page">
    <div class="container">
        <div class="course-layout">
            <!-- Main Content -->
            <div class="course-main">
                <?php while (have_posts()) : the_post(); ?>
                    <!-- Course Hero Image -->
                    <div class="course-hero" data-aos="fade-up">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('large'); ?>
                        <?php else : ?>
                            <div class="course-hero-img"><i class="fas fa-graduation-cap"></i></div>
                        <?php endif; ?>
                    </div>

                    <!-- Course Info Bar -->
                    <div class="course-info-bar" data-aos="fade-up">
                        <div class="course-info-bar-item">
                            <?php $instructor = get_post_meta(get_the_ID(), '_tutor_instructor', true); ?>
                            <?php if ($instructor) : ?>
                                <a href="<?php echo esc_url(get_permalink($instructor)); ?>" class="course-info-bar-avatar"><i class="fas fa-user-tie"></i></a>
                                <strong><?php echo esc_html(get_the_title($instructor)); ?></strong>
                            <?php endif; ?>
                        </div>
                        <div class="course-info-bar-divider"></div>
                        <div class="course-info-bar-item">
                            <i class="fas fa-signal"></i>
                            <span>المستوى: <strong><?php echo esc_html(get_post_meta(get_the_ID(), '_tutor_course_level', true) ?: 'جميع المستويات'); ?></strong></span>
                        </div>
                        <div class="course-info-bar-divider"></div>
                        <div class="course-info-bar-item">
                            <i class="fas fa-play-circle"></i>
                            <span><strong><?php echo function_exists('tutor_utils') ? intval(tutor_utils()->get_lesson_count_by_course(get_the_ID())) : 0; ?></strong> درس</span>
                        </div>
                        <div class="course-info-bar-divider"></div>
                        <div class="course-info-bar-item">
                            <i class="fas fa-users"></i>
                            <span><strong><?php echo intval(get_post_meta(get_the_ID(), '_tutor_enrolled', true)); ?></strong> متدرب</span>
                        </div>
                    </div>

                    <!-- Course Description -->
                    <div class="course-section" data-aos="fade-up">
                        <h2 class="course-section-title"><i class="fas fa-info-circle"></i> وصف الدورة</h2>
                        <div class="course-desc-text"><?php the_content(); ?></div>
                    </div>

                    <!-- Curriculum -->
                    <div class="course-section" data-aos="fade-up">
                        <h2 class="course-section-title"><i class="fas fa-list-ol"></i> المنهج الدراسي</h2>
                        <div class="curriculum-accordion">
                            <?php
                            // Method 1: Get lessons via direct query
                            $course_topics = array();
                            if (function_exists('tutor_utils')) {
                                $raw_topics = tutor_utils()->get_course_topics(get_the_ID());
                                if (is_array($raw_topics) && !empty($raw_topics)) {
                                    foreach ($raw_topics as $tp) {
                                        $tp_id = isset($tp->comment_ID) ? $tp->comment_ID : $tp->ID;
                                        $tp_lessons = tutor_lessons()->get_lessons_by_topic($tp_id);
                                        $tp_lessons = is_array($tp_lessons) ? $tp_lessons : array();
                                        $course_topics[] = array(
                                            'title'   => $tp->post_title,
                                            'lessons' => $tp_lessons,
                                        );
                                    }
                                }
                            }
                            // Fallback: if no topics, get all lessons directly
                            if (empty($course_topics)) {
                                $direct_lessons = qimah_get_course_lessons(get_the_ID());
                                if (!empty($direct_lessons)) {
                                    $course_topics[] = array(
                                        'title'   => 'الدروس',
                                        'lessons' => $direct_lessons,
                                    );
                                }
                            }

                            if (!empty($course_topics)) :
                            foreach ($course_topics as $topic_data) :
                                $topic_lessons = $topic_data['lessons'];
                                $topic_title = $topic_data['title'];
                                $lesson_count = count($topic_lessons);
                            ?>
                            <div class="curriculum-section">
                                <div class="curriculum-section-header">
                                    <div class="curriculum-section-header-right">
                                        <div class="curriculum-section-icon"><i class="fas fa-folder"></i></div>
                                        <div>
                                            <div class="curriculum-section-title"><?php echo esc_html($topic_title); ?></div>
                                            <div class="curriculum-section-meta"><?php echo intval($lesson_count); ?> درس</div>
                                        </div>
                                    </div>
                                    <div class="curriculum-section-toggle"><i class="fas fa-chevron-down"></i></div>
                                </div>
                                <div class="curriculum-section-body">
                                    <?php foreach ($topic_lessons as $lesson) : ?>
                                    <a href="<?php echo esc_url(get_permalink($lesson->ID)); ?>" class="lesson-item" style="text-decoration:none;display:flex;align-items:center;justify-content:space-between;padding:12px 20px;border-top:1px solid var(--gray-100);transition:var(--transition-base);">
                                        <div class="lesson-item-right">
                                            <div class="lesson-type-icon video"><i class="fas fa-play"></i></div>
                                            <span class="lesson-name"><?php echo esc_html($lesson->post_title); ?></span>
                                        </div>
                                        <div class="lesson-item-left">
                                            <span class="lesson-duration"><?php echo esc_html(get_post_meta($lesson->ID, '_lesson_duration', true)); ?></span>
                                        </div>
                                    </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endforeach;
                            else : ?>
                            <p style="color:var(--text-muted);padding:20px 0;text-align:center;">لم يتم إضافة منهج دراسي لهذه الدورة بعد.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Instructor Bio -->
                    <?php if ($instructor) : ?>
                    <div class="course-section" data-aos="fade-up">
                        <h2 class="course-section-title"><i class="fas fa-user-tie"></i> المدرب</h2>
                        <div class="instructor-bio-box">
                            <div class="instructor-bio-avatar">
                                <?php echo get_avatar($instructor, 90); ?>
                            </div>
                            <div class="instructor-bio-info">
                                <h3 class="instructor-bio-name"><?php echo esc_html(get_the_title($instructor)); ?></h3>
                                <p class="instructor-bio-title"><?php echo esc_html(get_the_author_meta('description', $instructor) ?: 'مدرب معتمد في مركز قيمة وقدوة'); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Comments -->
                    <?php if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif; ?>

                <?php endwhile; ?>
            </div>

            <!-- Sidebar -->
            <aside class="course-sidebar">
                <div class="sidebar-card">
                    <div class="sidebar-card-price-area">
                        <?php
                        $price = get_post_meta(get_the_ID(), '_tutor_course_price', true);
                        if (empty($price) || $price === '0') :
                            echo '<div class="sidebar-price-current">مجاني</div>';
                        else :
                            echo '<div class="sidebar-price-current"><span>' . esc_html($price) . '</span><small>ر.س</small></div>';
                        endif;
                        ?>
                    </div>
                    <div class="sidebar-card-body">
                        <?php
                        $course_id = get_the_ID();
                        $is_enrolled = qimah_is_user_enrolled($course_id);
                        $auth_page = get_page_by_path('login');
                        $auth_url = $auth_page ? add_query_arg('redirect_to', urlencode(get_permalink($course_id)), get_permalink($auth_page->ID)) : wp_login_url(get_permalink($course_id));
                        $first_lesson_url = qimah_get_course_first_lesson_url($course_id);
                        if ($is_enrolled) :
                        ?>
                        <a href="<?php echo esc_url($first_lesson_url); ?>" class="sidebar-enroll-btn enrolled"><i class="fas fa-play"></i> ابدأ التعلم الآن</a>
                        <?php elseif (is_user_logged_in()) :
                            // Logged in but not enrolled - use Tutor LMS enrollment
                        ?>
                        <a href="<?php echo esc_url($first_lesson_url); ?>" class="sidebar-enroll-btn" id="qimahEnrollBtn" data-course-id="<?php echo esc_attr($course_id); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce('tutor_enroll_' . $course_id)); ?>">سجّل في الدورة الآن</a>
                        <?php else :
                            // Not logged in - redirect to login/register page
                        ?>
                        <a href="<?php echo esc_url($auth_url); ?>" class="sidebar-enroll-btn">سجّل في الدورة الآن</a>
                        <?php endif; ?>
                        <div class="sidebar-features">
                            <div class="sidebar-feature"><i class="fas fa-play-circle"></i> <?php echo function_exists('tutor_utils') ? intval(tutor_utils()->get_lesson_count_by_course(get_the_ID())) : 0; ?> درس</div>
                            <div class="sidebar-feature"><i class="fas fa-clock"></i> مدى الحياة</div>
                            <div class="sidebar-feature"><i class="fas fa-certificate"></i> شهادة</div>
                            <div class="sidebar-feature"><i class="fas fa-mobile-alt"></i> متوافق مع الجوال</div>
                        </div>
                        <div class="sidebar-share">
                            <div class="sidebar-share-title">مشاركة الدورة</div>
                            <div class="sidebar-share-links">
                                <a href="#" class="sidebar-share-link twitter"><i class="fab fa-x-twitter"></i></a>
                                <a href="#" class="sidebar-share-link linkedin"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#" class="sidebar-share-link whatsapp"><i class="fab fa-whatsapp"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</main>
<?php get_footer(); ?>
