<?php
class Pagination {
    private $current_page;
    private $total_records;
    private $records_per_page;
    private $total_pages;
    private $query_params;
    
    public function __construct($current_page, $total_records, $records_per_page = 10, $query_params = []) {
        $this->current_page = max(1, (int) $current_page);
        $this->total_records = (int) $total_records;
        $this->records_per_page = (int) $records_per_page;
        $this->total_pages = ceil($this->total_records / $this->records_per_page);
        $this->query_params = $query_params;
    }
    
    public function getOffset() {
        return ($this->current_page - 1) * $this->records_per_page;
    }
    
    public function getLimit() {
        return $this->records_per_page;
    }
    
    public function getTotalPages() {
        return $this->total_pages;
    }
    
    public function getCurrentPage() {
        return $this->current_page;
    }
    
    public function getTotalRecords() {
        return $this->total_records;
    }
    
    private function buildQueryString($page) {
        $params = $this->query_params;
        $params['page'] = $page;
        
        // Make sure we maintain the current action and query parameters
        if (!isset($params['action'])) {
            $params['action'] = 'quanLySanPham';
        }
        if (!isset($params['query'])) {
            $params['query'] = 'lietke';
        }
        
        return 'index.php?' . http_build_query($params);
    }
    
    private function buildPaginationLink($page, $text, $is_active = false, $is_disabled = false) {
        if ($is_disabled) {
            return '<li class="page-item disabled"><span class="page-link">' . $text . '</span></li>';
        }
        
        if ($is_active) {
            return '<li class="page-item active"><span class="page-link">' . $text . '</span></li>';
        }
        
        $url = $this->buildQueryString($page);
        return '<li class="page-item"><a class="page-link" href="' . $url . '" data-page="' . $page . '">' . $text . '</a></li>';
    }
    
    public function render() {
        if ($this->total_pages <= 1) {
            return '';
        }
        
        $html = '<nav aria-label="Page navigation">';
        $html .= '<ul class="pagination justify-content-center">';
        
        // Nút Previous
        if ($this->current_page > 1) {
            $html .= $this->buildPaginationLink($this->current_page - 1, '&laquo; Trước');
        } else {
            $html .= $this->buildPaginationLink(0, '&laquo; Trước', false, true);
        }
        
        // Tính toán range của pages để hiển thị
        $start_page = max(1, $this->current_page - 2);
        $end_page = min($this->total_pages, $this->current_page + 2);
        
        // Nếu ở đầu, hiển thị thêm pages ở cuối
        if ($this->current_page <= 3) {
            $end_page = min($this->total_pages, 5);
        }
        
        // Nếu ở cuối, hiển thị thêm pages ở đầu
        if ($this->current_page > $this->total_pages - 3) {
            $start_page = max(1, $this->total_pages - 4);
        }
        
        // Hiển thị page đầu và ... nếu cần
        if ($start_page > 1) {
            $html .= $this->buildPaginationLink(1, '1');
            
            if ($start_page > 2) {
                $html .= $this->buildPaginationLink(0, '...', false, true);
            }
        }
        
        // Hiển thị các page numbers
        for ($page = $start_page; $page <= $end_page; $page++) {
            if ($page == $this->current_page) {
                $html .= $this->buildPaginationLink($page, $page, true);
            } else {
                $html .= $this->buildPaginationLink($page, $page);
            }
        }
        
        // Hiển thị ... và page cuối nếu cần
        if ($end_page < $this->total_pages) {
            if ($end_page < $this->total_pages - 1) {
                $html .= $this->buildPaginationLink(0, '...', false, true);
            }
            
            $html .= $this->buildPaginationLink($this->total_pages, $this->total_pages);
        }
        
        // Nút Next
        if ($this->current_page < $this->total_pages) {
            $html .= $this->buildPaginationLink($this->current_page + 1, 'Sau &raquo;');
        } else {
            $html .= $this->buildPaginationLink(0, 'Sau &raquo;', false, true);
        }
        
        $html .= '</ul>';
        $html .= '</nav>';
        
        // Thông tin hiển thị
        $start_record = $this->getOffset() + 1;
        $end_record = min($this->getOffset() + $this->records_per_page, $this->total_records);
        
        $html .= '<div class="text-center mt-3">';
        $html .= '<small class="text-muted">';
        $html .= 'Hiển thị ' . $start_record . ' - ' . $end_record . ' trong tổng số ' . $this->total_records . ' bản ghi';
        $html .= '</small>';
        $html .= '</div>';
        
        return $html;
    }
    
    public function renderPageSizeSelector($page_sizes = [10, 25, 50, 100]) {
        $html = '<div class="d-flex justify-content-between align-items-center mb-3">';
        $html .= '<div>';
        $html .= '<label for="pageSize" class="form-label me-2">Hiển thị:</label>';
        $html .= '<select id="pageSize" class="form-select form-select-sm d-inline-block w-auto" onchange="changePageSize(this.value)">';
        
        foreach ($page_sizes as $size) {
            $selected = ($size == $this->records_per_page) ? 'selected' : '';
            $html .= '<option value="' . $size . '" ' . $selected . '>' . $size . ' bản ghi</option>';
        }
        
        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';
        
        $html .= '<script>';
        $html .= 'function changePageSize(size) {';
        $html .= '  var url = new URL(window.location);';
        $html .= '  url.searchParams.set("per_page", size);';
        $html .= '  url.searchParams.set("page", 1);';
        $html .= '  window.location.href = url.toString();';
        $html .= '}';
        $html .= '</script>';
        
        return $html;
    }
}
?>
