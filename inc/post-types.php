<?php
/**
 * Custom Post Types & Meta Boxes
 * - qimah_instructor: المدربون
 * - qimah_testimonial: آراء المتدربين
 */

/* ========================================================================
   CPT: المدربون (Instructors)
   ======================================================================== */
function qimah_register_instructor_cpt() {
    $labels = array(
        'name'               => 'المدربون',
        'singular_name'      => 'مدرب',
        'menu_name'          => 'المدربون',
        'add_new'            => 'إضافة مدرب جديد',
        'add_new_item'       => 'إضافة مدرب جديد',
        'edit_item'          => 'تعديل المدرب',
        'new_item'           => 'مدرب جديد',
        'view_item'          => 'عرض المدرب',
        'search_items'       => 'البحث في المدربين',
        'not_found'          => 'لا يوجد مدربون',
        'not_found_in_trash' => 'لا يوجد مدربون في سلة المحذوفات',
        'all_items'          => 'جميع المدربين',
    );

    register_post_type('qimah_instructor', array(
        'labels'       => $labels,
        'public'       => true,
        'publicly_queryable' => true,
        'show_ui'      => true,
        'show_in_menu' => true,
        'show_in_rest' => false,
        'menu_icon'    => 'dashicons-welcome-learn-more',
        'menu_position'=> 25,
        'supports'     => array('title', 'editor', 'thumbnail'),
        'rewrite'      => array('slug' => 'instructor', 'with_front' => false),
        'has_archive'  => false,
    ));
}
add_action('init', 'qimah_register_instructor_cpt');

/* ========================================================================
   CPT: آراء المتدربين (Testimonials)
   ======================================================================== */
function qimah_register_testimonial_cpt() {
    $labels = array(
        'name'               => 'آراء المتدربين',
        'singular_name'      => 'رأي',
        'menu_name'          => 'آراء المتدربين',
        'add_new'            => 'إضافة رأي جديد',
        'add_new_item'       => 'إضافة رأي جديد',
        'edit_item'          => 'تعديل الرأي',
        'new_item'           => 'رأي جديد',
        'view_item'          => 'عرض الرأي',
        'search_items'       => 'البحث في الآراء',
        'not_found'          => 'لا توجد آراء',
        'not_found_in_trash' => 'لا توجد آراء في سلة المحذوفات',
        'all_items'          => 'جميع الآراء',
    );

    register_post_type('qimah_testimonial', array(
        'labels'       => $labels,
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_icon'    => 'dashicons-format-quote',
        'menu_position'=> 26,
        'supports'     => array('title', 'editor', 'thumbnail'),
        'rewrite'      => false,
        'has_archive'  => false,
    ));
}
add_action('init', 'qimah_register_testimonial_cpt');

/* ========================================================================
   Meta Boxes: المدربون
   ======================================================================== */
function qimah_instructor_meta_boxes() {
    add_meta_box('qimah_instructor_details', 'بيانات المدرب الإضافية', 'qimah_instructor_meta_box_callback', 'qimah_instructor', 'normal', 'high');
}
add_action('add_meta_boxes', 'qimah_instructor_meta_boxes');

