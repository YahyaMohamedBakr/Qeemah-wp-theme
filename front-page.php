<?php
/**
 * Homepage Template
 */
get_header();
?>

<?php if (is_front_page()) : ?>

<?php get_template_part('template-parts/hero-section'); ?>
<?php if (get_theme_mod('qimah_show_stats', true)) get_template_part('template-parts/stats-section'); ?>
<?php get_template_part('template-parts/about-section'); ?>
<?php if (get_theme_mod('qimah_show_categories', true)) get_template_part('template-parts/categories-section'); ?>
<?php get_template_part('template-parts/courses-section'); ?>
<?php get_template_part('template-parts/features-section'); ?>
<?php if (get_theme_mod('qimah_show_instructors', true)) get_template_part('template-parts/instructors-section'); ?>
<?php if (get_theme_mod('qimah_show_testimonials', true)) get_template_part('template-parts/testimonials-section'); ?>
<?php get_template_part('template-parts/cta-section'); ?>
<?php get_template_part('template-parts/newsletter-section'); ?>

<?php else : ?>
<div class="page-banner">
    <div class="container">
        <div class="page-banner-content" data-aos="fade-up">
            <h1><?php the_title(); ?></h1>
            <?php qimah_breadcrumb(); ?>
        </div>
    </div>
</div>
<section style="padding: 60px 0;">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                </header>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</section>
<?php endif; ?>

<?php get_footer(); ?>
