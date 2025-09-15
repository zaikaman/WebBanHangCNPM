// Reset form về giá trị ban đầu
function resetForm() {
    document.getElementById('profileForm').reset();
    // Reset border colors
    const inputs = document.querySelectorAll('.form-field input');
    inputs.forEach(input => {
        input.style.borderColor = '#e9ecef';
        input.setCustomValidity('');
    });
}

// Validation cho email và số điện thoại
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('dien_thoai');
    
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            const email = this.value;
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            
            if (email && !emailPattern.test(email)) {
                this.style.borderColor = '#dc3545';
                this.setCustomValidity('Email không đúng định dạng');
            } else {
                this.style.borderColor = '#28a745';
                this.setCustomValidity('');
            }
        });
    }
    
    if (phoneInput) {
        phoneInput.addEventListener('blur', function() {
            const phone = this.value;
            const phonePattern = /^[0-9]{10,11}$/;
            
            if (phone && !phonePattern.test(phone)) {
                this.style.borderColor = '#dc3545';
                this.setCustomValidity('Số điện thoại phải có 10-11 chữ số');
            } else {
                this.style.borderColor = '#28a745';
                this.setCustomValidity('');
            }
        });
    }
    
    // Form validation trước khi submit
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            const inputs = this.querySelectorAll('input[required]');
            let isValid = true;
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.style.borderColor = '#dc3545';
                    isValid = false;
                } else {
                    input.style.borderColor = '#28a745';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Vui lòng điền đầy đủ thông tin bắt buộc!');
            }
        });
    }
});
