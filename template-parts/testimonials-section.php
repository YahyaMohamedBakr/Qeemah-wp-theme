<?php
/**
 * Testimonials Section — Dynamic from CPT: qimah_testimonial
 * Shows first few cards statically, rest in Swiper carousel
 */
$testimonial_query = new WP_Query(array(
    'post_type'      => 'qimah_testimonial',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order date',
    'order'          => 'ASC',
    'post_status'    => 'publish',
));
$total_testimonials = $testimonial_query->found_posts;
$static_count = 3;
$use_carousel  = ($total_testimonials > $static_count);
?>
<section class="testimonials" id="testimonials">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-badge center"><i class="fas fa-quote-right"></i><span>آراء المتدربين</span></div>
            <h2 class="section-title center">ماذا يقول متدربونا عنا</h2>
            <p class="section-desc center">تجارب حقيقية من متدربين استفادوا من برامجنا التدريبية</p>
        </div>
        <?php if ($testimonial_query->have_posts()) : ?>
            <?php if ($use_carousel) : ?>
            <!-- Carousel Mode -->
            <div class="swiper testimonials-swiper" data-aos="fade-up">
                <div class="swiper-wrapper">
                    <?php while ($testimonial_query->have_posts()) : $testimonial_query->the_post();
                        $post_id = get_the_ID();
                        $role    = get_post_meta($post_id, '_qimah_testimonial_role', true);
                        $rating  = get_post_meta($post_id, '_qimah_testimonial_rating', true);
                        $avatar  = get_the_post_thumbnail_url($post_id, 'thumbnail');
                    ?>
                    <div class="swiper-slide">
                        <div class="testimonial-card">
                            <div class="testimonial-rating">
                                <?php echo qimah_star_rating_html($rating ?: 5); ?>
                            </div>
                            <p class="testimonial-text"><?php echo esc_html(get_the_content()); ?></p>
                            <div class="testimonial-author">
                                <?php if ($avatar) : ?>
                                    <div class="testimonial-avatar">
                                        <img src="<?php echo esc_url($avatar); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                                    </div>
                                <?php else : ?>
                                    <div class="testimonial-avatar"><i class="fas fa-user"></i></div>
                                <?php endif; ?>
                                <div class="testimonial-info">
                                    <h4><?php the_title(); ?></h4>
                                    <?php if ($role) : ?><span><?php echo esc_html($role); ?></span><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <?php else : ?>
            <!-- Static Mode: 3 or fewer -->
            <div class="testimonials-grid" data-aos="fade-up">
                <?php while ($testimonial_query->have_posts()) : $testimonial_query->the_post();
                    $post_id = get_the_ID();
                    $role    = get_post_meta($post_id, '_qimah_testimonial_role', true);
                    $rating  = get_post_meta($post_id, '_qimah_testimonial_rating', true);
                    $avatar  = get_the_post_thumbnail_url($post_id, 'thumbnail');
                ?>
                <div class="testimonial-card">
                    <div class="testimonial-rating">
                        <?php echo qimah_star_rating_html($rating ?: 5); ?>
                    </div>
                    <p class="testimonial-text"><?php echo esc_html(get_the_content()); ?></p>
                    <div class="testimonial-author">
                        <?php if ($avatar) : ?>
                            <div class="testimonial-avatar">
                                <img src="<?php echo esc_url($avatar); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                            </div>
                        <?php else : ?>
                            <div class="testimonial-avatar"><i class="fas fa-user"></i></div>
                        <?php endif; ?>
                        <div class="testimonial-info">
                            <h4><?php the_title(); ?></h4>
                            <?php if ($role) : ?><span><?php echo esc_html($role); ?></span><?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
            <?php endif; ?>
        <?php else : ?>
            <div class="section-desc center">
                <p>لم يتم إضافة آراء بعد. <a href="<?php echo esc_url(admin_url('post-new.php?post_type=qimah_testimonial')); ?>">إضافة رأي جديد</a></p>
            </div>
        <?php endif; ?>
    </div>
</section>
