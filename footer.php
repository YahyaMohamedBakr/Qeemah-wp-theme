    </main><!-- #main -->

    <!-- Back to Top -->
    <button class="back-to-top" id="backToTop" aria-label="العودة للأعلى">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <!-- Column 1: About -->
                <div class="footer-col">
                    <?php if (is_active_sidebar('footer-1')) : ?>
                        <?php dynamic_sidebar('footer-1'); ?>
                    <?php else : ?>
                    <div class="footer-logo">
                        <?php if (has_custom_logo()) : ?>
                            <?php the_custom_logo(); ?>
                        <?php else : ?>
                            <img src="<?php echo esc_url(QIMAH_URI . '/assets/images/logo.png'); ?>" alt="<?php bloginfo('name'); ?>">
                        <?php endif; ?>
                    </div>
                    <p class="footer-desc"><?php echo esc_html(get_theme_mod('qimah_footer_desc', 'مركز قيمة وقدوة للتدريب هو منصة تعليمية رائدة تسعى لبناء جيل واعٍ ومتميز.')); ?></p>
                    <div class="footer-social">
                        <?php foreach (array('facebook', 'twitter', 'linkedin', 'youtube', 'instagram', 'whatsapp') as $s) :
                            $url = get_theme_mod("qimah_{$s}", '');
                            if ($url) : ?>
                                <a href="<?php echo esc_url($url); ?>" class="social-link" target="_blank" rel="noopener">
                                    <i class="fab fa-<?php echo $s === 'twitter' ? 'x-twitter' : ($s === 'whatsapp' ? 'whatsapp' : $s); ?>"></i>
                                </a>
                            <?php endif;
                        endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Column 2: Quick Links -->
                <div class="footer-col">
                    <?php if (is_active_sidebar('footer-2')) : ?>
                        <?php dynamic_sidebar('footer-2'); ?>
                    <?php else : ?>
                    <h4 class="footer-heading">روابط سريعة</h4>
                    <ul class="footer-links">
                        <li><a href="<?php echo esc_url(home_url('/')); ?>"><i class="fas fa-chevron-left"></i> الرئيسية</a></li>
                        <?php wp_nav_menu(array('theme_location' => 'footer', 'container' => false, 'items_wrap' => '%3$s', 'depth' => 1, 'fallback_cb' => false)); ?>
                    </ul>
                    <?php endif; ?>
                </div>

                <!-- Column 3: Useful Links -->
                <div class="footer-col">
                    <?php if (is_active_sidebar('footer-3')) : ?>
                        <?php dynamic_sidebar('footer-3'); ?>
                    <?php else : ?>
                    <h4 class="footer-heading">الدورات</h4>
                    <ul class="footer-links">
                        <li><a href="<?php echo esc_url(home_url('/')); ?>"><i class="fas fa-chevron-left"></i> جميع الدورات</a></li>
                        <li><a href="<?php echo esc_url(home_url('/')); ?>"><i class="fas fa-chevron-left"></i> الدورات المسجلة</a></li>
                        <li><a href="<?php echo esc_url(home_url('/')); ?>"><i class="fas fa-chevron-left"></i> الدورات المجانية</a></li>
                        <li><a href="<?php echo esc_url(home_url('/')); ?>"><i class="fas fa-chevron-left"></i> الدورات عن بُعد</a></li>
                    </ul>
                    <?php endif; ?>
                </div>

                <!-- Column 4: Contact -->
                <div class="footer-col">
                    <?php if (is_active_sidebar('footer-4')) : ?>
                        <?php dynamic_sidebar('footer-4'); ?>
                    <?php else : ?>
                    <h4 class="footer-heading">تواصل معنا</h4>
                    <ul class="footer-contact">
                        <li><i class="fas fa-map-marker-alt"></i> <span><?php echo esc_html(get_theme_mod('qimah_address', 'المملكة العربية السعودية')); ?></span></li>
                        <li><i class="fas fa-envelope"></i> <a href="mailto:<?php echo esc_attr(get_theme_mod('qimah_contact_email', 'info@goodwaty.org.sa')); ?>"><?php echo esc_html(get_theme_mod('qimah_contact_email', 'info@goodwaty.org.sa')); ?></a></li>
                        <li><i class="fas fa-phone-alt"></i> <a href="tel:<?php echo esc_attr(get_theme_mod('qimah_contact_phone', '+966000000000')); ?>" dir="ltr"><?php echo esc_html(get_theme_mod('qimah_contact_phone', '+966 00 000 0000')); ?></a></li>
                        <li><i class="fas fa-clock"></i> <span><?php echo esc_html(get_theme_mod('qimah_working_hours', 'الأحد - الخميس | 8:00 ص - 5:00 م')); ?></span></li>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <p><?php echo wp_kses_post(get_theme_mod('qimah_copyright', 'جميع الحقوق محفوظة &copy; ' . date('Y') . ' مركز قيمة وقدوة للتدريب')); ?></p>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>
