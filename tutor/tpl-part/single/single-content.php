<?php
/**
 * Course Main Content - Tutor LMS Integration
 * Uses Tutor LMS's own tab system for curriculum, reviews, etc.
 * Following Edubin's approach: delegate content to Tutor LMS
 *
 * @package Qimah_Wa_Qudwah
 */

$course_id     = get_the_ID();
$course_rating = tutor_utils()->get_course_rating($course_id);
$is_enrolled   = tutor_utils()->is_enrolled($course_id, get_current_user_id());

// Prepare the nav items (tabs: info, curriculum, reviews, etc.)
$course_nav_item = apply_filters('tutor_course/single/nav_items', tutor_utils()->course_nav_items(), $course_id);
$is_public       = \TUTOR\Course_List::is_public($course_id);
$student_must_login_to_view_course = tutor_utils()->get_option('student_must_login_to_view_course');

tutor_utils()->tutor_custom_header();

// Login gate - if user must login to view course
if (!is_user_logged_in() && !$is_public && $student_must_login_to_view_course) {
    tutor_load_template('login');
    tutor_utils()->tutor_custom_footer();
    return;
}

// Course Intro Video
echo '<div class="course-hero" data-aos="fade-up">';
if (tutor_utils()->has_video_in_single()) {
    tutor_course_video();
} elseif (has_post_thumbnail()) {
    the_post_thumbnail('large');
} else {
    echo '<div class="course-hero-img"><i class="fas fa-graduation-cap"></i></div>';
}
echo '</div>';

// Course Info Bar
echo '<div class="course-info-bar" data-aos="fade-up">';
echo '<div class="course-info-bar-item">';
    $instructors = tutor_utils()->get_instructors_by_course();
    if (!empty($instructors)) {
        $instructor = $instructors[0];
        echo '<a href="' . esc_url(tutor_utils()->profile_url($instructor->ID)) . '" class="course-info-bar-avatar"><i class="fas fa-user-tie"></i></a>';
        echo '<strong>' . esc_html($instructor->display_name) . '</strong>';
    }
echo '</div>';
echo '<div class="course-info-bar-divider"></div>';
echo '<div class="course-info-bar-item"><i class="fas fa-signal"></i> <span>المستوى: <strong>' . esc_html(get_tutor_course_level()) . '</strong></span></div>';
echo '<div class="course-info-bar-divider"></div>';
echo '<div class="course-info-bar-item"><i class="fas fa-play-circle"></i> <span><strong>' . intval(tutor_utils()->get_lesson_count_by_course($course_id)) . '</strong> درس</span></div>';
echo '<div class="course-info-bar-divider"></div>';
echo '<div class="course-info-bar-item"><i class="fas fa-users"></i> <span><strong>' . intval(tutor_utils()->count_enrolled_users_by_course()) . '</strong> متدرب</span></div>';
echo '</div>';

// Course Tabs (Tutor LMS handles this)
echo '<article id="post-' . get_the_ID() . '" ';
post_class('qimah-course-single-wrap');
echo '>';

echo '<div class="tutor-course-details-tab">';

    // Sticky nav bar for enrolled students
    if (is_array($course_nav_item) && count($course_nav_item) > 1) {
        echo '<div class="tutor-is-sticky">';
        tutor_load_template('single.course.enrolled.nav', array('course_nav_item' => $course_nav_item));
        echo '</div>';
    }

    // Tab content
    echo '<div class="tutor-tab tutor-pt-24">';
    foreach ($course_nav_item as $key => $subpage) :
        echo '<div id="tutor-course-details-tab-' . esc_attr($key) . '" class="tutor-tab-item' . ('info' == $key ? ' is-active' : '') . '">';
        do_action('tutor_course/single/tab/' . $key . '/before');
        $method = $subpage['method'];
        if (is_string($method)) {
            $method();
        } else {
            $_object = $method[0];
            $_method = $method[1];
            $_object->$_method(get_the_ID());
        }
        do_action('tutor_course/single/tab/' . $key . '/after');
        echo '</div>';
    endforeach;
    echo '</div>';

echo '</div>';
do_action('tutor_course/single/after/inner-wrap');

echo '</article>';
