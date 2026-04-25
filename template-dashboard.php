<?php
/**
 * Template Name: لوحة التحكم
 * Description: لوحة تحكم المتدرب متوافقة مع Tutor LMS بنفس ستايل التمبلت
 */

if (!is_user_logged_in()) {
    wp_redirect(home_url('/login'));
    exit;
}

$current_user = wp_get_current_user();
$user_id = get_current_user_id();
$active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'courses';
$valid_tabs = array('courses', 'profile', 'certificates', 'quiz', 'orders');
if (!in_array($active_tab, $valid_tabs)) $active_tab = 'courses';

// Get enrolled courses
$enrolled_courses = array();
if (function_exists('tutor_utils')) {
    $enrolled_courses_ids = tutor_utils()->get_enrolled_courses_by_user($user_id);
    foreach ($enrolled_courses_ids as $course_obj) {
        $cid = $course_obj->ID;
        $enrolled_courses[] = array(
            'id'        => $cid,
            'title'     => get_the_title($cid),
            'permalink' => get_permalink($cid),
            'thumbnail' => get_the_post_thumbnail_url($cid, 'course-thumb'),
            'progress'  => tutor_utils()->get_course_completed_percent($cid, $user_id),
        );
    }
}

// Get completed courses count
$completed_count = 0;
$in_progress_count = 0;
foreach ($enrolled_courses as $ec) {
    if (intval($ec['progress']) >= 100) {
        $completed_count++;
    } else {
        $in_progress_count++;
    }
}

// Get certificates
$certificates = array();
if (function_exists('tutor_utils')) {
    $cert_query = new WP_Query(array(
        'post_type'      => 'tutor_certificate',
        'author'         => $user_id,
        'posts_per_page' => 20,
    ));
    if ($cert_query->have_posts()) {
        while ($cert_query->have_posts()) {
            $cert_query->the_post();
            $certificates[] = array(
                'id'        => get_the_ID(),
                'title'     => get_the_title(),
                'course_id' => get_post_meta(get_the_ID(), '_tutor_certificate_course', true),
                'date'      => get_the_date(),
            );
        }
    }
    wp_reset_postdata();
}

get_header();
?>

<!-- Dashboard Banner -->
<div class="dashboard-banner">
    <div class="dashboard-banner-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
    <div class="container">
        <div class="dashboard-banner-content" data-aos="fade-up">
            <div class="dashboard-user-avatar">
                <?php echo get_avatar($user_id, 80); ?>
                <span class="dashboard-user-online"><i class="fas fa-circle"></i></span>
            </div>
            <div class="dashboard-user-info">
                <h1>مرحباً، <?php echo esc_html($current_user->display_name); ?></h1>
                <p>إليك ملخص حسابك وتقدمك في الدورات التدريبية</p>
            </div>
            <div class="dashboard-user-actions">
                <a href="<?php echo esc_url(home_url('/courses')); ?>" class="btn btn-white btn-sm">
                    <i class="fas fa-plus"></i> استكشف الدورات
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Dashboard Stats -->
<div class="dashboard-stats">
    <div class="container">
        <div class="dashboard-stats-grid" data-aos="fade-up" data-aos-delay="100">
            <div class="dashboard-stat-card">
                <div class="dashboard-stat-icon"><i class="fas fa-book-open"></i></div>
                <div class="dashboard-stat-info">
                    <span class="dashboard-stat-number"><?php echo count($enrolled_courses); ?></span>
                    <span class="dashboard-stat-label">دورات مسجلة</span>
                </div>
            </div>
            <div class="dashboard-stat-card">
                <div class="dashboard-stat-icon active"><i class="fas fa-spinner"></i></div>
                <div class="dashboard-stat-info">
                    <span class="dashboard-stat-number"><?php echo $in_progress_count; ?></span>
                    <span class="dashboard-stat-label">قيد التعلم</span>
                </div>
            </div>
            <div class="dashboard-stat-card">
                <div class="dashboard-stat-icon success"><i class="fas fa-check-circle"></i></div>
                <div class="dashboard-stat-info">
                    <span class="dashboard-stat-number"><?php echo $completed_count; ?></span>
                    <span class="dashboard-stat-label">مكتملة</span>
                </div>
            </div>
            <div class="dashboard-stat-card">
                <div class="dashboard-stat-icon gold"><i class="fas fa-certificate"></i></div>
                <div class="dashboard-stat-info">
                    <span class="dashboard-stat-number"><?php echo count($certificates); ?></span>
                    <span class="dashboard-stat-label">شهادة</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dashboard Content -->
