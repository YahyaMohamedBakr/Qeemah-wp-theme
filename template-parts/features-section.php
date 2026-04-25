<?php
$features = array(
    array('icon' => 'fa-user-tie', 'title' => 'مدربون نخبة', 'desc' => 'نخبة من المدربين المعتمدين ذوي الخبرة العملية والأكاديمية العالية في مختلف التخصصات والمجالات.'),
    array('icon' => 'fa-certificate', 'title' => 'شهادات معتمدة', 'desc' => 'شهادات تدريبية معتمدة ومعترف بها تساهم في تطوير مسيرتك المهنية وتعزيز فرصك في سوق العمل.'),
    array('icon' => 'fa-laptop-house', 'title' => 'تعلم عن بُعد', 'desc' => 'منصة تعليمية متكاملة تتيح لك التعلم من أي مكان وفي أي وقت مع توفير تجربة تفاعلية غنية ومميزة.'),
    array('icon' => 'fa-headset', 'title' => 'دعم فني متواصل', 'desc' => 'فريق دعم فني متخصص جاهز لمساعدتك على مدار الساعة لحل أي مشكلة أو استفسار قد يواجهك.'),
    array('icon' => 'fa-sync-alt', 'title' => 'محتوى محدث', 'desc' => 'نحرص على تحديث المحتوى التدريبي بشكل دوري لضمان مواكبة أحدث التطورات والممارسات المهنية.'),
    array('icon' => 'fa-wallet', 'title' => 'أسعار تنافسية', 'desc' => 'نقدم برامج تدريبية عالية الجودة بأسعار تنافسية تناسب مختلف الفئات مع إمكانية الدفع بالتقسيط.'),
);
?>
<section class="features" id="features">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-badge center"><i class="fas fa-gem"></i><span>لماذا نحن</span></div>
            <h2 class="section-title center">ما يميزنا عن غيرنا</h2>
            <p class="section-desc center">نقدم تجربة تعليمية فريدة تجمع بين الجودة والابتكار والتميز في كل ما نقدمه</p>
        </div>
        <div class="features-grid">
            <?php foreach ($features as $i => $f) : ?>
                <div class="feature-card" data-aos="fade-up" data-aos-delay="<?php echo ($i + 1) * 100; ?>">
                    <div class="feature-icon"><i class="fas <?php echo esc_attr($f['icon']); ?>"></i></div>
                    <h3 class="feature-title"><?php echo esc_html($f['title']); ?></h3>
                    <p class="feature-desc"><?php echo esc_html($f['desc']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
