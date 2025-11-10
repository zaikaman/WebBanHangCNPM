// Product Reviews JavaScript Handler

document.addEventListener('DOMContentLoaded', function() {
    const productId = window.productId;
    
    if (!productId) {
        console.error('Product ID not found');
        return;
    }
    
    let currentPage = 1;
    let selectedRating = 0;
    
    // Initialize
    loadReviews(currentPage);
    initStarRating();
    initReviewForm();
    
    // Star Rating Selection
    function initStarRating() {
        const starContainer = document.getElementById('star-rating');
        if (!starContainer) return;
        
        const stars = starContainer.querySelectorAll('i');
        
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
        const stars = document.querySelectorAll('#star-rating i');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('far');
                star.classList.add('fas', 'hovered');
            } else {
                star.classList.remove('fas', 'hovered');
                star.classList.add('far');
            }
        });
    }
    
    function selectStars(rating) {
        const stars = document.querySelectorAll('#star-rating i');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('far', 'hovered');
                star.classList.add('fas', 'selected');
            } else {
                star.classList.remove('fas', 'hovered', 'selected');
                star.classList.add('far');
            }
        });
    }
    
    function resetStars() {
        const stars = document.querySelectorAll('#star-rating i');
        stars.forEach(star => {
            star.classList.remove('fas', 'hovered', 'selected');
            star.classList.add('far');
        });
    }
    
    // Review Form Submission
    function initReviewForm() {
        const form = document.getElementById('review-form');
        if (!form) return;
        
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const messageDiv = document.getElementById('review-message');
            
            if (selectedRating === 0) {
                showMessage('Vui lòng chọn số sao đánh giá', 'error');
                return;
            }
            
            const formData = new FormData(form);
            formData.append('action', 'add_review');
            
            try {
                const response = await fetch('/WebBanHangCNPM/api/reviews.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
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
    
    // Load Reviews
    async function loadReviews(page = 1) {
        try {
            const response = await fetch(`/WebBanHangCNPM/api/reviews.php?action=get_reviews&id_sp=${productId}&page=${page}`);
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
                    <i class="far fa-comment-dots"></i>
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
            starsHtml += '<i class="fas fa-star"></i>';
        }
        
        if (hasHalfStar) {
            starsHtml += '<i class="fas fa-star-half-alt"></i>';
        }
        
        const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
        for (let i = 0; i < emptyStars; i++) {
            starsHtml += '<i class="far fa-star"></i>';
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
        // Scroll to reviews section
        document.querySelector('.product-reviews-section').scrollIntoView({ 
            behavior: 'smooth',
            block: 'start'
        });
    };
    
    // Utility function to escape HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
});
