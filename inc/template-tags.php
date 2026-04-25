<?php
/**
 * Qimah Wa Qudwah Template Tags
 */

if (!function_exists('qimah_posted_on')) :
function qimah_posted_on() {
    echo '<span class="posted-on"><i class="fas fa-calendar-alt"></i> <time datetime="' . esc_attr(get_the_date(DATE_W3C)) . '">' . esc_html(get_the_date()) . '</time></span>';
}
endif;

if (!function_exists('qimah_posted_by')) :
function qimah_posted_by() {
    echo '<span class="byline"><i class="fas fa-user"></i> <a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>';
}
endif;

if (!function_exists('qimah_breadcrumb')) :
function qimah_breadcrumb() {
    if (is_front_page()) return;
    echo '<nav class="breadcrumb" aria-label="التنقل"><ol class="breadcrumb-list">';
    echo '<li class="breadcrumb-item"><a href="' . home_url('/') . '"><i class="fas fa-home"></i> الرئيسية</a></li>';
    if (is_singular()) {
        echo '<li class="breadcrumb-separator"><i class="fas fa-chevron-left"></i></li>';
        echo '<li class="breadcrumb-item active"><span>' . get_the_title() . '</span></li>';
    } elseif (is_search()) {
        echo '<li class="breadcrumb-separator"><i class="fas fa-chevron-left"></i></li>';
        echo '<li class="breadcrumb-item active"><span>نتائج البحث</span></li>';
    } elseif (is_404()) {
        echo '<li class="breadcrumb-separator"><i class="fas fa-chevron-left"></i></li>';
        echo '<li class="breadcrumb-item active"><span>الصفحة غير موجودة</span></li>';
    } elseif (is_archive()) {
        echo '<li class="breadcrumb-separator"><i class="fas fa-chevron-left"></i></li>';
        echo '<li class="breadcrumb-item active"><span>' . get_the_archive_title() . '</span></li>';
    }
    echo '</ol></nav>';
}
endif;

if (!function_exists('qimah_entry_footer')) :
function qimah_entry_footer() {
    if ('post' === get_post_type()) {
        $categories_list = get_the_category_list(esc_html__(', ', 'qimah-wa-qudwah'));
        if ($categories_list) {
            echo '<div class="entry-footer"><span class="cat-links"><i class="fas fa-folder"></i> ' . $categories_list . '</span></div>';
        }
        $tags_list = get_the_tag_list('', esc_html__(', ', 'qimah-wa-qudwah'));
        if ($tags_list) {
            echo '<div class="entry-footer"><span class="tags-links"><i class="fas fa-tags"></i> ' . $tags_list . '</span></div>';
        }
    }
}
endif;

if (!function_exists('qimah_post_thumbnail')) :
function qimah_post_thumbnail() {
    if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
        return;
    }
    if (is_singular()) :
        echo '<div class="post-thumbnail">';
        the_post_thumbnail('large', array('style' => 'border-radius: var(--radius-xl); margin-bottom: 24px;'));
        echo '</div>';
    else :
        echo '<a class="post-thumbnail" href="' . esc_url(get_permalink()) . '">';
        the_post_thumbnail('post-thumbnail', array('style' => 'border-radius: var(--radius-lg); width: 100%; height: 200px; object-fit: cover;'));
        echo '</a>';
    endif;
}
endif;

function qimah_course_card($post_id = null) {
    if (!$post_id) $post_id = get_the_ID();
    $title = get_the_title($post_id);
    $excerpt = get_the_excerpt($post_id);
    $permalink = get_permalink($post_id);
    $thumb = get_the_post_thumbnail_url($post_id, 'course-thumb');
    $price = get_post_meta($post_id, '_tutor_course_price', true);
    $is_free = ($price === '' || $price === '0');
    $course_level = get_post_meta($post_id, '_tutor_course_level', true);
    $lessons_count = tutor_utils()->get_lesson_count_by_course($post_id);
    ?>
    <div class="course-card" data-aos="fade-up">
        <div class="course-image">
            <?php if ($thumb) : ?>
                <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($title); ?>">
            <?php else : ?>
                <div class="course-img-placeholder"><i class="fas fa-graduation-cap"></i></div>
            <?php endif; ?>
            <?php if (!$is_free && $price) : ?>
                <div class="course-price"><span><?php echo esc_html($price); ?></span><small>ر.س</small></div>
            <?php else : ?>
                <div class="course-price course-price-free"><span>مجاني</span></div>
            <?php endif; ?>
        </div>
        <div class="course-content">
            <div class="course-meta">
                <?php if ($course_level) : ?><span><i class="fas fa-signal"></i> <?php echo esc_html($course_level); ?></span><?php endif; ?>
                <span><i class="fas fa-clock"></i> <?php echo intval($lessons_count); ?> درس</span>
            </div>
            <h3 class="course-title"><a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a></h3>
            <p class="course-excerpt"><?php echo esc_html($excerpt); ?></p>
            <div class="course-footer">
                <a href="<?php echo esc_url($permalink); ?>" class="course-btn">سجّل الآن</a>
            </div>
        </div>
    </div>
    <?php
}
