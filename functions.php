<?php
/**
 * Qimah Wa Qudwah Theme Functions
 */

define('QIMAH_VERSION', '1.0.0');
define('QIMAH_DIR', get_template_directory());
define('QIMAH_URI', get_template_directory_uri());

/* ---------- Theme Setup ---------- */
function qimah_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('custom-background', array('default-color' => 'ffffff'));

    register_nav_menus(array(
        'primary' => esc_html__('القائمة الرئيسية', 'qimah-wa-qudwah'),
        'footer'  => esc_html__('قائمة الفوتر', 'qimah-wa-qudwah'),
    ));

    set_post_thumbnail_size(800, 500, true);
    add_image_size('course-thumb', 600, 360, true);
    add_image_size('instructor-thumb', 200, 200, true);
}
add_action('after_setup_theme', 'qimah_setup');

function qimah_content_width() {
    return 1200;
}
add_filter('content_width', 'qimah_content_width');

/* ---------- Widget Areas ---------- */
function qimah_widgets_init() {
    $sidebars = array(
        'sidebar-courses'     => 'شريط جانبي - الدورات',
        'sidebar-single-course' => 'شريط جانبي - الدورة',
        'footer-1'            => 'فوتر - عمود 1',
        'footer-2'            => 'فوتر - عمود 2',
        'footer-3'            => 'فوتر - عمود 3',
        'footer-4'            => 'فوتر - عمود 4',
    );
    foreach ($sidebars as $id => $name) {
        register_sidebar(array(
            'name'          => esc_html__($name, 'qimah-wa-qudwah'),
            'id'            => $id,
            'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="sidebar-widget-title"><i class="fas fa-cog"></i>',
            'after_title'   => '</h3>',
        ));
    }
}
add_action('widgets_init', 'qimah_widgets_init');

/* ---------- Enqueue Styles & Scripts ---------- */
function qimah_scripts() {
    $font_family = get_theme_mod('qimah_font_family', 'Cairo');
    wp_enqueue_style('google-fonts', "https://fonts.googleapis.com/css2?family={$font_family}:wght@300;400;500;600;700;800;900&display=swap", array(), null);
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');
    wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0');
    wp_enqueue_style('aos', 'https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css', array(), '2.3.4');
    wp_enqueue_style('qimah-style', get_stylesheet_uri(), array(), QIMAH_VERSION);
    wp_enqueue_style('qimah-template-style', QIMAH_URI . '/assets/css/template-style.css', array('qimah-style'), QIMAH_VERSION);

    $custom_css = qimah_get_custom_css();
    if ($custom_css) {
        wp_add_inline_style('qimah-style', $custom_css);
    }

    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0.0', true);
    wp_enqueue_script('aos', 'https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js', array(), '2.3.4', true);
    wp_enqueue_script('qimah-main', QIMAH_URI . '/assets/js/main.js', array(), QIMAH_VERSION, true);
    wp_enqueue_script('qimah-pages', QIMAH_URI . '/assets/js/pages.js', array(), QIMAH_VERSION, true);

    if (is_page_template('template-contact.php')) {
        wp_enqueue_script('qimah-contact', QIMAH_URI . '/assets/js/contact.js', array(), QIMAH_VERSION, true);
    }
    if (is_page_template('template-auth.php')) {
        wp_enqueue_script('qimah-auth', QIMAH_URI . '/assets/js/auth.js', array(), QIMAH_VERSION, true);
    }

    wp_localize_script('qimah-main', 'qimah_ajax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('qimah_nonce'),
    ));

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'qimah_scripts');

