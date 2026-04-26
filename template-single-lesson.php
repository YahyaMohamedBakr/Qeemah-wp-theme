<?php
/**
 * Single Lesson Template - Tutor LMS
 * Displays lesson video, content, and course curriculum sidebar
 */

// Redirect if not enrolled
$lesson_id = get_the_ID();
$course_id = get_post_meta($lesson_id, '_tutor_course_id_for_lesson', true);
if (!$course_id) {
    $course_id = tutor_utils()->get_course_id_by_lesson($lesson_id);
}

if ($course_id && !qimah_is_user_enrolled($course_id)) {
    wp_safe_redirect(get_permalink($course_id));
    exit;
}

// Get lesson video
$video_source = get_post_meta($lesson_id, '_lesson_video', true);
$video_html = '';
$has_video = false;

if (!empty($video_source)) {
    $has_video = true;
    // Check if it's a URL (YouTube/Vimeo) or embedded HTML
    if (filter_var($video_source, FILTER_VALIDATE_URL)) {
        if (strpos($video_source, 'youtube.com') !== false || strpos($video_source, 'youtu.be') !== false) {
            $video_id = '';
            if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|v\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $video_source, $matches)) {
                $video_id = $matches[1];
            }
            if ($video_id) {
                $video_html = '<div class="lesson-video-wrap"><iframe src="https://www.youtube.com/embed/' . esc_attr($video_id) . '?rel=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';
            }
        } elseif (strpos($video_source, 'vimeo.com') !== false) {
            $video_id = '';
            if (preg_match('/vimeo\.com\/(\d+)/', $video_source, $matches)) {
                $video_id = $matches[1];
            }
            if ($video_id) {
                $video_html = '<div class="lesson-video-wrap"><iframe src="https://player.vimeo.com/video/' . esc_attr($video_id) . '" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe></div>';
            }
        } else {
            // HTML5 video
            $video_html = '<div class="lesson-video-wrap"><video controls><source src="' . esc_url($video_source) . '">متصفحك لا يدعم تشغيل الفيديو</video></div>';
        }
    } else {
        // It's embedded HTML (VideoPress, etc.)
        $video_html = '<div class="lesson-video-wrap">' . $video_source . '</div>';
    }
}

// Get all lessons for navigation and sidebar
$all_lessons = qimah_get_course_lessons($course_id);
$current_index = -1;
$prev_lesson = null;
$next_lesson = null;

foreach ($all_lessons as $idx => $lesson) {
    if ($lesson->ID == $lesson_id) {
        $current_index = $idx;
        break;
    }
}
if ($current_index > 0) {
    $prev_lesson = $all_lessons[$current_index - 1];
}
if ($current_index >= 0 && $current_index < count($all_lessons) - 1) {
    $next_lesson = $all_lessons[$current_index + 1];
}

// Lesson duration
$lesson_duration = get_post_meta($lesson_id, '_lesson_duration', true);

get_header();
?>

