// Product Reviews JavaScript Handler

// Global flag to prevent multiple initializations
let reviewsInitialized = false;

// Function to initialize reviews
function initializeReviews() {
    // Prevent multiple initializations
    if (reviewsInitialized) {
        console.log('Reviews already initialized, skipping');
        return;
    }
    
    console.log('Initializing reviews...'); // Debug
    
    const productId = window.productId;
    
    if (!productId) {
        console.error('Product ID not found');
        return;
    }
    
    console.log('Product ID:', productId); // Debug
    
    let currentPage = 1;
    let selectedRating = 0;
    let reviewFormInitialized = false; // Track if form is already initialized
    
    // Mark as initialized IMMEDIATELY to prevent race conditions
    reviewsInitialized = true;
    
    // Initialize
    loadReviews(currentPage);
    checkReviewPermission(); // Kiểm tra quyền đánh giá
    initStarRating();
    
    // Use event delegation for submit button - add handler with once flag
    let isSubmitting = false; // Prevent double submission
    
    document.addEventListener('click', async function(e) {
        // Check if clicked element is the submit button
        if (e.target && e.target.id === 'submit-review-btn') {
            e.preventDefault();
            e.stopPropagation();
            
            // Prevent double submission
            if (isSubmitting) {
                console.log('Already submitting, please wait...');
                return;
            }
            
            console.log('Submit button clicked via delegation!!!'); // Debug log
            
            // Try multiple ways to find the form
            let form = document.getElementById('review-form');
            console.log('Form by ID:', form);
            
            if (!form) {
                form = document.querySelector('#review-form');
                console.log('Form by querySelector:', form);
            }
            
            if (!form) {
                form = e.target.closest('form');
                console.log('Form by closest:', form);
            }
            
            if (!form) {
                // Try to find form in the parent hierarchy
                form = e.target.parentElement.querySelector('form');
                console.log('Form by parentElement:', form);
            }
            
            const messageDiv = document.getElementById('review-message');
            
            if (!form) {
                console.error('Form not found when submitting');
                showMessage('Lỗi: Không tìm thấy form đánh giá', 'error');
                return;
            }
            
            console.log('Form found! Proceeding with submission');
            
            if (selectedRating === 0) {
                showMessage('Vui lòng chọn số sao đánh giá', 'error');
                return;
            }
            
            isSubmitting = true; // Set flag
            
            const formData = new FormData(form);
            formData.append('action', 'add_review');
            
            console.log('Sending review...'); // Debug log
            console.log('Rating:', selectedRating); // Debug log
            
            try {
                const response = await fetch('api/reviews.php', {
                    method: 'POST',
                    body: formData
                });
                
                console.log('Response received'); // Debug log
                
                const data = await response.json();
                
                console.log('Data:', data); // Debug log
                
                if (data.success) {
                    showMessage(data.message, 'success');
                    form.reset();
                    selectedRating = 0;
                    resetStars();
                    document.getElementById('rating-value').value = '';
                    
                    // Reload reviews
                    loadReviews(1);
                    
                    // Update rating summary
                    if (data.rating_summary) {
                        updateRatingSummary(data.rating_summary);
                    }
                } else {
                    showMessage(data.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('Có lỗi xảy ra, vui lòng thử lại', 'error');
            } finally {
                // Reset flag to allow future submissions
                isSubmitting = false;
                console.log('Submission complete, flag reset');
            }
        }
    });
    
    // Don't use initReviewForm anymore - using event delegation instead
    
    // Star Rating Selection
    function initStarRating() {
        const starContainer = document.getElementById('star-rating');
        if (!starContainer) return;
        
        const stars = starContainer.querySelectorAll('.star-icon');
        
        stars.forEach(star => {
            star.addEventListener('mouseenter', function() {
                const rating = this.getAttribute('data-rating');
                highlightStars(rating);
            });
            
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-rating');
                selectedRating = parseInt(rating);
                document.getElementById('rating-value').value = selectedRating;
                selectStars(rating);
            });
        });
        
        starContainer.addEventListener('mouseleave', function() {
            if (selectedRating > 0) {
                selectStars(selectedRating);
            } else {
                resetStars();
            }
        });
    }
    
    function highlightStars(rating) {
        const stars = document.querySelectorAll('#star-rating .star-icon');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('hovered');
                star.classList.add('hovered');
                star.textContent = '★';
            } else {
                star.classList.remove('hovered');
                star.textContent = '☆';
            }
        });
    }
    
    function selectStars(rating) {
        const stars = document.querySelectorAll('#star-rating .star-icon');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('hovered');
                star.classList.add('selected');
                star.textContent = '★';
            } else {
                star.classList.remove('hovered', 'selected');
                star.textContent = '☆';
            }
        });
    }
    
    function resetStars() {
        const stars = document.querySelectorAll('#star-rating .star-icon');
        stars.forEach(star => {
            star.classList.remove('hovered', 'selected');
            star.textContent = '☆';
        });
    }
    
    // Review Form Submission
    function initReviewForm() {
        // Prevent double initialization
        if (reviewFormInitialized) {
            console.log('Review form already initialized, skipping');
            return;
        }
        
        const form = document.getElementById('review-form');
        const submitBtn = document.getElementById('submit-review-btn');
        
        console.log('initReviewForm called'); // Debug
        console.log('Form found:', form); // Debug
        console.log('Submit button found:', submitBtn); // Debug
        
        if (!form) {
            console.error('Review form not found!');
            return;
        }
        
        if (!submitBtn) {
            console.error('Submit button not found!');
            return;
        }
        
        console.log('Review form initialized - adding event listener'); // Debug log
        reviewFormInitialized = true; // Mark as initialized
        
        // Handle button click instead of form submit
        submitBtn.addEventListener('click', async function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('Submit button clicked!!!'); // Debug log
            
            const messageDiv = document.getElementById('review-message');
            
            if (selectedRating === 0) {
                showMessage('Vui lòng chọn số sao đánh giá', 'error');
                return;
            }
            
            const formData = new FormData(form);
            formData.append('action', 'add_review');
            
            console.log('Sending review...'); // Debug log
            console.log('Rating:', selectedRating); // Debug log
            
            try {
                const response = await fetch('api/reviews.php', {
                    method: 'POST',
                    body: formData
                });
                
                console.log('Response received'); // Debug log
                
                const data = await response.json();
                
                console.log('Data:', data); // Debug log
                
                if (data.success) {
                    showMessage(data.message, 'success');
                    form.reset();
                    selectedRating = 0;
                    resetStars();
                    document.getElementById('rating-value').value = '';
                    
                    // Reload reviews
                    loadReviews(1);
                    
                    // Update rating summary
                    if (data.rating_summary) {
                        updateRatingSummary(data.rating_summary);
                    }
                } else {
                    showMessage(data.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('Có lỗi xảy ra, vui lòng thử lại', 'error');
            }
        });
        
        // Also prevent form submission
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            e.stopPropagation();
            return false;
        });
    }
    
    function showMessage(message, type) {
        const messageDiv = document.getElementById('review-message');
        if (!messageDiv) return;
        
        messageDiv.textContent = message;
        messageDiv.className = 'review-message ' + type;
        messageDiv.style.display = 'block';
        
        setTimeout(() => {
            messageDiv.style.display = 'none';
        }, 5000);
    }
    
    // Kiểm tra quyền đánh giá
    async function checkReviewPermission() {
        const reviewFormSection = document.querySelector('.review-form-section');
        if (!reviewFormSection) return; // Không có form (chưa đăng nhập)
        
        try {
            const response = await fetch(`api/reviews.php?action=check_review_permission&id_sp=${productId}`);
            const data = await response.json();
            
            if (data.success) {
                if (!data.can_review) {
                    // Ẩn form và hiển thị thông báo
                    reviewFormSection.innerHTML = `
                        <div class="review-permission-message">
                            <p><i class="fas fa-info-circle"></i> ${data.message}</p>
                        </div>
                    `;
                }
            }
        } catch (error) {
            console.error('Error checking review permission:', error);
        }
    }
    
    // Load Reviews
    async function loadReviews(page = 1) {
        try {
            const response = await fetch(`api/reviews.php?action=get_reviews&id_sp=${productId}&page=${page}`);
            const data = await response.json();
            
            if (data.success) {
                displayReviews(data.data.reviews);
                updateRatingSummary(data.data.rating_summary);
                updatePagination(data.data.pagination);
                currentPage = page;
            }
        } catch (error) {
            console.error('Error loading reviews:', error);
        }
    }
    
    // Display Reviews List
    function displayReviews(reviews) {
        const container = document.getElementById('reviews-list');
        if (!container) return;
        
        if (reviews.length === 0) {
            container.innerHTML = `
                <div class="no-reviews">
                    <p>Chưa có đánh giá nào. Hãy là người đầu tiên đánh giá sản phẩm này!</p>
                </div>
            `;
            return;
        }
        
        container.innerHTML = reviews.map(review => {
            const date = new Date(review.ngay_tao);
            const formattedDate = date.toLocaleDateString('vi-VN', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            
            const initials = review.ten_khachhang.charAt(0).toUpperCase();
            
            return `
                <div class="review-item">
                    <div class="review-header">
                        <div class="reviewer-info">
                            <div class="reviewer-avatar">${initials}</div>
                            <div>
                                <div class="reviewer-name">${escapeHtml(review.ten_khachhang)}</div>
                                <div class="review-rating">
                                    ${generateStars(review.rating)}
                                </div>
                            </div>
                        </div>
                        <div class="review-date">${formattedDate}</div>
                    </div>
                    ${review.noi_dung ? `<div class="review-content">${escapeHtml(review.noi_dung)}</div>` : ''}
                </div>
            `;
        }).join('');
    }
    
    // Update Rating Summary
    function updateRatingSummary(summary) {
        // Update average rating
        const avgRatingEl = document.getElementById('avg-rating');
        if (avgRatingEl) {
            avgRatingEl.textContent = summary.avg_rating.toFixed(1);
        }
        
        // Update total reviews count
        const totalReviewsEl = document.getElementById('total-reviews');
        if (totalReviewsEl) {
            totalReviewsEl.textContent = `${summary.total_reviews} đánh giá`;
        }
        
        // Update stars display
        const starsDisplay = document.getElementById('stars-display');
        if (starsDisplay) {
            starsDisplay.innerHTML = generateStars(summary.avg_rating);
        }
        
        // Update rating bars
        const total = summary.total_reviews;
        for (let i = 1; i <= 5; i++) {
            const count = summary.star_distribution[i] || 0;
            const percentage = total > 0 ? (count / total * 100) : 0;
            
            const barEl = document.getElementById(`bar-${i}`);
            const countEl = document.getElementById(`count-${i}`);
            
            if (barEl) barEl.style.width = percentage + '%';
            if (countEl) countEl.textContent = count;
        }
    }
    
    // Generate Stars HTML
    function generateStars(rating) {
        let starsHtml = '';
        const fullStars = Math.floor(rating);
        const hasHalfStar = rating % 1 >= 0.5;
        
        for (let i = 0; i < fullStars; i++) {
            starsHtml += '<span class="star-icon">★</span>';
        }
        
        if (hasHalfStar) {
            starsHtml += '<span class="star-icon">⭐</span>';
        }
        
        const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
        for (let i = 0; i < emptyStars; i++) {
            starsHtml += '<span class="star-icon">☆</span>';
        }
        
        return starsHtml;
    }
    
    // Update Pagination
    function updatePagination(pagination) {
        const container = document.getElementById('reviews-pagination');
        if (!container || pagination.total_pages <= 1) {
            container.innerHTML = '';
            return;
        }
        
        let paginationHtml = '';
        
        // Previous button
        if (pagination.current_page > 1) {
            paginationHtml += `<button class="page-btn" onclick="loadReviewsPage(${pagination.current_page - 1})">
                <i class="fas fa-chevron-left"></i> Trước
            </button>`;
        }
        
        // Page numbers
        for (let i = 1; i <= pagination.total_pages; i++) {
            const activeClass = i === pagination.current_page ? 'active' : '';
            paginationHtml += `<button class="page-btn ${activeClass}" onclick="loadReviewsPage(${i})">${i}</button>`;
        }
        
        // Next button
        if (pagination.current_page < pagination.total_pages) {
            paginationHtml += `<button class="page-btn" onclick="loadReviewsPage(${pagination.current_page + 1})">
                Tiếp <i class="fas fa-chevron-right"></i>
            </button>`;
        }
        
        container.innerHTML = paginationHtml;
    }
    
    // Make loadReviews accessible globally for pagination
    window.loadReviewsPage = function(page) {
        loadReviews(page);
        // Scroll to reviews tab
        const reviewsTab = document.querySelector('#danhgia');
        if (reviewsTab) {
            reviewsTab.scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        }
    };
    
    // Utility function to escape HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeReviews);
} else {
    // DOM already loaded
    initializeReviews();
}

// Also try to initialize when tab is clicked
setTimeout(function() {
    console.log('Delayed initialization attempt');
    initializeReviews();
}, 1000);
