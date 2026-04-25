<?php get_header(); ?>
<div class="page-banner">
    <div class="container">
        <div class="page-banner-content" data-aos="fade-up">
            <h1><?php esc_html_e('الصفحة غير موجودة', 'qimah-wa-qudwah'); ?></h1>
            <?php qimah_breadcrumb(); ?>
        </div>
    </div>
</div>
<section style="padding:80px 0;text-align:center;">
    <div class="container">
        <div style="font-size:6rem;color:var(--primary);margin-bottom:20px;"><i class="fas fa-exclamation-triangle"></i></div>
        <h2 style="margin-bottom:16px;"><?php esc_html_e('الصفحة التي تبحث عنها غير موجودة', 'qimah-wa-qudwah'); ?></h2>
        <p style="color:var(--text-secondary);margin-bottom:24px;"><?php esc_html_e('يمكنك العودة إلى الصفحة الرئيسية أو البحث عن محتوى آخر.', 'qimah-wa-qudwah'); ?></p>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary btn-lg"><span>العودة للرئيسية</span><i class="fas fa-home"></i></a>
    </div>
</section>
<?php get_footer(); ?>