/* ---------- Custom CSS from Customizer ---------- */
function qimah_get_custom_css() {
    $primary        = get_theme_mod('qimah_primary_color', '#2090b0');
    $primary_dark   = get_theme_mod('qimah_primary_dark', '#107080');
    $secondary      = get_theme_mod('qimah_secondary_color', '#f0a010');
    $secondary_dark = get_theme_mod('qimah_secondary_dark', '#d4900e');
    $dark_bg        = get_theme_mod('qimah_dark_bg', '#1a1a2e');
    $font_family    = get_theme_mod('qimah_font_family', 'Cairo');
    $body_size      = get_theme_mod('qimah_body_font_size', '16');
    $heading_weight = get_theme_mod('qimah_heading_weight', '800');

    return ":root {
        --primary: {$primary};
        --primary-dark: {$primary_dark};
        --primary-darker: " . qimah_adjust_color($primary_dark, -20) . ";
        --primary-light: " . qimah_adjust_color($primary, 40) . ";
        --primary-lighter: " . qimah_adjust_color($primary, 230, true) . ";
        --secondary: {$secondary};
        --secondary-dark: {$secondary_dark};
        --secondary-light: " . qimah_adjust_color($secondary, 40) . ";
        --secondary-lighter: " . qimah_adjust_color($secondary, 230, true) . ";
        --dark: {$dark_bg};
        --dark-soft: " . qimah_adjust_color($dark_bg, 20) . ";
        --gradient-primary: linear-gradient(135deg, {$primary} 0%, {$primary_dark} 100%);
        --gradient-secondary: linear-gradient(135deg, {$secondary} 0%, {$secondary_dark} 100%);
        --gradient-hero: linear-gradient(135deg, " . qimah_adjust_color($primary_dark, -20) . " 0%, {$primary} 50%, " . qimah_adjust_color($primary, 40) . " 100%);
        --gradient-gold: linear-gradient(135deg, {$secondary} 0%, " . qimah_adjust_color($secondary, 40) . " 100%);
        --gradient-dark: linear-gradient(135deg, {$dark_bg} 0%, " . qimah_adjust_color($dark_bg, 20) . " 100%);
        --shadow-primary: 0 8px 24px " . qimah_adjust_color($primary, 0, true, 0.25) . ";
        --shadow-secondary: 0 8px 24px " . qimah_adjust_color($secondary, 0, true, 0.25) . ";
        --font: '{$font_family}', sans-serif;
    }
    body { font-size: " . intval($body_size) . "px; }
    .section-title, .hero-title, .page-banner h1, h1, h2, h3 { font-weight: " . intval($heading_weight) . "; }";
}

function qimah_adjust_color($hex, $steps, $is_lighten = false, $alpha = 1) {
    $hex = str_replace('#', '', $hex);
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    if ($is_lighten && $steps > 100) {
        $ratio = $steps / 255;
        $r = intval($r + (255 - $r) * $ratio);
        $g = intval($g + (255 - $g) * $ratio);
        $b = intval($b + (255 - $b) * $ratio);
    } else {
        $r = max(0, min(255, $r + $steps));
        $g = max(0, min(255, $g + $steps));
        $b = max(0, min(255, $b + $steps));
    }
    if ($alpha < 1) {
        return sprintf('rgba(%d, %d, %d, %.2f)', $r, $g, $b, $alpha);
    }
    return '#' . sprintf('%02x%02x%02x', $r, $g, $b);
}

/* ---------- Body Classes ---------- */
function qimah_body_classes($classes) {
    if (is_front_page()) $classes[] = 'front-page';
    if (is_singular()) $classes[] = 'singular';
    return $classes;
}
add_filter('body_class', 'qimah_body_classes');

/* ---------- Excerpt ---------- */
function qimah_excerpt_length($length) { return 30; }
add_filter('excerpt_length', 'qimah_excerpt_length');
function qimah_excerpt_more($more) { return '...'; }
add_filter('excerpt_more', 'qimah_excerpt_more');

/* ---------- Include Customizer, Template Tags & Post Types ---------- */
require_once QIMAH_DIR . '/inc/customizer.php';
require_once QIMAH_DIR . '/inc/template-tags.php';
require_once QIMAH_DIR . '/inc/post-types.php';

/* ---------- Flush Rewrite Rules on Theme Switch/Activate ---------- */
function qimah_flush_rewrite() {
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'qimah_flush_rewrite');

/* ---------- Tutor LMS Integration ----------
 * Following Edubin's approach:
 * - We override Tutor LMS templates via the tutor/ folder in theme root
 *   (WordPress's standard template override convention for plugins)
 * - Single course page: tutor/single-course.php overrides Tutor LMS's template
 * - Enrollment is fully delegated to Tutor LMS via tutor_load_template('single.course.course-entry-box')
 * - Curriculum, reviews, etc. are rendered by Tutor LMS's own tab system
 * - We only use template_include for the archive (listing) page
 * - All Tutor LMS API functions are the correct ones verified from Edubin theme
 */
if (function_exists('tutor')) {
    // Override archive page only
    add_filter('template_include', 'qimah_tutor_template', 99);
    function qimah_tutor_template($template) {
        if (is_post_type_archive('courses')) {
            $new = QIMAH_DIR . '/template-courses.php';
            if (file_exists($new)) return $new;
        }
        return $template;
    }

    // Enqueue Tutor LMS compatibility styles
    add_action('wp_enqueue_scripts', 'qimah_tutor_styles', 20);
    function qimah_tutor_styles() {
        wp_enqueue_style('qimah-tutor', QIMAH_URI . '/assets/css/tutor.css', array('qimah-template-style'), QIMAH_VERSION);
    }

    // Add body class for single course
    add_filter('body_class', 'qimah_tutor_body_class');
    function qimah_tutor_body_class($classes) {
        if (is_singular('courses')) {
            $classes[] = 'single-tutor-course';
        }
        if (is_singular('lesson')) {
            $classes[] = 'single-tutor-lesson';
        }
        return $classes;
    }
}

