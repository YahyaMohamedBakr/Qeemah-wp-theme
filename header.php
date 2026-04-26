<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

    <!-- Preloader -->
    <div class="preloader" id="preloader">
        <div class="preloader-inner">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <img src="<?php echo esc_url(QIMAH_URI . '/assets/images/logo.png'); ?>" alt="<?php bloginfo('name'); ?>" class="preloader-logo">
            <?php endif; ?>
            <div class="preloader-spinner"></div>
        </div>
    </div>

    <!-- Header -->
    <header class="header <?php echo is_front_page() ? '' : 'header-inner-page'; ?>" id="header">
        <div class="container">
            <div class="header-inner">
                <!-- Logo -->
                <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
                    <?php if (has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <img src="<?php echo esc_url(QIMAH_URI . '/assets/images/logo.png'); ?>" alt="<?php bloginfo('name'); ?>">
                    <?php endif; ?>
                </a>

                <!-- Navigation -->
                <nav class="nav" id="nav">
                    <?php wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_class'     => 'nav-list',
                        'items_wrap'     => '%3$s',
                        'fallback_cb'    => function() {
                            echo '<ul class="nav-list">';
                            echo '<li class="nav-item ' . (is_front_page() ? 'active' : '') . '"><a href="' . home_url('/') . '" class="nav-link">الرئيسية</a></li>';
                            echo '<li class="nav-item"><a href="' . home_url('/') . '#about" class="nav-link">من نحن</a></li>';
                            echo '<li class="nav-item"><a href="' . home_url('/') . '#courses" class="nav-link">الدورات</a></li>';
                            echo '<li class="nav-item"><a href="' . home_url('/') . '#instructors" class="nav-link">المدربون</a></li>';
                            echo '<li class="nav-item"><a href="' . home_url('/') . '#testimonials" class="nav-link">الآراء</a></li>';
                            echo '<li class="nav-item"><a href="' . esc_url(get_permalink(get_page_by_path('contact'))) . '" class="nav-link">اتصل بنا</a></li>';
                            echo '</ul>';
                        },
                    )); ?>
                </nav>

                <!-- Header Actions -->
                <div class="header-actions">
                    <button class="btn-search" id="btnSearch" aria-label="بحث"><i class="fas fa-search"></i></button>
                    <?php if (is_user_logged_in()) : ?>
                        <a href="<?php echo esc_url(home_url('/dashboard')); ?>" class="btn btn-primary btn-sm"><i class="fas fa-tachometer-alt"></i> لوحة التحكم</a>
                    <?php else : ?>
                        <?php if (get_theme_mod('qimah_show_login', true)) : ?>
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('login')) ?: wp_login_url()); ?>" class="btn btn-primary btn-sm">تسجيل الدخول</a>
                        <?php endif; ?>
                        <?php if (get_theme_mod('qimah_show_register', true)) : ?>
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('login')) ?: wp_registration_url()); ?>" class="btn btn-outline btn-sm">حساب جديد</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- Mobile Menu Toggle -->
                <button class="menu-toggle" id="menuToggle" aria-label="القائمة">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>

        <!-- Search Overlay -->
        <div class="search-overlay" id="searchOverlay">
            <div class="container">
                <?php get_search_form(); ?>
            </div>
        </div>
    </header>

    <main id="main" class="site-main">
