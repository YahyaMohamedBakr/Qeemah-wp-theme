<?php
/**
 * Course Sidebar - Tutor LMS Integration
 * Includes enrollment box (handled by Tutor LMS) + course info
 * Following Edubin's approach: delegate enrollment to Tutor LMS
 *
 * @package Qimah_Wa_Qudwah
 */

$course_id     = get_the_ID();
$course_rating = tutor_utils()->get_course_rating($course_id);
$is_enrolled   = tutor_utils()->is_enrolled($course_id, get_current_user_id());

$course_nav_item = apply_filters('tutor_course/single/nav_items', tutor_utils()->course_nav_items(), $course_id);
$is_public       = \TUTOR\Course_List::is_public($course_id);
$student_must_login_to_view_course = tutor_utils()->get_option('student_must_login_to_view_course');

tutor_utils()->tutor_custom_header();

// Login gate
if (!is_user_logged_in() && !$is_public && $student_must_login_to_view_course) {
    tutor_load_template('login');
    tutor_utils()->tutor_custom_footer();
    return;
}

// Sidebar Video
echo '<div class="sidebar-card">';
if (tutor_utils()->has_video_in_single()) {
    echo '<div class="sidebar-video">';
    tutor_course_video();
    echo '</div>';
} elseif (has_post_thumbnail()) {
    echo '<div class="sidebar-video">';
    the_post_thumbnail('large');
    echo '</div>';
}

// Course Info
echo '<div class="edubin-course-info">';

echo '<ul class="course-info-list">';

    // ENROLLMENT BOX - This is the key line! Tutor LMS handles the button
    tutor_load_template('single.course.course-entry-box');

    // Price
    $default_price = apply_filters('tutor-loop-default-price', esc_html__('مجاني', 'qimah-wa-qudwah'));
    $price_html    = '<span class="price"> ' . $default_price . '</span>';

    echo '<li class="info-price">';
    echo '<i class="fas fa-tag"></i>';
    echo '<span class="label">السعر:</span>';
    echo '<span class="value qimah-price-value">';
    if (tutor_utils()->is_course_purchasable()) {
        $product_id = tutor_utils()->get_course_product_id($course_id);
        if ($product_id && function_exists('wc_get_product')) {
            $product = wc_get_product($product_id);
            if ($product) {
                $price_html = '<span class="price"> ' . $product->get_price_html() . ' </span>';
            }
        }
    }
    echo wp_kses($price_html, 'post');
    echo '</span>';
    echo '</li>';

    // Enrolled Students
    $total_students = intval(tutor_utils()->count_enrolled_users_by_course());
    echo '<li>';
    echo '<i class="fas fa-users"></i>';
    echo '<span class="label">المسجلون:</span>';
    echo '<span class="value">' . $total_students . ' متدرب</span>';
    echo '</li>';

    // Duration
    $course_duration = get_tutor_course_duration_context();
    echo '<li>';
    echo '<i class="fas fa-clock"></i>';
    echo '<span class="label">المدة:</span>';
    echo '<span class="value">' . wp_kses_post($course_duration) . '</span>';
    echo '</li>';

    // Lessons
    $total_lesson = intval(tutor_utils()->get_lesson_count_by_course($course_id));
    echo '<li>';
    echo '<i class="fas fa-play-circle"></i>';
    echo '<span class="label">الدروس:</span>';
    echo '<span class="value">' . $total_lesson . ' درس</span>';
    echo '</li>';

    // Quizzes
    $total_questions = intval(tutor_utils()->get_quiz_count_by_course($course_id));
    echo '<li>';
    echo '<i class="fas fa-clipboard-check"></i>';
    echo '<span class="label">الاختبارات:</span>';
    echo '<span class="value">' . $total_questions . ' اختبار</span>';
    echo '</li>';

    // Level
    echo '<li>';
    echo '<i class="fas fa-signal"></i>';
    echo '<span class="label">المستوى:</span>';
    echo '<span class="value">' . esc_html(get_tutor_course_level()) . '</span>';
    echo '</li>';

    // Category
    $course_cats = get_the_terms($course_id, 'course-category');
    if ($course_cats && !is_wp_error($course_cats)) {
        echo '<li>';
        echo '<i class="fas fa-folder"></i>';
        echo '<span class="label">التصنيف:</span>';
        echo '<span class="value">';
        foreach ($course_cats as $cat) {
            echo '<a href="' . get_term_link($cat) . '">' . esc_html($cat->name) . '</a> ';
        }
        echo '</span>';
        echo '</li>';
    }

echo '</ul>'; // End course-info-list
echo '</div>'; // End edubin-course-info

// Course Features
echo '<div class="sidebar-features">';
echo '<div class="sidebar-feature"><i class="fas fa-play-circle"></i> دروس فيديو</div>';
echo '<div class="sidebar-feature"><i class="fas fa-certificate"></i> شهادة إتمام</div>';
echo '<div class="sidebar-feature"><i class="fas fa-mobile-alt"></i> متوافق مع الجوال</div>';
echo '<div class="sidebar-feature"><i class="fas fa-infinity"></i> وصول مدى الحياة</div>';
echo '</div>';

// Share
echo '<div class="sidebar-share">';
echo '<div class="sidebar-share-title">مشاركة الدورة</div>';
echo '<div class="sidebar-share-links">';
echo '<a href="https://twitter.com/intent/tweet?url=' . urlencode(get_permalink()) . '&text=' . urlencode(get_the_title()) . '" class="sidebar-share-link twitter" target="_blank"><i class="fab fa-x-twitter"></i></a>';
echo '<a href="https://www.linkedin.com/sharing/share-offsite/?url=' . urlencode(get_permalink()) . '" class="sidebar-share-link linkedin" target="_blank"><i class="fab fa-linkedin-in"></i></a>';
echo '<a href="https://wa.me/?text=' . urlencode(get_the_title() . ' ' . get_permalink()) . '" class="sidebar-share-link whatsapp" target="_blank"><i class="fab fa-whatsapp"></i></a>';
echo '</div>';
echo '</div>';

// Instructor / Requirements / Tags
echo '<div class="tutor-single-course-sidebar-more">';
    tutor_course_instructors_html();
    tutor_course_requirements_html();
    tutor_course_tags_html();
    tutor_course_target_audience_html();
echo '</div>';

do_action('tutor_course/single/after/sidebar');

echo '</div>'; // End sidebar-card
