<?php
/**
 * Qimah Wa Qudwah Customizer Options
 */
function qimah_customize_register($wp_customize) {

    // ===== BRANDING =====
    $wp_customize->add_section('qimah_branding', array('title' => 'الهوية البصرية', 'priority' => 30));

    // ===== COLORS =====
    $wp_customize->add_section('qimah_colors', array('title' => 'الألوان', 'priority' => 31));
    $color_fields = array(
        'qimah_primary_color'   => array('#2090b0', 'اللون الأساسي (الأزرق المخضر)'),
        'qimah_primary_dark'    => array('#107080', 'اللون الأساسي الداكن'),
        'qimah_secondary_color' => array('#f0a010', 'اللون الثانوي (الذهبي)'),
        'qimah_secondary_dark'  => array('#d4900e', 'اللون الثانوي الداكن'),
        'qimah_dark_bg'         => array('#1a1a2e', 'لون الخلفية الداكنة'),
    );
    foreach ($color_fields as $id => $val) {
        $wp_customize->add_setting($id, array('default' => $val[0], 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $id, array('label' => $val[1], 'section' => 'qimah_colors')));
    }

    // ===== TYPOGRAPHY =====
    $wp_customize->add_section('qimah_typography', array('title' => 'الخطوط', 'priority' => 32));
    $wp_customize->add_setting('qimah_font_family', array('default' => 'Cairo', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage'));
    $wp_customize->add_control('qimah_font_family', array('label' => 'نوع الخط', 'section' => 'qimah_typography', 'type' => 'select',
        'choices' => array('Cairo' => 'Cairo', 'Tajawal' => 'Tajawal', 'Almarai' => 'Almarai', 'Noto Sans Arabic' => 'Noto Sans Arabic')));
    $wp_customize->add_setting('qimah_body_font_size', array('default' => '16', 'sanitize_callback' => 'absint', 'transport' => 'postMessage'));
    $wp_customize->add_control('qimah_body_font_size', array('label' => 'حجم خط المحتوى (px)', 'section' => 'qimah_typography', 'type' => 'range', 'input_attrs' => array('min' => 13, 'max' => 20, 'step' => 1)));
    $wp_customize->add_setting('qimah_heading_weight', array('default' => '800', 'sanitize_callback' => 'absint', 'transport' => 'postMessage'));
    $wp_customize->add_control('qimah_heading_weight', array('label' => 'وزن العناوين', 'section' => 'qimah_typography', 'type' => 'select', 'choices' => array('600' => 'Semi Bold', '700' => 'Bold', '800' => 'Extra Bold', '900' => 'Black')));

    // ===== HEADER =====
    $wp_customize->add_section('qimah_header', array('title' => 'الهيدر', 'priority' => 33));
    $wp_customize->add_setting('qimah_phone', array('default' => '+966 00 000 0000', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('qimah_phone', array('label' => 'رقم الهاتف', 'section' => 'qimah_header', 'type' => 'text'));
    $wp_customize->add_setting('qimah_header_email', array('default' => 'info@goodwaty.org.sa', 'sanitize_callback' => 'sanitize_email'));
    $wp_customize->add_control('qimah_header_email', array('label' => 'البريد الإلكتروني', 'section' => 'qimah_header', 'type' => 'email'));
    $wp_customize->add_setting('qimah_show_login', array('default' => true, 'sanitize_callback' => 'wp_validate_boolean'));
    $wp_customize->add_control('qimah_show_login', array('label' => 'إظهار زر تسجيل الدخول', 'section' => 'qimah_header', 'type' => 'checkbox'));
    $wp_customize->add_setting('qimah_show_register', array('default' => true, 'sanitize_callback' => 'wp_validate_boolean'));
    $wp_customize->add_control('qimah_show_register', array('label' => 'إظهار زر حساب جديد', 'section' => 'qimah_header', 'type' => 'checkbox'));

    // ===== HOMEPAGE =====
    $wp_customize->add_section('qimah_homepage', array('title' => 'الصفحة الرئيسية', 'priority' => 34));
    $wp_customize->add_setting('qimah_hero_title', array('default' => 'مركز قيمة وقدوة للتدريب', 'sanitize_callback' => 'sanitize_textarea_field'));
    $wp_customize->add_control('qimah_hero_title', array('label' => 'عنوان البطل', 'section' => 'qimah_homepage', 'type' => 'textarea'));
    $wp_customize->add_setting('qimah_hero_subtitle', array('default' => "نُؤمن أن القيم هي البداية الحقيقية لأي تغيير...\nابدأ رحلتك نحو التميز مع مركز قيمة وقدوة للتدريب!", 'sanitize_callback' => 'sanitize_textarea_field'));
    $wp_customize->add_control('qimah_hero_subtitle', array('label' => 'نص البطل', 'section' => 'qimah_homepage', 'type' => 'textarea'));
    $wp_customize->add_setting('qimah_hero_badge', array('default' => 'منصة تعليمية معتمدة', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('qimah_hero_badge', array('label' => 'نص شارة البطل', 'section' => 'qimah_homepage', 'type' => 'text'));
    foreach (array('stats' => 'قسم الإحصائيات', 'categories' => 'قسم التصنيفات', 'instructors' => 'قسم المدربون', 'testimonials' => 'قسم الآراء') as $key => $label) {
        $wp_customize->add_setting("qimah_show_{$key}", array('default' => true, 'sanitize_callback' => 'wp_validate_boolean'));
        $wp_customize->add_control("qimah_show_{$key}", array('label' => "إظهار {$label}", 'section' => 'qimah_homepage', 'type' => 'checkbox'));
    }
    $wp_customize->add_setting('qimah_courses_count', array('default' => 6, 'sanitize_callback' => 'absint'));
    $wp_customize->add_control('qimah_courses_count', array('label' => 'عدد الدورات في الرئيسية', 'section' => 'qimah_homepage', 'type' => 'number'));

    // ===== CONTACT =====
    $wp_customize->add_section('qimah_contact', array('title' => 'معلومات التواصل', 'priority' => 35));
    $wp_customize->add_setting('qimah_address', array('default' => 'المملكة العربية السعودية', 'sanitize_callback' => 'sanitize_textarea_field'));
    $wp_customize->add_control('qimah_address', array('label' => 'العنوان', 'section' => 'qimah_contact', 'type' => 'textarea'));
    $wp_customize->add_setting('qimah_contact_phone', array('default' => '+966 00 000 0000', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('qimah_contact_phone', array('label' => 'الهاتف', 'section' => 'qimah_contact', 'type' => 'text'));
    $wp_customize->add_setting('qimah_contact_email', array('default' => 'info@goodwaty.org.sa', 'sanitize_callback' => 'sanitize_email'));
    $wp_customize->add_control('qimah_contact_email', array('label' => 'البريد الإلكتروني', 'section' => 'qimah_contact', 'type' => 'email'));
    $wp_customize->add_setting('qimah_working_hours', array('default' => 'الأحد - الخميس | 8:00 ص - 5:00 م', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('qimah_working_hours', array('label' => 'ساعات العمل', 'section' => 'qimah_contact', 'type' => 'text'));

    // ===== SOCIAL =====
    $wp_customize->add_section('qimah_social', array('title' => 'وسائل التواصل', 'priority' => 36));
    foreach (array('facebook' => 'فيسبوك', 'twitter' => 'تويتر / X', 'linkedin' => 'لينكد إن', 'youtube' => 'يوتيوب', 'instagram' => 'انستغرام', 'whatsapp' => 'واتساب') as $id => $label) {
        $wp_customize->add_setting("qimah_{$id}", array('default' => '', 'sanitize_callback' => 'esc_url_raw'));
        $wp_customize->add_control("qimah_{$id}", array('label' => $label, 'section' => 'qimah_social', 'type' => 'url'));
    }

    // ===== FOOTER =====
    $wp_customize->add_section('qimah_footer', array('title' => 'الفوتر', 'priority' => 37));
    $wp_customize->add_setting('qimah_copyright', array('default' => 'جميع الحقوق محفوظة &copy; ' . date('Y') . ' مركز قيمة وقدوة للتدريب', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('qimah_copyright', array('label' => 'نص حقوق النشر', 'section' => 'qimah_footer', 'type' => 'text'));
    $wp_customize->add_setting('qimah_footer_desc', array('default' => 'مركز قيمة وقدوة للتدريب هو منصة تعليمية رائدة تسعى لبناء جيل واعٍ ومتميز.', 'sanitize_callback' => 'sanitize_textarea_field'));
    $wp_customize->add_control('qimah_footer_desc', array('label' => 'وصف الفوتر', 'section' => 'qimah_footer', 'type' => 'textarea'));
}
add_action('customize_register', 'qimah_customize_register');
