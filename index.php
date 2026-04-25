<?php
/**
 * The main template file - Required by WordPress
 *
 * Qimah Wa Qudwah Theme
 */

get_header();
?>

<?php if (is_home() && !is_front_page()) : ?>
    <div class="page-banner">
        <div class="container">
            <div class="page-banner-content">
                <h1><?php single_post_title(); ?></h1>
                <?php if (function_exists('qimah_breadcrumb')) qimah_breadcrumb(); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<section class="blog-section" style="padding: 60px 0;">
    <div class="container">
        <?php if (have_posts()) : ?>

            <div class="posts-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('blog-card'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="blog-card-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('large'); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="blog-card-content">
                            <div class="blog-card-meta">
                                <span><i class="fas fa-calendar-alt"></i> <?php echo get_the_date(); ?></span>
                                <span><i class="fas fa-user"></i> <?php the_author(); ?></span>
                                <?php if (has_category()) : ?>
                                    <span><i class="fas fa-folder"></i> <?php the_category(', '); ?></span>
                                <?php endif; ?>
                            </div>

                            <h2 class="blog-card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>

                            <div class="blog-card-excerpt">
                                <?php the_excerpt(); ?>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm">
                                <?php esc_html_e('اقرأ المزيد', 'qimah-wa-qudwah'); ?>
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="pagination">
                <?php
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => '<i class="fas fa-chevron-right"></i>',
                    'next_text' => '<i class="fas fa-chevron-left"></i>',
                    'class'     => 'pagination-links',
                ));
                ?>
            </div>

        <?php else : ?>

            <div class="no-results" style="text-align: center; padding: 80px 0;">
                <i class="fas fa-search" style="font-size: 4rem; color: var(--gray-400); margin-bottom: 24px; display: block;"></i>
                <h2 style="margin-bottom: 12px;"><?php esc_html_e('لا توجد نتائج', 'qimah-wa-qudwah'); ?></h2>
                <p style="color: var(--text-muted); margin-bottom: 24px;">
                    <?php esc_html_e('عذراً، لم نجد محتوى مطابق لبحثك.', 'qimah-wa-qudwah'); ?>
                </p>
                <div class="search-form" style="max-width: 500px; margin: 0 auto;">
                    <?php get_search_form(); ?>
                </div>
            </div>

        <?php endif; ?>
    </div>
</section>

<style>
    .posts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }
    .blog-card {
        background: var(--white);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid var(--gray-200, #e5e7eb);
    }
    .blog-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 48px rgba(0, 0, 0, 0.12);
    }
    .blog-card-image img {
        width: 100%;
        height: 220px;
        object-fit: cover;
    }
    .blog-card-content {
        padding: 24px;
    }
    .blog-card-meta {
        display: flex;
        gap: 16px;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }
    .blog-card-meta span {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.82rem;
        color: #9ca3af;
    }
    .blog-card-meta span i {
        color: #2090b0;
        font-size: 0.75rem;
    }
    .blog-card-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 10px;
        line-height: 1.5;
    }
    .blog-card-title a {
        color: inherit;
        transition: color 0.3s ease;
    }
    .blog-card-title a:hover {
        color: #2090b0;
    }
    .blog-card-excerpt {
        font-size: 0.9rem;
        color: #4b5563;
        line-height: 1.8;
        margin-bottom: 16px;
    }
    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 40px;
    }
    .pagination-links {
        display: flex;
        gap: 8px;
        list-style: none;
    }
    .pagination-links .page-numbers {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        color: #4b5563;
        background: #f3f4f6;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    .pagination-links .page-numbers.current,
    .pagination-links .page-numbers:hover {
        background: linear-gradient(135deg, #2090b0, #107080);
        color: #ffffff;
        box-shadow: 0 8px 24px rgba(32, 144, 176, 0.25);
    }
</style>

<?php
get_footer();
