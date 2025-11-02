/**
 * Product Slider Navigation with Buttons
 * Creates navigation buttons for product grid scrolling
 */

document.addEventListener('DOMContentLoaded', function() {
    const sliders = document.querySelectorAll('.mgf-product-grid-wrapper');
    
    sliders.forEach(wrapper => {
        const grid = wrapper.querySelector('.mgf-product-grid');
        if (!grid) return;
        
        const cards = grid.querySelectorAll('.mgf-product-card');
        if (cards.length <= 4) return; // Không cần slider nếu ≤4 sản phẩm
        
        // Tạo navigation buttons
        const navPrev = document.createElement('button');
        navPrev.className = 'mgf-slider-nav mgf-slider-prev';
        navPrev.innerHTML = '&#8249;'; // Left arrow character
        navPrev.setAttribute('aria-label', 'Previous');
        
        const navNext = document.createElement('button');
        navNext.className = 'mgf-slider-nav mgf-slider-next';
        navNext.innerHTML = '&#8250;'; // Right arrow character
        navNext.setAttribute('aria-label', 'Next');
        
        wrapper.style.position = 'relative';
        wrapper.appendChild(navPrev);
        wrapper.appendChild(navNext);
        
        // Xử lý scroll
        const scrollAmount = 300;
        
        navPrev.addEventListener('click', () => {
            grid.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth'
            });
        });
        
        navNext.addEventListener('click', () => {
            grid.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        });
        
        // Cập nhật trạng thái buttons
        function updateButtons() {
            const scrollLeft = grid.scrollLeft;
            const maxScroll = grid.scrollWidth - grid.clientWidth;
            
            // Prev button
            if (scrollLeft <= 0) {
                navPrev.style.opacity = '0';
                navPrev.disabled = true;
            } else {
                navPrev.style.opacity = '1';
                navPrev.disabled = false;
            }
            
            // Next button
            if (scrollLeft >= maxScroll - 5) {
                navNext.style.opacity = '0';
                navNext.disabled = true;
            } else {
                navNext.style.opacity = '1';
                navNext.disabled = false;
            }
        }
        
        grid.addEventListener('scroll', updateButtons);
        updateButtons();
        
        // Cập nhật khi resize
        window.addEventListener('resize', updateButtons);
    });
});
