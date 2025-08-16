// Recently Viewed Products JavaScript
const RECENTLY_VIEWED_KEY = 'recently_viewed_products';
const MAX_RECENT_PRODUCTS = 12;

// Thêm sản phẩm vào danh sách vừa xem
function addToRecentlyViewed(product) {
    let recentProducts = getRecentlyViewed();
    
    // Xóa sản phẩm nếu đã tồn tại
    recentProducts = recentProducts.filter(p => p.id !== product.id);
    
    // Thêm vào đầu danh sách
    recentProducts.unshift(product);
    
    // Giới hạn số lượng
    if (recentProducts.length > MAX_RECENT_PRODUCTS) {
        recentProducts = recentProducts.slice(0, MAX_RECENT_PRODUCTS);
    }
    
    localStorage.setItem(RECENTLY_VIEWED_KEY, JSON.stringify(recentProducts));
    updateRecentlyViewedDisplay();
}

// Lấy danh sách sản phẩm vừa xem
function getRecentlyViewed() {
    try {
        return JSON.parse(localStorage.getItem(RECENTLY_VIEWED_KEY) || '[]');
    } catch (e) {
        return [];
    }
}

// Xóa một sản phẩm khỏi danh sách
function removeFromRecentlyViewed(productId) {
    let recentProducts = getRecentlyViewed();
    recentProducts = recentProducts.filter(p => p.id !== productId);
    localStorage.setItem(RECENTLY_VIEWED_KEY, JSON.stringify(recentProducts));
    updateRecentlyViewedDisplay();
}

// Xóa toàn bộ danh sách
function clearRecentlyViewed() {
    localStorage.removeItem(RECENTLY_VIEWED_KEY);
    updateRecentlyViewedDisplay();
}

// Format giá tiền
function formatPrice(price) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'decimal',
        minimumFractionDigits: 0
    }).format(price) + '₫';
}

// Cập nhật hiển thị
function updateRecentlyViewedDisplay() {
    const recentProducts = getRecentlyViewed();
    const section = document.getElementById('recently-viewed-section');
    const container = document.getElementById('recently-viewed-products');
    
    if (!section || !container) return;
    
    if (recentProducts.length === 0) {
        section.style.display = 'none';
        return;
    }
    
    section.style.display = 'block';
    
    container.innerHTML = recentProducts.map(product => `
        <div class="recently-viewed-item">
            <div class="recently-viewed-item-image">
                <img src="${product.image}" alt="${product.name}" loading="lazy">
            </div>
            <div class="recently-viewed-item-content">
                <a href="/product/${product.id}" class="recently-viewed-item-title">
                    ${product.name}
                </a>
                <div class="recently-viewed-item-price">
                    ${formatPrice(product.price)}
                </div>
                <div class="recently-viewed-item-actions">
                    <a href="/product/${product.id}" class="recently-viewed-btn recently-viewed-btn-primary">
                        Xem chi tiết
                    </a>
                    <button onclick="removeFromRecentlyViewed(${product.id})" 
                            class="recently-viewed-btn recently-viewed-btn-remove" 
                            title="Xóa khỏi danh sách">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    `).join('');
}

// Khởi tạo khi trang load
document.addEventListener('DOMContentLoaded', function() {
    updateRecentlyViewedDisplay();
}); 