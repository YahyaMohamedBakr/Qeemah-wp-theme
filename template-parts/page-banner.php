<?php
/**
 * Page Banner - Used on inner pages
 */
$title = is_search() ? 'نتائج البحث: ' . get_search_query() : get_the_title();
?>
<section class="page-banner">
    <div class="container">
        <div class="page-banner-content" data-aos="fade-up">
            <h1><?php echo wp_kses_post($title); ?></h1>
            <?php qimah_breadcrumb(); ?>
        </div>
    </div>
</section>
