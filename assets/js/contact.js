document.addEventListener('DOMContentLoaded', function(){
    // FAQ Accordion
    document.querySelectorAll('.faq-question').forEach(function(btn){
        btn.addEventListener('click', function(){
            const item = this.closest('.faq-item');
            const answer = item.querySelector('.faq-answer');
            const isOpen = item.classList.contains('active');
            // Close all
            document.querySelectorAll('.faq-item').forEach(function(i){ i.classList.remove('active'); });
            // Open clicked if was closed
            if (!isOpen) {
                item.classList.add('active');
                answer.classList.add('open');
            }
            this.setAttribute('aria-expanded', !isOpen);
        });
    });

    // Contact form handling (if no CF7)
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e){
            e.preventDefault();
            const btn = this.querySelector('.btn-submit span');
            const originalText = btn.textContent;
            btn.textContent = 'جاري الإرسال...';
            setTimeout(function(){ btn.textContent = 'تم الإرسال بنجاح!'; setTimeout(function(){ btn.textContent = originalText; }, 3000); }, 1500);
        });
    }

    // File attachment
    const fileBtn = document.getElementById('fileAttachBtn');
    const fileInput = document.getElementById('fileInput');
    const fileName = document.getElementById('fileName');
    if (fileBtn && fileInput) {
        fileBtn.addEventListener('click', function(){ fileInput.click(); });
        fileInput.addEventListener('change', function(){
            if (this.files.length > 0) {
                fileName.textContent = this.files[0].name;
                fileBtn.classList.add('has-file');
            }
        });
    }
});