/* ---------- Tutor LMS Helper Functions ---------- */

/**
 * Get the first lesson URL for a course (used in dashboard "Continue Learning" button)
 */
function qimah_get_course_first_lesson_url($course_id) {
    if (!function_exists('tutor_utils')) return get_permalink($course_id);

    // Use Tutor LMS's topic/lesson system
    $topics = tutor_utils()->get_course_topics($course_id);
    if (is_array($topics) && !empty($topics)) {
        foreach ($topics as $topic) {
            $topic_id = isset($topic->comment_ID) ? $topic->comment_ID : $topic->ID;
            if (function_exists('tutor_lessons')) {
                $lessons = tutor_lessons()->get_lessons_by_topic($topic_id);
                $lessons = is_array($lessons) ? $lessons : array();
                if (!empty($lessons)) {
                    return get_permalink($lessons[0]->ID);
                }
            }
        }
    }

    // Fallback: direct query
    $lesson_query = new WP_Query(array(
        'post_type'      => 'lesson',
        'meta_key'       => '_tutor_course_id_for_lesson',
        'meta_value'     => $course_id,
        'posts_per_page' => 1,
        'orderby'        => 'menu_order date',
        'order'          => 'ASC',
        'post_status'    => 'publish',
    ));
    if ($lesson_query->have_posts()) {
        $url = get_permalink($lesson_query->posts[0]->ID);
        wp_reset_postdata();
        return $url;
    }
    wp_reset_postdata();

    return get_permalink($course_id);
}

/**
 * Check if user is enrolled in a course
 */
function qimah_is_user_enrolled($course_id, $user_id = null) {
    if (!$user_id) $user_id = get_current_user_id();
    if (!$user_id) return false;
    if (!function_exists('tutor_utils')) return false;
    return tutor_utils()->is_enrolled($course_id, $user_id);
}

/* ---------- AJAX ---------- */
function qimah_newsletter_ajax() {
    check_ajax_referer('qimah_nonce', 'nonce');
    $email = sanitize_email($_POST['email'] ?? '');
    if (is_email($email)) {
        wp_send_json_success(array('message' => 'تم الاشتراك بنجاح!'));
    } else {
        wp_send_json_error(array('message' => 'البريد الإلكتروني غير صحيح'));
    }
}
add_action('wp_ajax_qimah_newsletter', 'qimah_newsletter_ajax');
add_action('wp_ajax_nopriv_qimah_newsletter', 'qimah_newsletter_ajax');

/* ---------- Profile Update Handler ---------- */
add_action('admin_post_qimah_update_profile', 'qimah_handle_profile_update');
function qimah_handle_profile_update() {
    if (!wp_verify_nonce($_POST['qimah_profile_nonce'] ?? '', 'qimah_update_profile_nonce')) {
        wp_die('Security check failed.');
    }
    $user_id = get_current_user_id();
    if (!$user_id) {
        wp_redirect(home_url('/login'));
        exit;
    }

    $first_name = sanitize_text_field($_POST['first_name'] ?? '');
    $last_name  = sanitize_text_field($_POST['last_name'] ?? '');
    $phone      = sanitize_text_field($_POST['user_phone'] ?? '');
    $desc       = sanitize_textarea_field($_POST['description'] ?? '');

    $update = array('ID' => $user_id);
    if ($first_name) $update['first_name'] = $first_name;
    if ($last_name)  $update['last_name']  = $last_name;
    if ($desc)       $update['description'] = $desc;

    wp_update_user($update);
    if ($phone) {
        update_user_meta($user_id, 'user_phone', $phone);
        update_user_meta($user_id, 'billing_phone', $phone);
    }

    wp_safe_redirect(add_query_arg('tab', 'profile', get_permalink(get_page_by_path('dashboard'))));
    exit;
}

/* ---------- Redirect wp-login to custom auth ---------- */
add_action('login_init', function() {
    if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'wp-login.php') !== false && !isset($_REQUEST['action'])) {
        $auth_page = get_page_by_path('login');
        if ($auth_page) {
            $redirect = isset($_REQUEST['redirect_to']) ? '?redirect_to=' . urlencode($_REQUEST['redirect_to']) : '';
            wp_safe_redirect(get_permalink($auth_page->ID) . $redirect);
            exit;
        }
    }
});

/* ---------- Remove emoji ---------- */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
