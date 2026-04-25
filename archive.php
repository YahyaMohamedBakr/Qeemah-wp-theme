<?php
get_header();
get_template_part('template-parts/page-banner');
?>
<section style="padding:60px 0;">
    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="courses-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <?php qimah_post_thumbnail(); ?>
                        <div class="course-content" style="margin-top:16px;">
                            <h2 class="course-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p class="course-excerpt"><?php the_excerpt(); ?></p>
                            <div class="course-footer" style="margin-top:16px;">
                                <?php qimah_posted_on(); ?>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            <?php the_posts_navigation(array('mid_size' => 2, 'prev_text' => '&rarr; السابق', 'next_text' => 'التالي &larr;')); ?>
        <?php else : ?>
            <div class="section-desc center"><?php esc_html_e('لا توجد نتائج.', 'qimah-wa-qudwah'); ?></div>
        <?php endif; ?>
    </div>
</section>
<?php get_footer(); ?>