<!-- Lesson Top Bar -->
<div class="lesson-topbar">
    <div class="container">
        <div class="lesson-topbar-inner">
            <a href="<?php echo esc_url(get_permalink($course_id)); ?>" class="lesson-back-btn">
                <i class="fas fa-arrow-right"></i>
                <span>العودة للدورة</span>
            </a>
            <div class="lesson-topbar-title">
                <span class="lesson-topbar-course"><?php echo esc_html(get_the_title($course_id)); ?></span>
                <span class="lesson-topbar-sep">/</span>
                <span class="lesson-topbar-lesson"><?php echo esc_html(get_the_title()); ?></span>
            </div>
            <div class="lesson-topbar-progress">
                <?php if (function_exists('tutor_utils')) : ?>
                    <?php $progress = tutor_utils()->get_course_completed_percent($course_id, get_current_user_id()); ?>
                    <div class="lesson-progress-bar">
                        <div class="lesson-progress-fill" style="width: <?php echo intval($progress); ?>%;"></div>
                    </div>
                    <span class="lesson-progress-text"><?php echo intval($progress); ?>%</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<main class="lesson-page">
    <div class="container">
        <div class="lesson-layout">

            <!-- Lesson Main Content -->
            <div class="lesson-main">

                <!-- Video Player -->
                <?php if ($has_video && $video_html) : ?>
                    <div class="lesson-video-container" data-aos="fade-up">
                        <?php echo $video_html; ?>
                    </div>
                <?php else : ?>
                    <div class="lesson-no-video" data-aos="fade-up">
                        <div class="lesson-no-video-inner">
                            <i class="fas fa-file-alt"></i>
                            <span>درس نصي</span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Lesson Header -->
                <div class="lesson-header" data-aos="fade-up">
                    <h1 class="lesson-title"><?php echo esc_html(get_the_title()); ?></h1>
                    <?php if ($lesson_duration) : ?>
                        <span class="lesson-meta-duration"><i class="fas fa-clock"></i> <?php echo esc_html($lesson_duration); ?></span>
                    <?php endif; ?>
                    <span class="lesson-meta-number">
                        الدرس <?php echo intval($current_index + 1); ?> من <?php echo intval(count($all_lessons)); ?>
                    </span>
                </div>

                <!-- Lesson Content -->
                <div class="lesson-content" data-aos="fade-up">
                    <?php the_content(); ?>
                </div>

                <!-- Lesson Navigation -->
                <div class="lesson-nav" data-aos="fade-up">
                    <?php if ($prev_lesson) : ?>
                        <a href="<?php echo esc_url(get_permalink($prev_lesson->ID)); ?>" class="lesson-nav-btn lesson-nav-prev">
                            <i class="fas fa-arrow-right"></i>
                            <div class="lesson-nav-btn-info">
                                <span class="lesson-nav-label">الدرس السابق</span>
                                <span class="lesson-nav-name"><?php echo esc_html($prev_lesson->post_title); ?></span>
                            </div>
                        </a>
                    <?php else : ?>
                        <div></div>
                    <?php endif; ?>

                    <?php if ($next_lesson) : ?>
                        <a href="<?php echo esc_url(get_permalink($next_lesson->ID)); ?>" class="lesson-nav-btn lesson-nav-next">
                            <div class="lesson-nav-btn-info">
                                <span class="lesson-nav-label">الدرس التالي</span>
                                <span class="lesson-nav-name"><?php echo esc_html($next_lesson->post_title); ?></span>
                            </div>
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    <?php else : ?>
                        <a href="<?php echo esc_url(get_permalink($course_id)); ?>" class="lesson-nav-btn lesson-nav-next lesson-nav-finish">
                            <div class="lesson-nav-btn-info">
                                <span class="lesson-nav-label">إنهاء الدورة</span>
                                <span class="lesson-nav-name">العودة لصفحة الدورة</span>
                            </div>
                            <i class="fas fa-check-circle"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Lesson Sidebar - Course Curriculum -->
            <aside class="lesson-sidebar" data-aos="fade-left">
                <div class="lesson-sidebar-card">
                    <div class="lesson-sidebar-header">
                        <h3><i class="fas fa-list-ol"></i> محتوى الدورة</h3>
                        <span class="lesson-sidebar-count"><?php echo intval(count($all_lessons)); ?> درس</span>
                    </div>
                    <div class="lesson-sidebar-list">
                        <?php foreach ($all_lessons as $idx => $lesson) :
                            $is_current = ($lesson->ID == $lesson_id);
                            $lesson_dur = get_post_meta($lesson->ID, '_lesson_duration', true);
                        ?>
                        <a href="<?php echo esc_url(get_permalink($lesson->ID)); ?>" class="lesson-sidebar-item <?php echo $is_current ? 'active' : ''; ?>">
                            <div class="lesson-sidebar-item-icon">
                                <?php if ($is_current) : ?>
                                    <i class="fas fa-play-circle"></i>
                                <?php else : ?>
                                    <span class="lesson-num"><?php echo intval($idx + 1); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="lesson-sidebar-item-info">
                                <span class="lesson-sidebar-item-title"><?php echo esc_html($lesson->post_title); ?></span>
                                <?php if ($lesson_dur) : ?>
                                    <span class="lesson-sidebar-item-dur"><i class="fas fa-clock"></i> <?php echo esc_html($lesson_dur); ?></span>
                                <?php endif; ?>
                            </div>
                            <?php if ($is_current) : ?>
                                <span class="lesson-sidebar-item-now">الآن</span>
                            <?php endif; ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </aside>

        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof AOS !== 'undefined') {
        AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true });
    }

    // Auto-scroll sidebar to active lesson
    const activeItem = document.querySelector('.lesson-sidebar-item.active');
    if (activeItem) {
        activeItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});
</script>

<?php get_footer(); ?>
