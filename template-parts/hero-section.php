<?php
/**
 * Hero Section
 */
$hero_title    = get_theme_mod('qimah_hero_title', 'مركز قيمة وقدوة للتدريب');
$hero_subtitle = nl2br(esc_html(get_theme_mod('qimah_hero_subtitle', "نُؤمن أن القيم هي البداية الحقيقية لأي تغيير...\nابدأ رحلتك نحو التميز مع مركز قيمة وقدوة للتدريب!")));
$hero_badge   = get_theme_mod('qimah_hero_badge', 'منصة تعليمية معتمدة');
?>
<section class="hero" id="hero">
    <div class="hero-bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="shape shape-4"></div>
    </div>
    <div class="container">
        <div class="hero-content">
            <div class="hero-badge" data-aos="fade-down" data-aos-delay="200">
                <i class="fas fa-graduation-cap"></i>
                <span><?php echo esc_html($hero_badge); ?></span>
            </div>
            <h1 class="hero-title" data-aos="fade-up" data-aos-delay="300">
                <?php echo wp_kses_post($hero_title); ?>
            </h1>
            <p class="hero-desc" data-aos="fade-up" data-aos-delay="400">
                <?php echo $hero_subtitle; ?>
            </p>
            <div class="hero-btns" data-aos="fade-up" data-aos-delay="500">
                <a href="#courses" class="btn btn-primary btn-lg">
                    <span>استكشف الدورات</span>
                    <i class="fas fa-arrow-left"></i>
                </a>
                <a href="#about" class="btn btn-glass btn-lg">
                    <i class="fas fa-play-circle"></i>
                    <span>تعرف علينا</span>
                </a>
            </div>
            <div class="hero-stats" data-aos="fade-up" data-aos-delay="600">
                <div class="hero-stat">
                    <div class="hero-stat-icon"><i class="fas fa-book-open"></i></div>
                    <div class="hero-stat-info"><strong>150+</strong><span>دورة تدريبية</span></div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-icon"><i class="fas fa-users"></i></div>
                    <div class="hero-stat-info"><strong>5,000+</strong><span>متدرب</span></div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    <div class="hero-stat-info"><strong>50+</strong><span>مدرب معتمد</span></div>
                </div>
            </div>
        </div>
        <div class="hero-visual" data-aos="fade-left" data-aos-delay="400">
            <div class="hero-image-wrapper">
                <div class="hero-circle hero-circle-1"></div>
                <div class="hero-circle hero-circle-2"></div>
                <div class="hero-card hero-card-1"><i class="fas fa-certificate"></i><span>شهادات معتمدة</span></div>
                <div class="hero-card hero-card-2"><i class="fas fa-laptop-code"></i><span>تعلم عن بعد</span></div>
                <div class="hero-card hero-card-3"><i class="fas fa-star"></i><span>تقييم عالي</span></div>
            </div>
        </div>
    </div>
    <div class="hero-wave">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,60 C360,120 720,0 1080,60 C1260,90 1380,80 1440,70 L1440,120 L0,120 Z" fill="#ffffff"/>
        </svg>
    </div>
</section>
