<!-- Newsletter Section - Premium -->
<section class="premium-newsletter">
    <div class="newsletter-container">
        <div class="newsletter-content">
            <h2 class="newsletter-title">Đăng Ký Nhận Tin</h2>
            <p class="newsletter-description">
                Nhận thông tin về sản phẩm mới, ưu đãi độc quyền và các bí quyết phong cách thể thao qua email
            </p>
        </div>
        <form class="newsletter-form-premium" id="newsletterForm">
            <div class="input-group">
                <input type="email" 
                       class="newsletter-input-premium" 
                       id="newsletterEmail"
                       name="email"
                       placeholder="Email của bạn"
                       required>
                <button type="submit" class="newsletter-btn-premium" id="newsletterBtn">
                    <span id="btnText">Đăng Ký</span>
                    <i class="fas fa-arrow-right" id="btnIcon"></i>
                    <i class="fas fa-spinner fa-spin" id="btnSpinner" style="display: none;"></i>
                </button>
            </div>
            <p class="newsletter-message" id="newsletterMessage" style="display: none; margin-top: 15px; text-align: center; font-size: 14px;"></p>
        </form>
    </div>
</section>

<script>
document.getElementById('newsletterForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const email = document.getElementById('newsletterEmail').value.trim();
    const btn = document.getElementById('newsletterBtn');
    const btnText = document.getElementById('btnText');
    const btnIcon = document.getElementById('btnIcon');
    const btnSpinner = document.getElementById('btnSpinner');
    const message = document.getElementById('newsletterMessage');
    
    if (!email) {
        showMessage('Vui lòng nhập email của bạn', false);
        return;
    }
    
    // Disable button và show loading
    btn.disabled = true;
    btnText.textContent = 'Đang gửi...';
    btnIcon.style.display = 'none';
    btnSpinner.style.display = 'inline-block';
    
    try {
        const response = await fetch('api/newsletter.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ email: email })
        });
        
        const data = await response.json();
        
        if (data.success) {
            showMessage('🎉 ' + data.message, true);
            document.getElementById('newsletterEmail').value = '';
        } else {
            showMessage('❌ ' + data.message, false);
        }
    } catch (error) {
        showMessage('❌ Có lỗi xảy ra, vui lòng thử lại sau', false);
        console.error('Newsletter error:', error);
    } finally {
        // Reset button
        btn.disabled = false;
        btnText.textContent = 'Đăng Ký';
        btnIcon.style.display = 'inline-block';
        btnSpinner.style.display = 'none';
    }
    
    function showMessage(text, isSuccess) {
        message.style.display = 'block';
        message.textContent = text;
        message.style.color = isSuccess ? '#4CAF50' : '#ff4444';
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            message.style.display = 'none';
        }, 5000);
    }
});
</script>
