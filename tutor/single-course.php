<?php
/**
 * Single Course Template Override for Tutor LMS
 * This file overrides Tutor LMS's default single-course.php
 * Following the same approach as Edubin theme
 *
 * @package Qimah_Wa_Qudwah
 */

get_header();

// Course Header
while (have_posts()) : the_post();
    get_template_part('template-parts/page-banner');
endwhile; wp_reset_postdata();

// Content Area
echo '<main class="course-page"><div class="container"><div class="course-layout">';
echo '<div class="course-main">';

while (have_posts()) : the_post();
    get_template_part('tutor/tpl-part/single/single', 'content');
endwhile;

echo '</div>'; // End course-main

echo '<aside class="course-sidebar">';
get_template_part('tutor/tpl-part/single/single', 'sidebar');
echo '</aside>'; // End course-sidebar

echo '</div></div></main>';

get_footer();
