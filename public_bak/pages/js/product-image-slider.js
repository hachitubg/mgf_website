/**
 * Product Image Slider on Hover - Auto cycle through images
 */

document.addEventListener('DOMContentLoaded', function() {
    // Tìm tất cả product cards (hỗ trợ cả listing page và detail page)
    const selectors = [
        '.elementor-wc-products ul.products li.product',
        '.mgf-product-card'
    ];
    
    const products = document.querySelectorAll(selectors.join(', '));
    
    products.forEach(product => {
        // Tìm slider containers - hỗ trợ cả class cũ và mới
        const imageContainers = product.querySelectorAll('.product-images, .mgf-img-slider');
        
        // Bỏ qua nếu không có nhiều ảnh
        if (imageContainers.length === 0) return;
        
        const imageCount = parseInt(imageContainers[0].getAttribute('data-image-count') || 0);
        if (imageCount <= 1) return;
        
        let interval = null;
        let index = 0;
        
        // Bắt đầu slider khi hover
        product.addEventListener('mouseenter', function() {
            index = 0;
            
            // Chuyển ảnh liên tục
            interval = setInterval(function() {
                const nextIndex = (index + 1) % imageCount;
                
                // Đổi ảnh cho TẤT CẢ containers
                imageContainers.forEach(function(container) {
                    // Hỗ trợ cả class cũ và mới
                    const items = container.querySelectorAll('.product-image-item, .mgf-img-slide');
                    if (items.length > 0) {
                        items[index].classList.remove('active');
                        items[nextIndex].classList.add('active');
                    }
                });
                
                index = nextIndex;
            }, 1200); // Chuyển ảnh mỗi 1.2 giây
        });
        
        // Dừng slider khi rời chuột
        product.addEventListener('mouseleave', function() {
            if (interval) {
                clearInterval(interval);
                interval = null;
            }
            
            // Reset về ảnh đầu tiên
            imageContainers.forEach(function(container) {
                const items = container.querySelectorAll('.product-image-item, .mgf-img-slide');
                items.forEach(function(item, i) {
                    if (i === 0) {
                        item.classList.add('active');
                    } else {
                        item.classList.remove('active');
                    }
                });
            });
            
            index = 0;
        });
    });
});
