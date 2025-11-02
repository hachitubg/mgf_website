/**
 * Product Image Gallery with Auto-rotate Thumbnails
 */

document.addEventListener('DOMContentLoaded', function() {
    const gallery = document.querySelector('.woocommerce-product-gallery');
    
    if (!gallery) return;
    
    const mainImageContainer = gallery.querySelector('.woocommerce-product-gallery__image-main');
    const thumbnails = gallery.querySelectorAll('.woocommerce-product-gallery__thumbnail');
    
    if (thumbnails.length <= 1) return; // Không cần carousel nếu chỉ có 1 ảnh
    
    let currentIndex = 0;
    let autoRotateInterval = null;
    
    // Hàm hiển thị ảnh theo index
    function showImage(index) {
        // Remove active class from all thumbnails
        thumbnails.forEach(thumb => thumb.classList.remove('active'));
        
        // Add active class to current thumbnail
        thumbnails[index].classList.add('active');
        
        // Get image URL from thumbnail
        const imgUrl = thumbnails[index].getAttribute('data-image');
        const imgAlt = thumbnails[index].getAttribute('data-alt');
        
        // Update main image
        const mainLink = mainImageContainer.querySelector('a');
        const mainImg = mainImageContainer.querySelector('img');
        
        if (mainLink && mainImg) {
            mainLink.href = imgUrl;
            
            // Fade effect
            mainImg.style.opacity = '0';
            setTimeout(() => {
                mainImg.src = imgUrl;
                mainImg.alt = imgAlt;
                mainImg.style.opacity = '1';
            }, 150);
        }
        
        currentIndex = index;
    }
    
    // Hàm tự động chuyển ảnh
    function startAutoRotate() {
        stopAutoRotate(); // Clear any existing interval
        
        autoRotateInterval = setInterval(() => {
            const nextIndex = (currentIndex + 1) % thumbnails.length;
            showImage(nextIndex);
        }, 1000); // 1 giây
    }
    
    // Hàm dừng tự động chuyển
    function stopAutoRotate() {
        if (autoRotateInterval) {
            clearInterval(autoRotateInterval);
            autoRotateInterval = null;
        }
    }
    
    // Click vào thumbnail
    thumbnails.forEach((thumb, index) => {
        thumb.addEventListener('click', () => {
            stopAutoRotate(); // Dừng auto khi user click
            showImage(index);
            // Restart auto sau 3 giây
            setTimeout(() => {
                startAutoRotate();
            }, 3000);
        });
    });
    
    // Khởi động auto-rotate
    startAutoRotate();
    
    // Dừng khi rời chuột khỏi gallery
    gallery.addEventListener('mouseleave', () => {
        startAutoRotate();
    });
    
    // Dừng khi hover vào gallery
    gallery.addEventListener('mouseenter', () => {
        stopAutoRotate();
    });
});
