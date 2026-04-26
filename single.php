<?php
/**
 * Single Post Template
 */
get_header();
?>
<div class="page-banner">
    <div class="container">
        <div class="page-banner-content" data-aos="fade-up">
            <h1><?php the_title(); ?></h1>
            <?php qimah_breadcrumb(); ?>
        </div>
    </div>
</div>
<section style="padding:60px 0;">
    <div class="container" style="max-width:800px;">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <h1 class="entry-title" style="margin-bottom:8px;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                <?php qimah_posted_on(); ?> &middot; <?php qimah_posted_by(); ?>
            </header>
            <div class="entry-content" style="margin-top:24px;font-size:1.05rem;line-height:2;">
                <?php the_content(); ?>
            </div>
            <?php if (has_tag()) : qimah_entry_footer(); endif; ?>
        </article>

        <!-- Author Box -->
        <div style="margin-top:40px;background:var(--white);border-radius:var(--radius-xl);padding:32px;box-shadow:var(--shadow-sm);border:1px solid var(--gray-200);">
            <div style="display:flex;gap:20px;align-items:center;">
                <div><?php echo get_avatar(get_the_author_meta('ID'), 80); ?></div>
                <div>
                    <h4 style="font-weight:700;color:var(--dark);margin-bottom:4px;"><?php the_author(); ?></h4>
                    <p style="color:var(--text-secondary);font-size:0.9rem;line-height:1.7;"><?php echo esc_html(get_the_author_meta('description') ?: ''); ?></p>
                </div>
            </div>
        </div>

        <?php comments_template(); ?>
    </div>
</section>
<?php get_footer(); ?>