function qimah_instructor_meta_box_callback($post) {
    wp_nonce_field('qimah_instructor_meta', 'qimah_instructor_nonce');
    $specialization = get_post_meta($post->ID, '_qimah_instructor_specialization', true);
    $courses_count  = get_post_meta($post->ID, '_qimah_instructor_courses_count', true);
    $students_count = get_post_meta($post->ID, '_qimah_instructor_students_count', true);
    $rating         = get_post_meta($post->ID, '_qimah_instructor_rating', true);
    $linkedin       = get_post_meta($post->ID, '_qimah_instructor_linkedin', true);
    $twitter        = get_post_meta($post->ID, '_qimah_instructor_twitter', true);
    $email          = get_post_meta($post->ID, '_qimah_instructor_email', true);
    ?>
    <style>
        .qimah-meta-field { margin-bottom: 16px; }
        .qimah-meta-field label { display: block; font-weight: 600; margin-bottom: 6px; color: #1d2327; }
        .qimah-meta-field input, .qimah-meta-field textarea { width: 100%; padding: 8px 12px; border: 1px solid #8c8f94; border-radius: 4px; font-size: 14px; }
        .qimah-meta-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    </style>
    <div class="qimah-meta-row">
        <div class="qimah-meta-field">
            <label for="qimah_specialization">التخصص</label>
            <input type="text" id="qimah_specialization" name="qimah_specialization" value="<?php echo esc_attr($specialization); ?>" placeholder="مثال: مدرب تسويق رقمي">
        </div>
        <div class="qimah-meta-field">
            <label for="qimah_rating">التقييم (من 5)</label>
            <input type="number" id="qimah_rating" name="qimah_rating" value="<?php echo esc_attr($rating); ?>" min="0" max="5" step="0.1" placeholder="4.5">
        </div>
    </div>
    <div class="qimah-meta-row">
        <div class="qimah-meta-field">
            <label for="qimah_courses_count">عدد الدورات</label>
            <input type="number" id="qimah_courses_count" name="qimah_courses_count" value="<?php echo esc_attr($courses_count); ?>" min="0" placeholder="12">
        </div>
        <div class="qimah-meta-field">
            <label for="qimah_students_count">عدد المتدربين</label>
            <input type="number" id="qimah_students_count" name="qimah_students_count" value="<?php echo esc_attr($students_count); ?>" min="0" placeholder="500">
        </div>
    </div>
    <div class="qimah-meta-row">
        <div class="qimah-meta-field">
            <label for="qimah_linkedin">رابط LinkedIn</label>
            <input type="url" id="qimah_linkedin" name="qimah_linkedin" value="<?php echo esc_url($linkedin); ?>" placeholder="https://linkedin.com/in/..." dir="ltr">
        </div>
        <div class="qimah-meta-field">
            <label for="qimah_twitter">رابط Twitter / X</label>
            <input type="url" id="qimah_twitter" name="qimah_twitter" value="<?php echo esc_url($twitter); ?>" placeholder="https://twitter.com/..." dir="ltr">
        </div>
    </div>
    <div class="qimah-meta-field">
        <label for="qimah_email">البريد الإلكتروني</label>
        <input type="email" id="qimah_email" name="qimah_email" value="<?php echo esc_attr($email); ?>" placeholder="trainer@example.com" dir="ltr">
    </div>
    <p style="color:#666;font-size:13px;margin-top:8px;">
        <strong>ملاحظة:</strong> عنوان المقال هو اسم المدرب، والمحتوى (المحرر) هو النبذة التعريفية (البايو)، والصورة البارزة هي صورة المدرب.
    </p>
    <?php
}

function qimah_save_instructor_meta($post_id) {
    if (!isset($_POST['qimah_instructor_nonce']) || !wp_verify_nonce($_POST['qimah_instructor_nonce'], 'qimah_instructor_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $fields = array(
        'qimah_specialization'   => '_qimah_instructor_specialization',
        'qimah_courses_count'    => '_qimah_instructor_courses_count',
        'qimah_students_count'   => '_qimah_instructor_students_count',
        'qimah_rating'           => '_qimah_instructor_rating',
        'qimah_linkedin'         => '_qimah_instructor_linkedin',
        'qimah_twitter'          => '_qimah_instructor_twitter',
        'qimah_email'            => '_qimah_instructor_email',
    );

    foreach ($fields as $input => $meta) {
        if (isset($_POST[$input])) {
            $val = sanitize_text_field($_POST[$input]);
            update_post_meta($post_id, $meta, $val);
        }
    }
}
add_action('save_post_qimah_instructor', 'qimah_save_instructor_meta');

/* ========================================================================
   Meta Boxes: آراء المتدربين
   ======================================================================== */
function qimah_testimonial_meta_boxes() {
    add_meta_box('qimah_testimonial_details', 'بيانات الرأي الإضافية', 'qimah_testimonial_meta_box_callback', 'qimah_testimonial', 'normal', 'high');
}
add_action('add_meta_boxes', 'qimah_testimonial_meta_boxes');

function qimah_testimonial_meta_box_callback($post) {
    wp_nonce_field('qimah_testimonial_meta', 'qimah_testimonial_nonce');
    $role   = get_post_meta($post->ID, '_qimah_testimonial_role', true);
    $rating = get_post_meta($post->ID, '_qimah_testimonial_rating', true);
    ?>
    <style>
        .qimah-meta-field { margin-bottom: 16px; }
        .qimah-meta-field label { display: block; font-weight: 600; margin-bottom: 6px; color: #1d2327; }
        .qimah-meta-field input, .qimah-meta-field textarea { width: 100%; padding: 8px 12px; border: 1px solid #8c8f94; border-radius: 4px; font-size: 14px; }
        .qimah-meta-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    </style>
    <div class="qimah-meta-row">
        <div class="qimah-meta-field">
            <label for="qimah_testimonial_role">الدور / الوظيفة</label>
            <input type="text" id="qimah_testimonial_role" name="qimah_testimonial_role" value="<?php echo esc_attr($role); ?>" placeholder="مثال: متدرب - دورة التسويق الرقمي - مصر">
        </div>
        <div class="qimah-meta-field">
            <label for="qimah_testimonial_rating">التقييم (من 5)</label>
            <input type="number" id="qimah_testimonial_rating" name="qimah_testimonial_rating" value="<?php echo esc_attr($rating); ?>" min="1" max="5" step="1" placeholder="5">
        </div>
    </div>
    <p style="color:#666;font-size:13px;margin-top:8px;">
        <strong>ملاحظة:</strong> عنوان المقال هو اسم المتدرب، والمحتوى (المحرر) هو نص الرأي/التجربة، والصورة البارزة (اختيارية) هي صورة المتدرب.
    </p>
    <?php
}

function qimah_save_testimonial_meta($post_id) {
    if (!isset($_POST['qimah_testimonial_nonce']) || !wp_verify_nonce($_POST['qimah_testimonial_nonce'], 'qimah_testimonial_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['qimah_testimonial_role'])) {
        update_post_meta($post_id, '_qimah_testimonial_role', sanitize_text_field($_POST['qimah_testimonial_role']));
    }
    if (isset($_POST['qimah_testimonial_rating'])) {
        $r = intval($_POST['qimah_testimonial_rating']);
        update_post_meta($post_id, '_qimah_testimonial_rating', max(1, min(5, $r)));
    }
}
add_action('save_post_qimah_testimonial', 'qimah_save_testimonial_meta');

/* ========================================================================
   Helper: Generate star rating HTML
   ======================================================================== */
function qimah_star_rating_html($rating = 5) {
    $rating = max(1, min(5, intval($rating)));
    $html = '';
    for ($i = 1; $i <= 5; $i++) {
        $html .= '<i class="fas fa-star"></i>';
    }
    return $html;
}
