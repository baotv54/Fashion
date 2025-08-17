// Product Comparison JavaScript
class ProductComparison {
    constructor() {
        this.init();
        this.updateComparisonCount();
        this.loadComparisonModal();
    }

    init() {
        this.bindEvents();
        this.updateComparisonButtons();
    }

    bindEvents() {
        // Event cho button thêm/xóa so sánh
        document.addEventListener('click', (e) => {
            if (e.target.matches('[data-type="shop-compare-button-add"]') || 
                e.target.closest('[data-type="shop-compare-button-add"]')) {
                e.preventDefault();
                this.toggleComparison(e.target);
            }
        });

        // Event cho button mở modal so sánh
        document.addEventListener('click', (e) => {
            if (e.target.matches('[data-type="shop-compare-header"]') || 
                e.target.closest('[data-type="shop-compare-header"]')) {
                e.preventDefault();
                this.openComparisonModal();
            }
        });

        // Event cho button đóng modal
        document.addEventListener('click', (e) => {
            if (e.target.matches('[data-type="shop-compare-modal-close"]') || 
                e.target.closest('[data-type="shop-compare-modal-close"]')) {
                e.preventDefault();
                this.closeComparisonModal();
            }
        });
    }

    async toggleComparison(button) {
        const productItem = button.closest('.product-item');
        const productId = productItem ? productItem.getAttribute('data-id') : 
                         button.getAttribute('data-product-id');

        if (!productId) {
            this.showNotification('Không tìm thấy thông tin sản phẩm', 'error');
            return;
        }

        const isInComparison = button.classList.contains('inStorage');
        const action = isInComparison ? 'remove' : 'add';

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            if (!csrfToken) {
                this.showNotification('CSRF token không tìm thấy', 'error');
                return;
            }
            
            const response = await fetch(`${window.location.origin}/comparison/${action}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ product_id: productId })
            });

            if (!response.ok) {
                const errorText = await response.text();
                this.showNotification(`HTTP Error: ${response.status}`, 'error');
                return;
            }

            const data = await response.json();

            if (data.success) {
                button.classList.toggle('inStorage');
                this.updateComparisonCount();
                this.updateComparisonButtons();
                this.showNotification(data.message, 'success');
                
                // Cập nhật modal nếu đang mở
                if (document.body.classList.contains('open-compare')) {
                    this.loadComparisonModal();
                }
            } else {
                this.showNotification(data.message, 'error');
            }
        } catch (error) {
            this.showNotification('Có lỗi xảy ra, vui lòng thử lại', 'error');
        }
    }

    async updateComparisonCount() {
        try {
            const response = await fetch(`${window.location.origin}/comparison/count`);
            const data = await response.json();
            
            // Cập nhật counter ở header
            const countElements = document.querySelectorAll('.shop-compare-count');
            countElements.forEach(el => {
                el.textContent = data.count;
            });

            // Hiển thị/ẩn badge
            const badges = document.querySelectorAll('.comparison-badge');
            badges.forEach(badge => {
                if (data.count > 0) {
                    badge.style.display = 'inline-block';
                    badge.textContent = data.count;
                } else {
                    badge.style.display = 'none';
                }
            });
        } catch (error) {
            // Error updating comparison count
        }
    }

    async updateComparisonButtons() {
        try {
            const response = await fetch(`${window.location.origin}/comparison/products`);
            const data = await response.json();
            
            if (data.success) {
                const productIds = data.products.map(p => p.id.toString());
                
                // Cập nhật trạng thái button
                document.querySelectorAll('[data-type="shop-compare-button-add"]').forEach(button => {
                    const productItem = button.closest('.product-item');
                    const productId = productItem ? productItem.getAttribute('data-id') : 
                                     button.getAttribute('data-product-id');
                    
                    if (productId && productIds.includes(productId)) {
                        button.classList.add('inStorage');
                        button.innerHTML = '<i class="fas fa-check"></i> Đã thêm';
                    } else {
                        button.classList.remove('inStorage');
                        button.innerHTML = '<i class="fas fa-balance-scale"></i> So sánh';
                    }
                });
            }
        } catch (error) {
            // Error updating comparison buttons
        }
    }

    async loadComparisonModal() {
        try {
            const response = await fetch(`${window.location.origin}/comparison/products`);
            const data = await response.json();
            
            const modal = document.querySelector('.shop-compare-modal');
            if (!modal) {
                return;
            }
            
            const nullMessage = modal.querySelector('.shop-compare-modal-null');
            const productsList = modal.querySelector('.shop-compare-products-list');
            const actions = modal.querySelector('.shop-compare-actions');

            if (data.success && data.products.length > 0) {
                nullMessage.style.display = 'none';
                actions.style.display = 'block';
                
                productsList.innerHTML = this.renderComparisonProducts(data.products);
            } else {
                nullMessage.style.display = 'block';
                actions.style.display = 'none';
                productsList.innerHTML = '';
            }
        } catch (error) {
            // Error loading comparison modal
        }
    }

    renderComparisonProducts(products) {
        return `
            <div class="row">
                ${products.map(product => `
                    <div class="col-md-3 col-6 mb-3">
                        <div class="product-item-small">
                            <div class="product-item-small-wrap">
                                <div class="product-item-small-image">
                                    <a href="${product.url}" class="product-item-small-image-link">
                                        <img src="${product.image}" alt="${product.name}" 
                                             style="width: 100%; height: 120px; object-fit: cover;">
                                    </a>
                                </div>
                                <div class="product-item-small-info">
                                    <h3 class="product-item-small-info-title">
                                        <a href="${product.url}">${product.name}</a>
                                    </h3>
                                    <p class="product-item-small-info-price">
                                        <strong>${this.formatPrice(product.price)}₫</strong>
                                    </p>
                                    <div class="product-item-small-info-action">
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="comparison.removeFromComparison(${product.id})">
                                            <i class="fas fa-times"></i> Xóa
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `).join('')}
            </div>
        `;
    }

    async removeFromComparison(productId) {
        try {
            const response = await fetch(`${window.location.origin}/comparison/remove`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ product_id: productId })
            });

            const data = await response.json();

            if (data.success) {
                this.updateComparisonCount();
                this.updateComparisonButtons();
                this.loadComparisonModal();
                this.showNotification(data.message, 'success');
            } else {
                this.showNotification(data.message, 'error');
            }
        } catch (error) {
            this.showNotification('Có lỗi xảy ra, vui lòng thử lại', 'error');
        }
    }

    openComparisonModal() {
        this.loadComparisonModal();
        document.body.classList.add('open-compare', 'open-overplay', 'open-noscroll');
    }

    closeComparisonModal() {
        document.body.classList.remove('open-compare', 'open-overplay', 'open-noscroll');
    }

    async clearComparison() {
        if (confirm('Bạn có chắc muốn xóa tất cả sản phẩm khỏi danh sách so sánh?')) {
            try {
                const response = await fetch(`${window.location.origin}/comparison/clear`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const data = await response.json();

                if (data.success) {
                    this.updateComparisonCount();
                    this.updateComparisonButtons();
                    this.loadComparisonModal();
                    this.showNotification(data.message, 'success');
                } else {
                    this.showNotification(data.message, 'error');
                }
            } catch (error) {
                this.showNotification('Có lỗi xảy ra, vui lòng thử lại', 'error');
            }
        }
    }

    formatPrice(price) {
        return new Intl.NumberFormat('vi-VN').format(price);
    }

    showNotification(message, type = 'info') {
        // Sử dụng SweetAlert nếu có, nếu không thì dùng alert
        if (typeof swal !== 'undefined') {
            const icon = type === 'success' ? 'success' : type === 'error' ? 'error' : 'info';
            swal(type === 'error' ? 'Lỗi!' : '', message, icon);
        } else {
            alert(message);
        }
    }
}

// Global functions for compatibility
window.clearComparison = function() {
    if (window.comparison) {
        window.comparison.clearComparison();
    }
};

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    window.comparison = new ProductComparison();
});

// Export for module use
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ProductComparison;
} 