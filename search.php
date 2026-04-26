<?php
get_header();
get_template_part('template-parts/page-banner');
?>
<section style="padding:60px 0;">
    <div class="container">
        <div class="section-header"><h2 class="section-title center"><?php printf(esc_html__('نتائج البحث عن: %s', 'qimah-wa-qudwah'), '<span>' . get_search_query() . '</span>'); ?></h2></div>
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article <?php post_class(); ?> style="margin-bottom:24px;background:var(--white);border-radius:var(--radius-xl);padding:24px;box-shadow:var(--shadow-sm);border:1px solid var(--gray-200);">
                <h2 class="course-title"><a href="<?php the_permalink(); ?>" style="color:var(--dark);"><?php the_title(); ?></a></h2>
                <p class="course-excerpt"><?php the_excerpt(); ?></p>
            </article>
        <?php endwhile; the_posts_navigation(); else : ?>
            <p style="text-align:center;color:var(--text-secondary);"><?php esc_html_e('لم يتم العثور عن نتائج.', 'qimah-wa-qudwah'); ?></p>
        <?php endif; ?>
    </div>
</section>
<?php get_footer(); ?>
