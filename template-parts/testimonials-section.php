<?php
/**
 * Testimonials Section
 */
?>
<section class="testimonials" id="testimonials">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-badge center"><i class="fas fa-quote-right"></i><span>آراء المتدربين</span></div>
            <h2 class="section-title center">ماذا يقول متدربونا عنا</h2>
            <p class="section-desc center">تجارب حقيقية من متدربين استفادوا من برامجنا التدريبية</p>
        </div>
        <div class="swiper testimonials-swiper" data-aos="fade-up">
            <div class="swiper-wrapper">
                <?php
                $testimonials = array(
                    array('name' => 'أحمد محمد العتيبي', 'role' => 'متدرب - دورة بناء الأسرة', 'text' => 'تجربة رائعة مع مركز قيمة وقدوة! الدورات كانت شاملة ومنظمة بشكل ممتاز، والمدربون على مستوى عالي جداً من الاحترافية. أنصح الجميع بالتسجيل.'),
                    array('name' => 'سارة عبدالله القحطاني', 'role' => 'متدربة - دورة إدارة المشاريع', 'text' => 'الدورة غيرت نظرتي تماماً لإدارة المشاريع. المحتوى عملي والتطبيقات واقعية. شكراً لكم على هذه التجربة التعليمية القيمة.'),
                    array('name' => 'خالد بن سالم الدوسري', 'role' => 'متدرب - دورة التخطيط الاستراتيجي', 'text' => 'من أفضل الدورات التي حضرتها. المحتوى غني والمدرب متمكن. أوصي بها كل من يريد تطوير مهاراته القيادية.'),
                    array('name' => 'نورة بنت عبدالعزيز', 'role' => 'متدربة - دورة الذكاء العاطفي', 'text' => 'دورة ممتازة عملت على تغيير طريقة تفاعلي مع الآخرين. المحتوى التطبيقي ساعدني كثيراً في حياتي اليومية.'),
                    array('name' => 'محمد بن فهد الشهري', 'role' => 'متدرب - دورة التسويق الرقمي', 'text' => 'محتوى شامل ومحدّث يعكس آخر الاتجاهات في التسويق الرقمي. المدرب كان متعاوناً ومتعاوناً مع جميع الاستفسارات.'),
                    array('name' => 'فاطمة أحمد الحربي', 'role' => 'متدربة - دورة مهارات التواصل', 'text' => 'كنت أعاني من ضعف في التواصل ولكن الدورة ساعدتني بشكل كبير على تحسين مهاراتي في بيئة العمل والمجتمع.'),
                );
                foreach ($testimonials as $t) :
                ?>
                <div class="swiper-slide">
                    <div class="testimonial-card">
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text"><?php echo esc_html($t['text']); ?></p>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar"><i class="fas fa-user"></i></div>
                            <div class="testimonial-info">
                                <h4><?php echo esc_html($t['name']); ?></h4>
                                <span><?php echo esc_html($t['role']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
