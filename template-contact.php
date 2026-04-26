<?php
/**
 * Template Name: اتصل بنا
 * Description: صفحة اتصل بنا مع نموذج تواصل وأسئلة شائعة
 */
get_header();
get_template_part('template-parts/page-banner');
$address = get_theme_mod('qimah_address', 'المملكة العربية السعودية');
$phone = get_theme_mod('qimah_contact_phone', '+966 00 000 0000');
$email = get_theme_mod('qimah_contact_email', 'info@goodwaty.org.sa');
$hours = get_theme_mod('qimah_working_hours', 'الأحد - الخميس | 8:00 ص - 5:00 م');
?>

<!-- Contact Info Cards -->
<section class="contact-info-section">
    <div class="container">
        <div class="contact-info-grid">
            <div class="contact-info-card" data-aos="fade-up" data-aos-delay="100">
                <div class="contact-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                <h3>العنوان</h3>
                <p><?php echo esc_html($address); ?></p>
            </div>
            <div class="contact-info-card" data-aos="fade-up" data-aos-delay="200">
                <div class="contact-info-icon"><i class="fas fa-envelope"></i></div>
                <h3>البريد الإلكتروني</h3>
                <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
            </div>
            <div class="contact-info-card" data-aos="fade-up" data-aos-delay="300">
                <div class="contact-info-icon"><i class="fas fa-phone-alt"></i></div>
                <h3>الهاتف</h3>
                <a href="tel:<?php echo esc_attr($phone); ?>" dir="ltr"><?php echo esc_html($phone); ?></a>
            </div>
            <div class="contact-info-card" data-aos="fade-up" data-aos-delay="400">
                <div class="contact-info-icon"><i class="fas fa-clock"></i></div>
                <h3>ساعات العمل</h3>
                <p><?php echo esc_html($hours); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form & Sidebar -->
