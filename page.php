<?php
get_header();
get_template_part('template-parts/page-banner');
?>
<section style="padding:60px 0;">
    <div class="container">
        <article <?php post_class(); ?>>
            <header class="entry-header">
                <h1 class="entry-title" style="margin-top:16px;"><?php the_title(); ?></h1>
            </header>
            <div class="entry-content" style="margin-top:24px;">
                <?php the_content(); ?>
            </div>
            <?php qimah_entry_footer(); ?>
        </article>
        <?php comments_template(); ?>
    </div>
</section>
<?php get_footer(); ?>
