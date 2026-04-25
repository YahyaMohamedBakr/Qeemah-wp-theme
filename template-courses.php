<?php
/**
 * Template Name: صفحة الدورات (أرشيف)
 * Description: صفحة أرشيف الدورات متوافقة مع Tutor LMS
 */
get_header();
get_template_part('template-parts/page-banner');
?>
<main class="courses-archive">
    <div class="container">
        <div class="courses-archive-layout">
            <!-- Content Area -->
            <div class="archive-content">
                <!-- Search Bar -->
                <div class="archive-search" data-aos="fade-up">
                    <?php get_search_form(); ?>
                </div>

                <!-- Filter & Sort Toolbar -->
                <div class="archive-toolbar" data-aos="fade-up" data-aos-delay="100">
                    <div class="archive-filter-btns">
                        <button class="archive-filter-btn active" data-filter="all"><i class="fas fa-th-large"></i> الكل <span class="badge-count"><?php echo $wp_query->found_posts; ?></span></button>
                        <button class="archive-filter-btn" data-filter="remote"><i class="fas fa-video"></i> عن بعد</button>
                        <button class="archive-filter-btn" data-filter="recorded"><i class="fas fa-play-circle"></i> مسجلة</button>
                        <button class="archive-filter-btn" data-filter="free"><i class="fas fa-gift"></i> مجانية</button>
                    </div>
                </div>

                <!-- Results Info -->
                <div class="archive-results-info" data-aos="fade-up">
                    <p class="archive-results-count">عرض <strong><?php echo $wp_query->found_posts; ?> دورة</strong></p>
                </div>

                <!-- Course Cards Grid -->
                <?php if (have_posts()) : ?>
                <div class="archive-courses-grid">
                    <?php while (have_posts()) : the_post();
                        qimah_course_card(get_the_ID());
                    endwhile; ?>
                </div>
                    <?php the_posts_pagination(array(
                        'mid_size'  => 2,
                        'prev_text' => '<i class="fas fa-chevron-right"></i>',
                        'next_text' => '<i class="fas fa-chevron-left"></i>',
                        'type'      => 'list',
                    )); ?>
                <?php else : ?>
                <div class="section-desc center" style="padding:40px 0;grid-column:1/-1;">
                    <p>لا توجد دورات حالياً. قم بتفعيل Tutor LMS وإضافة دورات.</p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <?php get_sidebar('sidebar-courses'); ?>
        </div>
    </div>
</main>
<?php get_footer(); ?>