<div class="dashboard-content">
    <div class="container">
        <div class="dashboard-layout">
            <!-- Sidebar Navigation -->
            <aside class="dashboard-sidebar" data-aos="fade-right">
                <nav class="dashboard-nav">
                    <a href="<?php echo esc_url(add_query_arg('tab', 'courses', get_permalink())); ?>" class="dashboard-nav-item <?php echo $active_tab === 'courses' ? 'active' : ''; ?>">
                        <i class="fas fa-graduation-cap"></i>
                        <span>دوراتي</span>
                        <?php if (count($enrolled_courses) > 0) : ?>
                            <span class="dashboard-nav-badge"><?php echo count($enrolled_courses); ?></span>
                        <?php endif; ?>
                    </a>
                    <a href="<?php echo esc_url(add_query_arg('tab', 'profile', get_permalink())); ?>" class="dashboard-nav-item <?php echo $active_tab === 'profile' ? 'active' : ''; ?>">
                        <i class="fas fa-user-cog"></i>
                        <span>الملف الشخصي</span>
                    </a>
                    <a href="<?php echo esc_url(add_query_arg('tab', 'certificates', get_permalink())); ?>" class="dashboard-nav-item <?php echo $active_tab === 'certificates' ? 'active' : ''; ?>">
                        <i class="fas fa-award"></i>
                        <span>الشهادات</span>
                        <?php if (count($certificates) > 0) : ?>
                            <span class="dashboard-nav-badge"><?php echo count($certificates); ?></span>
                        <?php endif; ?>
                    </a>
                    <a href="<?php echo esc_url(add_query_arg('tab', 'quiz', get_permalink())); ?>" class="dashboard-nav-item <?php echo $active_tab === 'quiz' ? 'active' : ''; ?>">
                        <i class="fas fa-clipboard-check"></i>
                        <span>الاختبارات</span>
                    </a>
                    <a href="<?php echo esc_url(add_query_arg('tab', 'orders', get_permalink())); ?>" class="dashboard-nav-item <?php echo $active_tab === 'orders' ? 'active' : ''; ?>">
                        <i class="fas fa-receipt"></i>
                        <span>الطلبات</span>
                    </a>
                    <div class="dashboard-nav-divider"></div>
                    <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="dashboard-nav-item dashboard-nav-logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>تسجيل الخروج</span>
                    </a>
                </nav>
            </aside>

            <!-- Main Content Area -->
            <div class="dashboard-main" data-aos="fade-up">

                <!-- ====== TAB: My Courses ====== -->
                <?php if ($active_tab === 'courses') : ?>
                <div class="dashboard-panel">
                    <div class="dashboard-panel-header">
                        <h2><i class="fas fa-graduation-cap"></i> دوراتي المسجلة</h2>
                        <a href="<?php echo esc_url(home_url('/courses')); ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> تصفح المزيد</a>
                    </div>

                    <?php if (!empty($enrolled_courses)) : ?>
                    <div class="dashboard-courses-grid">
                        <?php foreach ($enrolled_courses as $course) : ?>
                        <div class="dashboard-course-card">
                            <div class="dashboard-course-img">
                                <?php if ($course['thumbnail']) : ?>
                                    <img src="<?php echo esc_url($course['thumbnail']); ?>" alt="<?php echo esc_attr($course['title']); ?>">
                                <?php else : ?>
                                    <div class="course-img-placeholder"><i class="fas fa-graduation-cap"></i></div>
                                <?php endif; ?>
                                <?php if (intval($course['progress']) >= 100) : ?>
                                    <div class="dashboard-course-badge completed"><i class="fas fa-check"></i> مكتملة</div>
                                <?php endif; ?>
                            </div>
                            <div class="dashboard-course-info">
                                <h3><a href="<?php echo esc_url($course['permalink']); ?>"><?php echo esc_html($course['title']); ?></a></h3>
                                <div class="dashboard-course-progress">
                                    <div class="progress-bar-wrap">
                                        <div class="progress-bar" style="width: <?php echo intval($course['progress']); ?>%;">
                                            <span><?php echo intval($course['progress']); ?>%</span>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?php echo esc_url($course['permalink']); ?>" class="dashboard-course-btn">
                                    <?php if (intval($course['progress']) >= 100) : ?>
                                        <i class="fas fa-redo"></i> مراجعة الدورة
                                    <?php else : ?>
                                        <i class="fas fa-play"></i> متابعة التعلم
                                    <?php endif; ?>
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else : ?>
                    <div class="dashboard-empty">
                        <div class="dashboard-empty-icon"><i class="fas fa-book-open"></i></div>
                        <h3>لا توجد دورات مسجلة</h3>
                        <p>لم تسجل في أي دورة بعد. ابدأ رحلتك التعليمية الآن!</p>
                        <a href="<?php echo esc_url(home_url('/courses')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> استكشف الدورات</a>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- ====== TAB: Profile ====== -->
                <?php elseif ($active_tab === 'profile') : ?>
                <div class="dashboard-panel">
                    <div class="dashboard-panel-header">
                        <h2><i class="fas fa-user-cog"></i> الملف الشخصي</h2>
                    </div>
                    <div class="dashboard-profile-card">
                        <div class="dashboard-profile-avatar">
                            <?php echo get_avatar($user_id, 120); ?>
                            <div class="dashboard-profile-avatar-overlay">
                                <i class="fas fa-camera"></i>
                            </div>
                        </div>
                        <form class="dashboard-profile-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                            <input type="hidden" name="action" value="qimah_update_profile">
                            <?php wp_nonce_field('qimah_update_profile_nonce', 'qimah_profile_nonce'); ?>

                            <div class="dashboard-profile-grid">
                                <div class="dashboard-profile-field">
                                    <label>الاسم الأول</label>
                                    <input type="text" name="first_name" value="<?php echo esc_attr(get_user_meta($user_id, 'first_name', true) ?: $current_user->display_name); ?>" class="auth-field-input">
                                </div>
                                <div class="dashboard-profile-field">
                                    <label>الاسم الأخير</label>
                                    <input type="text" name="last_name" value="<?php echo esc_attr(get_user_meta($user_id, 'last_name', true)); ?>" class="auth-field-input">
                                </div>
                                <div class="dashboard-profile-field">
                                    <label>البريد الإلكتروني</label>
                                    <input type="email" name="email" value="<?php echo esc_attr($current_user->user_email); ?>" class="auth-field-input" disabled>
                                </div>
                                <div class="dashboard-profile-field">
                                    <label>رقم الجوال</label>
                                    <input type="tel" name="user_phone" value="<?php echo esc_attr(get_user_meta($user_id, 'user_phone', true) ?: get_user_meta($user_id, 'billing_phone', true)); ?>" class="auth-field-input" placeholder="05xxxxxxxx">
                                </div>
                                <div class="dashboard-profile-field dashboard-profile-field-full">
                                    <label>نبذة تعريفية</label>
                                    <textarea name="description" class="auth-field-input" rows="4" placeholder="اكتب نبذة مختصرة عنك..."><?php echo esc_textarea(get_user_meta($user_id, 'description', true)); ?></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> حفظ التغييرات</button>
                        </form>
                    </div>
                </div>

                <!-- ====== TAB: Certificates ====== -->
                <?php elseif ($active_tab === 'certificates') : ?>
                <div class="dashboard-panel">
                    <div class="dashboard-panel-header">
                        <h2><i class="fas fa-award"></i> الشهادات</h2>
                    </div>

                    <?php if (!empty($certificates)) : ?>
                    <div class="dashboard-certs-grid">
                        <?php foreach ($certificates as $cert) : ?>
                        <div class="dashboard-cert-card">
                            <div class="dashboard-cert-icon"><i class="fas fa-certificate"></i></div>
                            <h3><?php echo esc_html($cert['title']); ?></h3>
                            <?php if ($cert['course_id']) : ?>
                                <p class="dashboard-cert-course"><?php echo esc_html(get_the_title($cert['course_id'])); ?></p>
                            <?php endif; ?>
                            <p class="dashboard-cert-date"><i class="fas fa-calendar-alt"></i> <?php echo esc_html($cert['date']); ?></p>
                            <a href="#" class="btn btn-outline btn-sm"><i class="fas fa-download"></i> تحميل الشهادة</a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else : ?>
                    <div class="dashboard-empty">
                        <div class="dashboard-empty-icon"><i class="fas fa-award"></i></div>
                        <h3>لا توجد شهادات بعد</h3>
                        <p>أكمل دوراتك للحصول على شهادات معتمدة</p>
                        <a href="<?php echo esc_url(home_url('/courses')); ?>" class="btn btn-primary"><i class="fas fa-book-open"></i> تصفح الدورات</a>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- ====== TAB: Quizzes ====== -->
                <?php elseif ($active_tab === 'quiz') : ?>
                <div class="dashboard-panel">
                    <div class="dashboard-panel-header">
                        <h2><i class="fas fa-clipboard-check"></i> الاختبارات</h2>
                    </div>

                    <?php
                    $quiz_attempts = array();
                    if (function_exists('tutor_utils')) {
                        global $wpdb;
                        $attempts = $wpdb->get_results($wpdb->prepare(
                            "SELECT * FROM {$wpdb->prefix}tutor_quiz_attempts WHERE user_id = %d ORDER BY attempt_started_at DESC LIMIT 20",
                            $user_id
                        ));
                        foreach ($attempts as $attempt) {
                            $quiz_attempts[] = array(
                                'id'        => $attempt->attempt_id,
                                'quiz_id'   => $attempt->quiz_id,
                                'course_id' => $attempt->course_id,
                                'score'     => $attempt->earned_marks,
                                'total'     => $attempt->total_marks,
                                'date'      => $attempt->attempt_started_at,
                                'status'    => $attempt->attempt_status,
                            );
                        }
                    }
                    ?>

                    <?php if (!empty($quiz_attempts)) : ?>
                    <div class="dashboard-quiz-list">
                        <?php foreach ($quiz_attempts as $qa) : ?>
                        <div class="dashboard-quiz-item">
                            <div class="dashboard-quiz-info">
                                <h4>
                                    <?php if ($qa['course_id']) : ?>
                                        <a href="<?php echo esc_url(get_permalink($qa['course_id'])); ?>"><?php echo esc_html(get_the_title($qa['quiz_id'])); ?></a>
                                    <?php else : ?>
                                        <?php echo esc_html(get_the_title($qa['quiz_id'])); ?>
                                    <?php endif; ?>
                                </h4>
                                <p class="dashboard-quiz-meta">
                                    <?php if ($qa['course_id']) : ?>
                                        <span><i class="fas fa-book"></i> <?php echo esc_html(get_the_title($qa['course_id'])); ?></span>
                                    <?php endif; ?>
                                    <span><i class="fas fa-calendar-alt"></i> <?php echo esc_html(date('Y/m/d', strtotime($qa['date']))); ?></span>
                                </p>
                            </div>
                            <div class="dashboard-quiz-score">
                                <?php
                                $percent = $qa['total'] > 0 ? round(($qa['score'] / $qa['total']) * 100) : 0;
                                $score_class = $percent >= 80 ? 'success' : ($percent >= 50 ? 'warning' : 'danger');
                                ?>
                                <div class="dashboard-quiz-percent <?php echo $score_class; ?>"><?php echo $percent; ?>%</div>
                                <span class="dashboard-quiz-marks"><?php echo intval($qa['score']); ?>/<?php echo intval($qa['total']); ?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else : ?>
                    <div class="dashboard-empty">
                        <div class="dashboard-empty-icon"><i class="fas fa-clipboard-check"></i></div>
                        <h3>لا توجد اختبارات</h3>
                        <p>ستظهر هنا نتائج اختباراتك بعد إكمالها</p>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- ====== TAB: Orders ====== -->
                <?php elseif ($active_tab === 'orders') : ?>
                <div class="dashboard-panel">
                    <div class="dashboard-panel-header">
                        <h2><i class="fas fa-receipt"></i> سجل الطلبات</h2>
                    </div>

                    <?php
                    $orders = array();
                    global $wpdb;
                    $order_results = $wpdb->get_results($wpdb->prepare(
                        "SELECT * FROM {$wpdb->prefix}tutor_earnings WHERE user_id = %d ORDER BY created_at DESC LIMIT 20",
                        $user_id
                    ));
                    ?>

                    <div class="dashboard-empty">
                        <div class="dashboard-empty-icon"><i class="fas fa-receipt"></i></div>
                        <h3>لا توجد طلبات</h3>
                        <p>ستظهر هنا سجل مشترياتك وطلباتك</p>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof AOS !== 'undefined') {
        AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true });
    }
});
</script>

<?php get_footer(); ?>
