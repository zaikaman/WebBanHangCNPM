// Pagination and Search Functionality
class PaginationManager {
    constructor(options = {}) {
        this.tableBodyId = options.tableBodyId || 'tableBody';
        this.paginationContainerId = options.paginationContainerId || 'paginationContainer';
        this.searchFormId = options.searchFormId || 'searchForm';
        this.ajaxUrl = options.ajaxUrl || '';
        this.searchTimeout = null;
        
        this.init();
    }
    
    init() {
        this.bindSearchEvents();
        this.bindPaginationEvents();
        this.bindPageSizeChange();
    }
    
    bindSearchEvents() {
        const searchForm = document.getElementById(this.searchFormId);
        if (!searchForm) return;
        
        const inputs = searchForm.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('input', () => {
                clearTimeout(this.searchTimeout);
                this.searchTimeout = setTimeout(() => {
                    this.performSearch();
                }, 300);
            });
            
            input.addEventListener('change', () => {
                clearTimeout(this.searchTimeout);
                this.searchTimeout = setTimeout(() => {
                    this.performSearch();
                }, 100);
            });
        });
    }
    
    bindPaginationEvents() {
        document.addEventListener('click', (e) => {
            const paginationContainer = document.getElementById(this.paginationContainerId);
            if (!paginationContainer) return;
            
            if (paginationContainer.contains(e.target) && e.target.tagName === 'A') {
                e.preventDefault();
                const url = e.target.getAttribute('href');
                if (url) {
                    this.loadPage(url);
                }
            }
        });
    }
    
    bindPageSizeChange() {
        window.changePageSize = (size) => {
            const url = new URL(window.location);
            url.searchParams.set('per_page', size);
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        };
    }
    
    performSearch() {
        if (!this.ajaxUrl) {
            // If no AJAX URL provided, submit form normally
            document.getElementById(this.searchFormId).submit();
            return;
        }
        
        const formData = new FormData(document.getElementById(this.searchFormId));
        const params = new URLSearchParams(formData);
        params.set('ajax_search', '1');
        
        this.showLoading();
        
        fetch(`${this.ajaxUrl}?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                this.updateTable(data.table_content);
                this.updatePagination(data.pagination);
                this.hideLoading();
            })
            .catch(error => {
                console.error('Search error:', error);
                this.hideLoading();
            });
    }
    
    loadPage(url) {
        if (!this.ajaxUrl) {
            window.location.href = url;
            return;
        }
        
        const urlParams = new URLSearchParams(url.split('?')[1]);
        const formData = new FormData(document.getElementById(this.searchFormId));
        const params = new URLSearchParams(formData);
        
        // Add page parameter
        params.set('page', urlParams.get('page'));
        params.set('ajax_search', '1');
        
        this.showLoading();
        
        fetch(`${this.ajaxUrl}?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                this.updateTable(data.table_content);
                this.updatePagination(data.pagination);
                this.hideLoading();
            })
            .catch(error => {
                console.error('Pagination error:', error);
                this.hideLoading();
            });
    }
    
    updateTable(content) {
        const tableBody = document.getElementById(this.tableBodyId);
        if (tableBody) {
            tableBody.innerHTML = content;
        }
    }
    
    updatePagination(content) {
        const paginationContainer = document.getElementById(this.paginationContainerId);
        if (paginationContainer) {
            paginationContainer.innerHTML = content;
        }
    }
    
    showLoading() {
        const tableBody = document.getElementById(this.tableBodyId);
        if (tableBody) {
            tableBody.classList.add('loading');
        }
    }
    
    hideLoading() {
        const tableBody = document.getElementById(this.tableBodyId);
        if (tableBody) {
            tableBody.classList.remove('loading');
        }
    }
}

// Utility functions
function confirmDelete(message = 'Bạn có chắc chắn muốn xóa?') {
    return confirm(message);
}

function clearSearch() {
    const searchForm = document.getElementById('searchForm');
    if (searchForm) {
        const inputs = searchForm.querySelectorAll('input[type="text"], input[type="number"], select');
        inputs.forEach(input => {
            if (input.type === 'text' || input.type === 'number') {
                input.value = '';
            } else if (input.tagName === 'SELECT') {
                input.selectedIndex = 0;
            }
        });
        searchForm.submit();
    }
}

// Auto-initialize pagination manager when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on a page that needs pagination
    const searchForm = document.getElementById('searchForm');
    const tableBody = document.querySelector('[id$="TableBody"], #tableBody');
    
    if (searchForm && tableBody) {
        // Determine AJAX URL based on current page
        const currentUrl = window.location.pathname;
        let ajaxUrl = '';
        
        if (currentUrl.includes('quanLySanPham')) {
            ajaxUrl = 'modules/quanLySanPham/lietke.php';
        }
        // Add more AJAX URLs for other modules as needed
        
        new PaginationManager({
            tableBodyId: tableBody.id,
            ajaxUrl: ajaxUrl
        });
    }
});

// Export for manual initialization if needed
window.PaginationManager = PaginationManager;
