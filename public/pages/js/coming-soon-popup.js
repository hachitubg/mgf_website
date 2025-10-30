/**
 * Coming Soon Popup Handler
 * Xử lý hiển thị popup cho các trang chưa ra mắt
 */

(function() {
    'use strict';
    
    // Tạo HTML cho popup
    function createPopupHTML() {
        const popupHTML = `
            <div id="comingSoonOverlay" class="coming-soon-overlay">
                <div class="coming-soon-popup">
                    <button class="coming-soon-close" aria-label="Đóng"></button>
                    <div class="coming-soon-popup-header">
                        <div class="coming-soon-icon">🚀</div>
                        <h2>Sắp Ra Mắt</h2>
                    </div>
                    <div class="coming-soon-popup-body">
                        <p>Trang</p>
                        <span class="coming-soon-page-title" id="comingSoonPageTitle"></span>
                        <p>đang được phát triển và sẽ ra mắt trong tương lai gần.</p>
                        <p style="margin-top: 20px; font-size: 14px; color: #888;">
                            Cảm ơn bạn đã quan tâm đến Ba Huân!
                        </p>
                        <button class="coming-soon-action-btn" id="comingSoonOkBtn">
                            Đã hiểu
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        // Thêm vào body
        document.body.insertAdjacentHTML('beforeend', popupHTML);
    }
    
    // Hiển thị popup
    function showPopup(pageTitle) {
        const overlay = document.getElementById('comingSoonOverlay');
        const pageTitleElement = document.getElementById('comingSoonPageTitle');
        
        if (overlay && pageTitleElement) {
            pageTitleElement.textContent = pageTitle;
            overlay.classList.add('active');
            document.body.classList.add('popup-active');
        }
    }
    
    // Ẩn popup
    function hidePopup() {
        const overlay = document.getElementById('comingSoonOverlay');
        
        if (overlay) {
            overlay.classList.remove('active');
            document.body.classList.remove('popup-active');
        }
    }
    
    // Khởi tạo event listeners
    function initEventListeners() {
        const overlay = document.getElementById('comingSoonOverlay');
        const closeBtn = document.querySelector('.coming-soon-close');
        const okBtn = document.getElementById('comingSoonOkBtn');
        
        // Đóng khi click vào overlay (ngoài popup)
        if (overlay) {
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) {
                    hidePopup();
                }
            });
        }
        
        // Đóng khi click nút X
        if (closeBtn) {
            closeBtn.addEventListener('click', hidePopup);
        }
        
        // Đóng khi click nút "Đã hiểu"
        if (okBtn) {
            okBtn.addEventListener('click', hidePopup);
        }
        
        // Đóng khi nhấn ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && overlay && overlay.classList.contains('active')) {
                hidePopup();
            }
        });
    }
    
    // Xử lý các link "coming soon"
    function handleComingSoonLinks() {
        const comingSoonLinks = document.querySelectorAll('a.coming-soon-link');
        
        comingSoonLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const pageTitle = this.getAttribute('data-page-title') || 'Trang này';
                showPopup(pageTitle);
            });
        });
    }
    
    // Khởi tạo khi DOM đã load
    function init() {
        // Tạo popup HTML
        createPopupHTML();
        
        // Khởi tạo event listeners
        initEventListeners();
        
        // Xử lý các link coming soon
        handleComingSoonLinks();
    }
    
    // Chạy khi DOM đã sẵn sàng
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
    // Export functions cho global scope nếu cần
    window.ComingSoonPopup = {
        show: showPopup,
        hide: hidePopup
    };
})();
