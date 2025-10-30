/**
 * Thành tựu nổi bật - Awards Section Script
 */
(function($) {
    'use strict';
    
    // Wait for DOM and jQuery to be ready
    $(window).on('load', function() {
        setTimeout(function() {
            initAwardsSlider();
        }, 100);
    });
    
    $(document).ready(function() {
        initAwardsSlider();
    });
    
    function initAwardsSlider() {
        const $awardsContainer = $('#wehomo-awards, .wehomo-awards');
        
        if ($awardsContainer.length === 0) {
            console.log('Awards container not found');
            return;
        }
        
        const $awardsItems = $awardsContainer.find('.w-awards-item');
        const $dotsContainer = $awardsContainer.find('.w-dots, .dots-container');
        const totalItems = $awardsItems.length;
        
        console.log('Total awards items:', totalItems);
        
        if (totalItems === 0) {
            return;
        }
        
        // Show first item
        let currentIndex = 0;
        $awardsItems.hide();
        $awardsItems.eq(currentIndex).show().addClass('slick-active');
        
        // Create pagination dots
        if ($dotsContainer.length > 0 && totalItems > 1) {
            $dotsContainer.empty();
            
            for (let i = 0; i < totalItems; i++) {
                const isActive = i === 0 ? ' active slick-active' : '';
                const $li = $('<li class="' + isActive + '"></li>');
                const $button = $('<button type="button">' + (i + 1) + '</button>');
                $button.data('index', i);
                $li.append($button);
                $dotsContainer.append($li);
            }
            
            console.log('Pagination created with', totalItems, 'items');
            
            // Add click event to dots
            $dotsContainer.on('click', 'button', function(e) {
                e.preventDefault();
                const newIndex = parseInt($(this).data('index'));
                
                console.log('Clicked button:', newIndex);
                
                if (newIndex !== currentIndex && newIndex >= 0 && newIndex < totalItems) {
                    // Hide current item
                    $awardsItems.eq(currentIndex).removeClass('slick-active').hide();
                    
                    // Show new item
                    $awardsItems.eq(newIndex).addClass('slick-active').show();
                    
                    // Update dots
                    $dotsContainer.find('li').removeClass('active slick-active');
                    $dotsContainer.find('li').eq(newIndex).addClass('active slick-active');
                    
                    // Update current index
                    currentIndex = newIndex;
                }
            });
        }
    }
    
})(jQuery);