<section class="contact-section">
    <div class="container">
        <div class="contact-grid">
            <!-- Form -->
            <div class="contact-form-card" data-aos="fade-right">
                <h2 class="contact-form-heading"><i class="fas fa-paper-plane" style="color:var(--primary);margin-left:10px;"></i> أرسل لنا رسالة</h2>
                <p class="contact-form-subtitle">نسعد بتواصلك معنا، املأ النموذج أدناه وسنرد عليك في أقرب وقت</p>
                <?php echo do_shortcode('[contact-form-7 id="contact-form" title="نموذج الاتصال"]'); ?>
                <?php if (!function_exists('wpcf7')) : ?>
                <form id="contactForm" method="post" action="">
                    <?php wp_nonce_field('qimah_contact', 'qimah_contact_nonce'); ?>
                    <input type="hidden" name="action" value="qimah_contact">
                    <div class="form-row">
                        <div class="form-group"><label>الاسم الكامل <i class="fas fa-user input-icon"></i></label>
                            <div class="input-wrapper"><input type="text" name="name" placeholder="أدخل اسمك الكامل" required></div></div>
                        <div class="form-group"><label>البريد الإلكتروني <i class="fas fa-envelope input-icon"></i></label>
                            <div class="input-wrapper"><input type="email" name="email" placeholder="example@email.com" dir="ltr" required></div></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group"><label>رقم الجوال <i class="fas fa-phone input-icon"></i></label>
                            <div class="input-wrapper"><input type="tel" name="phone" placeholder="+966 5X XXX XXXX" dir="ltr"></div></div>
                        <div class="form-group"><label>الموضوع <i class="fas fa-tag input-icon"></i></label>
                            <div class="input-wrapper"><select name="subject" required>
                                <option value="" disabled selected>اختر الموضوع</option>
                                <option value="general">استفسار عام</option>
                                <option value="technical">مشكلة تقنية</option>
                                <option value="suggestion">اقتراح</option>
                                <option value="partnership">طلب شراكة</option>
                            </select></div></div>
                    </div>
                    <div class="form-group"><label>الرسالة <i class="fas fa-comment-dots input-icon"></i></label>
                        <div class="input-wrapper"><textarea name="message" placeholder="اكتب رسالتك هنا..." rows="5" required></textarea></div></div>
                    <button type="submit" class="btn-submit"><span><i class="fas fa-paper-plane"></i> إرسال الرسالة</span></button>
                </form>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="contact-sidebar" data-aos="fade-left">
                <div class="map-placeholder"><i class="fas fa-map-marked-alt"></i><span>موقعنا على الخريطة</span></div>
                <div class="quick-info-box">
                    <h3><i class="fas fa-info-circle"></i> معلومات التواصل</h3>
                    <div class="quick-info-list">
                        <div class="quick-info-item"><div class="qi-icon"><i class="fas fa-envelope"></i></div><div><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a><small>البريد الإلكتروني الرسمي</small></div></div>
                        <div class="quick-info-item"><div class="qi-icon"><i class="fas fa-phone-alt"></i></div><div><a href="tel:<?php echo esc_attr($phone); ?>" dir="ltr"><?php echo esc_html($phone); ?></a><small>متاح خلال ساعات العمل</small></div></div>
                        <div class="quick-info-item"><div class="qi-icon"><i class="fas fa-clock"></i></div><div><span><?php echo esc_html($hours); ?></span><small>أيام العمل الرسمية</small></div></div>
                    </div>
                    <div class="contact-social">
                        <span class="contact-social-label">تابعنا على</span>
                        <?php foreach (array('twitter', 'linkedin', 'youtube', 'instagram') as $s) :
                            $url = get_theme_mod("qimah_{$s}", ''); if ($url) : ?>
                            <a href="<?php echo esc_url($url); ?>" class="social-btn <?php echo $s; ?>" target="_blank"><i class="fab fa-<?php echo $s === 'twitter' ? 'x-twitter' : $s; ?>"></i></a>
                        <?php endif; endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section" id="faq">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-badge center"><i class="fas fa-question-circle"></i><span>مساعدة</span></div>
            <h2 class="section-title center">الأسئلة الشائعة</h2>
            <p class="section-desc center">إليك إجابات على أكثر الأسئلة شيوعاً التي يطرحها متدربونا</p>
        </div>
        <div class="faq-grid">
            <?php
            $faqs = array(
                'كيف يمكنني التسجيل في دورة تدريبية؟' => 'يمكنك التسجيل بسهولة من خلال تصفح الدورات المتاحة واختيار الدورة المناسبة لك، ثم النقر على زر "سجّل الآن" واتبع خطوات التسجيل.',
                'ما هي طرق الدفع المتاحة؟' => 'نوفر عدة طرق للدفع تشمل: بطاقات الائتمان، التحويل البنكي، Apple Pay و STC Pay. كما نوفر إمكانية الدفع بالتقسيط.',
                'هل يمكنني الوصول للمحتوى بعد انتهاء الدورة؟' => 'نعم، يمكنك الوصول للمحتوى بشكل دائم بعد التسجيل. ستظل المواد متاحة لك في حسابك.',
                'هل توجد شهادات عند إتمام الدورة؟' => 'نعم، يتم إصدار شهادات معتمدة من مركز قيمة وقدوة عند إتمام المتطلبات بنجاح.',
                'كيف أتواصل مع الدعم الفني؟' => 'يمكنك التواصل معنا عبر البريد الإلكتروني أو الهاتف خلال ساعات العمل الرسمية أو من خلال نموذج الاتصال.',
            );
            foreach ($faqs as $q => $a) :
            ?>
            <div class="faq-item" data-aos="fade-up">
                <button class="faq-question" aria-expanded="false"><span><?php echo esc_html($q); ?></span><span class="faq-icon"><i class="fas fa-chevron-down"></i></span></button>
                <div class="faq-answer"><div class="faq-answer-inner"><p><?php echo esc_html($a); ?></p></div></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>
