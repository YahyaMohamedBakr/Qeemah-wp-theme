<?php
/**
 * Template Name: تسجيل الدخول / حساب جديد
 * Description: صفحة تسجيل الدخول وإنشاء حساب جديد بتصميم متوافق مع التمبلت
 */
if (is_user_logged_in()) {
    wp_redirect(home_url('/dashboard'));
    exit;
}

// Handle errors
$login_error = '';
$register_error = '';
$register_success = false;

// Handle Login
if (isset($_POST['qimah_login_nonce']) && wp_verify_nonce($_POST['qimah_login_nonce'], 'qimah_login_action')) {
    $creds = array(
        'user_login'    => sanitize_text_field($_POST['log']),
        'user_password' => $_POST['pwd'],
        'remember'      => isset($_POST['rememberme']),
    );
    $user = wp_signon($creds, false);
    if (is_wp_error($user)) {
        $login_error = $user->get_error_message();
    } else {
        $redirect = isset($_POST['redirect_to']) ? esc_url($_POST['redirect_to']) : home_url('/dashboard');
        wp_safe_redirect($redirect);
        exit;
    }
}

// Handle Registration
if (isset($_POST['qimah_register_nonce']) && wp_verify_nonce($_POST['qimah_register_nonce'], 'qimah_register_action')) {
    $username   = sanitize_text_field($_POST['user_login']);
    $email      = sanitize_email($_POST['user_email']);
    $password   = $_POST['user_pass'];
    $phone      = sanitize_text_field($_POST['user_phone'] ?? '');

    if (empty($username) || empty($email) || empty($password)) {
        $register_error = 'يرجى ملء جميع الحقول المطلوبة.';
    } elseif (strlen($password) < 8) {
        $register_error = 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.';
    } elseif (email_exists($email)) {
        $register_error = 'البريد الإلكتروني مسجل بالفعل.';
    } elseif (username_exists($username)) {
        $register_error = 'اسم المستخدم مسجل بالفعل.';
    } else {
        $user_id = wp_insert_user(array(
            'user_login' => $username,
            'user_email' => $email,
            'user_pass'  => $password,
            'first_name' => $username,
            'role'       => 'subscriber',
        ));
        if (!is_wp_error($user_id)) {
            // Save phone number
            if ($phone) {
                update_user_meta($user_id, 'billing_phone', $phone);
                update_user_meta($user_id, 'user_phone', $phone);
            }
            // Auto login
            wp_set_auth_cookie($user_id);
            wp_safe_redirect(home_url('/dashboard'));
            exit;
        } else {
            $register_error = $user_id->get_error_message();
        }
    }
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class('auth-page'); ?>>
<?php wp_body_open(); ?>

    <!-- Auth Top Bar -->
    <header class="auth-topbar">
        <div class="auth-topbar-inner">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <img src="<?php echo esc_url(QIMAH_URI . '/assets/images/logo.png'); ?>" alt="<?php bloginfo('name'); ?>">
                <?php endif; ?>
            </a>
            <div class="auth-topbar-actions">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="auth-topbar-link">
                    <i class="fas fa-arrow-right"></i>
                    <span>العودة للرئيسية</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Auth Main -->
    <main class="auth-main">

        <!-- Visual Side (Right in RTL) -->
        <div class="auth-visual" data-aos="fade-right">
            <!-- Background Shapes -->
            <div class="auth-visual-shapes">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <div class="shape shape-3"></div>
                <div class="shape shape-4"></div>
                <div class="shape shape-5"></div>
            </div>

            <!-- Decorative Dashed Circles -->
            <div class="auth-circle-deco auth-circle-deco-1"></div>
            <div class="auth-circle-deco auth-circle-deco-2"></div>

            <!-- Content -->
            <div class="auth-visual-content">
                <div class="auth-visual-logo">
                    <?php if (has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <img src="<?php echo esc_url(QIMAH_URI . '/assets/images/logo.png'); ?>" alt="قيمة وقدوة">
                    <?php endif; ?>
                </div>

                <h1 class="auth-visual-title" data-aos="fade-up" data-aos-delay="200">
                    مرحباً بك في
                    <span>مركز قيمة وقدوة</span>
                </h1>

                <p class="auth-visual-desc" data-aos="fade-up" data-aos-delay="300">
                    انضم إلى مجتمعنا التعليمي وابدأ رحلتك نحو التميز والتمكين
                </p>

                <!-- Floating Cards -->
                <div class="auth-floating-cards" data-aos="fade-up" data-aos-delay="400">
                    <div class="auth-floating-card">
                        <i class="fas fa-certificate"></i>
                        <span>شهادات معتمدة</span>
                    </div>
                    <div class="auth-floating-card">
                        <i class="fas fa-laptop-code"></i>
                        <span>تعلم عن بعد</span>
                    </div>
                    <div class="auth-floating-card">
                        <i class="fas fa-headset"></i>
                        <span>دعم فني متواصل</span>
                    </div>
                </div>

                <!-- Stats Badges -->
                <div class="auth-visual-stats" data-aos="fade-up" data-aos-delay="500">
                    <div class="auth-visual-stat">
                        <i class="fas fa-users"></i>
                        <span>5,000+ متدرب</span>
                    </div>
                    <div class="auth-visual-stat">
                        <i class="fas fa-book-open"></i>
                        <span>150+ دورة</span>
                    </div>
                    <div class="auth-visual-stat">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>50+ مدرب</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Side (Left in RTL) -->
        <div class="auth-form-side" data-aos="fade-left">
            <div class="auth-form-wrapper">
                <!-- Tab Switcher -->
                <div class="auth-tabs" id="authTabs">
                    <div class="auth-tab-slider" id="authTabSlider"></div>
                    <button class="auth-tab active" data-tab="login" id="tabLogin">تسجيل الدخول</button>
                    <button class="auth-tab" data-tab="register" id="tabRegister">حساب جديد</button>
                </div>

                <!-- ============ LOGIN FORM ============ -->
                <div class="auth-form-panel active" id="loginPanel">
                    <div class="auth-form-header">
                        <h2>تسجيل الدخول</h2>
                        <p>أدخل بياناتك للوصول إلى حسابك والدورات التدريبية</p>
                    </div>

                    <?php if ($login_error) : ?>
                    <div class="auth-notice auth-notice-error">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span><?php echo esc_html($login_error); ?></span>
                    </div>
                    <?php endif; ?>

                    <form id="loginForm" method="post" action="">
                        <?php wp_nonce_field('qimah_login_action', 'qimah_login_nonce'); ?>
                        <?php if (isset($_GET['redirect_to'])) : ?>
                            <input type="hidden" name="redirect_to" value="<?php echo esc_url($_GET['redirect_to']); ?>">
                        <?php endif; ?>

                        <!-- Email/Username -->
                        <div class="auth-field">
                            <label class="auth-field-label" for="loginEmail">البريد الإلكتروني أو اسم المستخدم</label>
                            <div class="auth-field-input-wrap">
                                <i class="fas fa-envelope auth-field-icon"></i>
                                <input type="text" name="log" id="loginEmail" class="auth-field-input" placeholder="أدخل بريدك الإلكتروني" autocomplete="email" required>
                                <span class="auth-field-success-icon"><i class="fas fa-check-circle"></i></span>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="auth-field">
                            <label class="auth-field-label" for="loginPassword">كلمة المرور</label>
                            <div class="auth-field-input-wrap">
                                <i class="fas fa-lock auth-field-icon"></i>
                                <input type="password" name="pwd" id="loginPassword" class="auth-field-input" placeholder="أدخل كلمة المرور" autocomplete="current-password" required>
                                <button type="button" class="auth-password-toggle" data-target="loginPassword" aria-label="إظهار كلمة المرور">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember / Forgot -->
                        <div class="auth-options-row">
                            <label class="auth-checkbox-wrap">
                                <input type="checkbox" name="rememberme" id="rememberMe">
                                <span class="auth-checkbox-custom"><i class="fas fa-check"></i></span>
                                <span class="auth-checkbox-label">تذكرني</span>
                            </label>
                            <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="auth-forgot-link">نسيت كلمة المرور؟</a>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="auth-submit-btn">
                            <span class="btn-text">تسجيل الدخول</span>
                            <i class="fas fa-arrow-left"></i>
                            <div class="btn-spinner"></div>
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="auth-divider">
                        <span>أو</span>
                    </div>

                    <!-- Social Login -->
                    <?php do_action('login_form'); ?>

                    <!-- Guest -->
                    <p class="auth-guest-link">
                        <a href="<?php echo esc_url(home_url('/')); ?>">تصفح الدورات كزائر</a>
                    </p>
                </div>

                <!-- ============ REGISTER FORM ============ -->
                <div class="auth-form-panel" id="registerPanel">
                    <div class="auth-form-header">
                        <h2>إنشاء حساب جديد</h2>
                        <p>سجّل الآن وابدأ رحلتك التعليمية مع أفضل المدربين</p>
                    </div>

                    <?php if ($register_error) : ?>
                    <div class="auth-notice auth-notice-error">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span><?php echo esc_html($register_error); ?></span>
                    </div>
                    <?php endif; ?>

                    <form id="registerForm" method="post" action="">
                        <?php wp_nonce_field('qimah_register_action', 'qimah_register_nonce'); ?>

                        <!-- Full Name -->
                        <div class="auth-field">
                            <label class="auth-field-label" for="regName">الاسم الكامل</label>
                            <div class="auth-field-input-wrap">
                                <i class="fas fa-user auth-field-icon"></i>
                                <input type="text" name="user_login" id="regName" class="auth-field-input" placeholder="أدخل اسمك الكامل" autocomplete="name" required>
                                <span class="auth-field-success-icon"><i class="fas fa-check-circle"></i></span>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="auth-field">
                            <label class="auth-field-label" for="regEmail">البريد الإلكتروني</label>
                            <div class="auth-field-input-wrap">
                                <i class="fas fa-envelope auth-field-icon"></i>
                                <input type="email" name="user_email" id="regEmail" class="auth-field-input" placeholder="أدخل بريدك الإلكتروني" autocomplete="email" required>
                                <span class="auth-field-success-icon"><i class="fas fa-check-circle"></i></span>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="auth-field">
                            <label class="auth-field-label" for="regPhone">رقم الجوال</label>
                            <div class="auth-field-input-wrap">
                                <i class="fas fa-phone auth-field-icon"></i>
                                <input type="tel" name="user_phone" id="regPhone" class="auth-field-input" placeholder="05xxxxxxxx" autocomplete="tel">
                                <span class="auth-field-success-icon"><i class="fas fa-check-circle"></i></span>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="auth-field">
                            <label class="auth-field-label" for="regPassword">كلمة المرور</label>
                            <div class="auth-field-input-wrap">
                                <i class="fas fa-lock auth-field-icon"></i>
                                <input type="password" name="user_pass" id="regPassword" class="auth-field-input" placeholder="أنشئ كلمة مرور قوية" autocomplete="new-password" required>
                                <button type="button" class="auth-password-toggle" data-target="regPassword" aria-label="إظهار كلمة المرور">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <!-- Password Strength -->
                            <div class="auth-password-strength" id="passwordStrength">
                                <div class="auth-strength-bars">
                                    <div class="auth-strength-bar" id="strengthBar1"></div>
                                    <div class="auth-strength-bar" id="strengthBar2"></div>
                                    <div class="auth-strength-bar" id="strengthBar3"></div>
                                    <div class="auth-strength-bar" id="strengthBar4"></div>
                                </div>
                                <span class="auth-strength-text" id="strengthText"></span>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="auth-field">
                            <label class="auth-field-label" for="regConfirmPassword">تأكيد كلمة المرور</label>
                            <div class="auth-field-input-wrap">
                                <i class="fas fa-lock auth-field-icon"></i>
                                <input type="password" name="user_pass_confirm" id="regConfirmPassword" class="auth-field-input" placeholder="أعد إدخال كلمة المرور" autocomplete="new-password" required>
                                <button type="button" class="auth-password-toggle" data-target="regConfirmPassword" aria-label="إظهار كلمة المرور">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="auth-field-error" id="confirmPasswordError">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>كلمتا المرور غير متطابقتين</span>
                            </div>
                        </div>

                        <!-- Terms Checkbox -->
                        <div class="auth-terms">
                            <label class="auth-checkbox-wrap">
                                <input type="checkbox" name="terms" id="termsCheck" required>
                                <span class="auth-checkbox-custom"><i class="fas fa-check"></i></span>
                                <span class="auth-checkbox-label">أوافق على <a href="#" target="_blank">شروط الاستخدام</a> و<a href="#" target="_blank">سياسة الخصوصية</a></span>
                            </label>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="auth-submit-btn">
                            <span class="btn-text">إنشاء حساب</span>
                            <i class="fas fa-arrow-left"></i>
                            <div class="btn-spinner"></div>
                        </button>
                    </form>

                    <!-- Login prompt -->
                    <p class="auth-login-prompt">
                        لديك حساب بالفعل؟ <a href="#" onclick="document.getElementById('tabLogin').click(); return false;">سجّل دخولك</a>
                    </p>
                </div>
            </div>
        </div>
    </main>

    <!-- Auth Footer -->
    <footer class="auth-footer">
        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. جميع الحقوق محفوظة.</p>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab switching
        const tabs = document.querySelectorAll('.auth-tab');
        const slider = document.getElementById('authTabSlider');
        const panels = document.querySelectorAll('.auth-form-panel');

        tabs.forEach(function(tab) {
            tab.addEventListener('click', function() {
                const target = this.dataset.tab;
                tabs.forEach(function(t) { t.classList.remove('active'); });
                this.classList.add('active');
                panels.forEach(function(p) { p.classList.remove('active'); });
                document.getElementById(target + 'Panel').classList.add('active');
                if (target === 'register') {
                    slider.classList.add('register');
                } else {
                    slider.classList.remove('register');
                }
            });
        });

        // Password toggle
        document.querySelectorAll('.auth-password-toggle').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const target = document.getElementById(this.dataset.target);
                if (target.type === 'password') {
                    target.type = 'text';
                    this.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    target.type = 'password';
                    this.innerHTML = '<i class="fas fa-eye"></i>';
                }
            });
        });

        // Password strength meter
        const passwordInput = document.getElementById('regPassword');
        const strengthContainer = document.getElementById('passwordStrength');
        const bars = [
            document.getElementById('strengthBar1'),
            document.getElementById('strengthBar2'),
            document.getElementById('strengthBar3'),
            document.getElementById('strengthBar4')
        ];
        const strengthText = document.getElementById('strengthText');

        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                const val = this.value;
                strengthContainer.classList.toggle('visible', val.length > 0);

                let score = 0;
                if (val.length >= 8) score++;
                if (/[a-z]/.test(val) && /[A-Z]/.test(val)) score++;
                if (/[0-9]/.test(val)) score++;
                if (/[^a-zA-Z0-9]/.test(val)) score++;

                const levels = ['', 'weak', 'medium', 'medium', 'strong'];
                const labels = ['', 'ضعيفة', 'متوسطة', 'جيدة', 'قوية'];

                bars.forEach(function(bar, i) {
                    bar.classList.remove('active', 'weak', 'medium', 'strong');
                    if (i < score) {
                        bar.classList.add('active', levels[score]);
                    }
                });

                strengthText.className = 'auth-strength-text ' + levels[score];
                strengthText.textContent = labels[score] || '';
            });
        }

        // Confirm password validation
        const confirmInput = document.getElementById('regConfirmPassword');
        const confirmError = document.getElementById('confirmPasswordError');
        if (confirmInput && passwordInput) {
            confirmInput.addEventListener('input', function() {
                if (this.value !== passwordInput.value && this.value.length > 0) {
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                    confirmError.classList.add('visible');
                } else if (this.value === passwordInput.value && this.value.length > 0) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                    confirmError.classList.remove('visible');
                } else {
                    this.classList.remove('is-invalid', 'is-valid');
                    confirmError.classList.remove('visible');
                }
            });
        }

        // Real-time validation for email
        const regEmail = document.getElementById('regEmail');
        if (regEmail) {
            regEmail.addEventListener('blur', function() {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (emailRegex.test(this.value)) {
                    this.classList.add('is-valid');
                    this.classList.remove('is-invalid');
                } else if (this.value.length > 0) {
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                }
            });
        }

        // AOS init
        if (typeof AOS !== 'undefined') {
            AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true });
        }
    });
    </script>

    <?php wp_footer(); ?>
</body>
</html>
