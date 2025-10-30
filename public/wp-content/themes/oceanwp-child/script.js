jQuery(function($){
	$(document).ready(function(){
		$(document).on('load', function(){
			$('.woocommerce-product-gallery .flex-control-nav li').first().addClass('active');
		})
		$(document).on('click', '.w-close-button', function() {
			$('.dialog-close-button').click();
		})
		
		$('.w-related-products').slick({
			slidesToShow: 6,
			slidesToScroll: 1,
			dots: false,
			arrows: true,
			prevArrow: '<button type="button" class="slick-prev"><i class="eicon-chevron-left"></i></button>',
			nextArrow: '<button type="button" class="slick-next"><i class="eicon-chevron-right"></i></button>',
			responsive:  [{
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2,
				}
			},
			{
				breakpoint: 0,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2
				}
			}]
		});
		
		$('.w-other-products').slick({
			slidesToShow: 6,
			slidesToScroll: 1,
			dots: false,
			arrows: true,
			centerMode: false,
			prevArrow: '<button type="button" class="slick-prev"><i class="eicon-chevron-left"></i></button>',
			nextArrow: '<button type="button" class="slick-next"><i class="eicon-chevron-right"></i></button>',
			responsive:  [{
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2,
				}
			},
			{
				breakpoint: 0,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2
				}
			}]
		});
		
		$('.w-loadmore-video').on('click', function(){
			var that = $(this);
			var cat_id = $(this).attr('data-id'),
				page = $(this).attr('data-page'),
				data = {
					action: 'wehomo_load_videos_by_category',
					cat_id,
					page,
				};
			$.ajax({
				url: wp_localize.ajaxUrl,
				data: data,
				type: "POST",
				beforeSend: function(xhr) {
					$(".wehomo-loading").addClass('show');
				},
				success: function(response) {
					that.attr('data-page', response.page);
					$(".wehomo-loading").removeClass('show');
					that.siblings('.w-posts-wrap').append(response.content);
					if ( response.code == '404' ){
						that.remove();
					}
				}
			})
		});
		
		$('.photo-nav-item-child').on('click', function(){
			var postid = $(this).attr('data-id');
			var w_catname = $(this).attr('data-catname');
			$('.photo-nav-item-child').removeClass('active');
			$(this).addClass('active');
			$('.photo-nav-item-parent').removeClass('active');
			$(this).parents('.photo-nav-item-parent').addClass('active');
			
			data = {
				action: 'wehomo_get_gallery_by_postid',
				postid,
				w_catname,
			};
			$.ajax({
				url: wp_localize.ajaxUrl,
				data: data,
				type: "POST",
				beforeSend: function(xhr) {
					$(".wehomo-loading").addClass('show');
				},
				success: function(response) {
					$(".wehomo-loading").removeClass('show');
					$('.w-photo-content-inner').slick('unslick');
					$('.w-response-gallery').html(response);
					
					$('.w-photo-content-inner').slick(getSliderSettings());
				}
			})
		});
		
		$('.photo-nav-item-parent').on('click', function(){
			$('.photo-nav-item-parent').removeClass('active');
			$(this).addClass('active');
		})
		
		$(document).find('.w-photo-content-inner').slick(getSliderSettings());
		
		function getSliderSettings() {
			return {
				slidesToShow: 3,
				slidesToScroll: 3,
				dots: true,
				rows: 4,
				arrows: true,
				prevArrow: $('.w-slick-controls').find('.prev-arrow'),
				nextArrow: $('.w-slick-controls').find('.next-arrow'),
				appendDots: $('.w-slick-controls').find('.w-dots'),
				responsive:  [{
					breakpoint: 768,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 2,
					}
				},
				{
					breakpoint: 0,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 2
					}
				}]
			}
		}
		
		$('.woocommerce-product-gallery .flex-control-nav li').on('click', function(){
			$('.woocommerce-product-gallery .flex-control-nav li').removeClass('active');
			$(this).addClass('active');
		})
		
		if ( $(".w-sticky-nav-tab").length ) {
			class StickyNavigation {

				constructor() {
					this.tabContainerHeight = 70;
					this.lastScroll = 0;
					let self = this;
					$(window).scroll(() => { this.onScroll(); });
				}

				onScroll() {
					this.checkHeaderPosition();
					this.lastScroll = $(window).scrollTop();
				}

				checkHeaderPosition() {
					const headerHeight = 75;
					if($(window).scrollTop() > headerHeight) {
						$('.w-full-header').addClass('w-full-header--scrolled');
					} else {
						$('.w-full-header').removeClass('w-full-header--scrolled');
					}
					let offset = ($('.w-sticky-nav-tab').offset().top + $('.w-sticky-nav-tab').height() - this.tabContainerHeight) - headerHeight;
					if($(window).scrollTop() > this.lastScroll && $(window).scrollTop() > offset) {
						$('.w-sticky-nav-tab .elementor-container').removeClass('elementor-container--top-first');
						$('.w-sticky-nav-tab .elementor-container').addClass('elementor-container--top-first'); 
					} 
					else if($(window).scrollTop() < this.lastScroll && $(window).scrollTop() > offset) {
						$('.w-sticky-nav-tab .elementor-container').removeClass('elementor-container--top-second');
						$('.w-sticky-nav-tab .elementor-container').addClass('elementor-container--top-first');
					}
					else {
						$('.w-sticky-nav-tab .elementor-container').removeClass('elementor-container--top-first');
						$('.w-sticky-nav-tab .elementor-container').removeClass('elementor-container--top-second');
					}
				}
			}
			new StickyNavigation();
		}
		else if ( $(".w-phat-trien-tab").length ) {
			class StickyNavigation {

				constructor() {
					this.tabContainerHeight = 70;
					this.lastScroll = 0;
					let self = this;
					$(window).scroll(() => { this.onScroll(); });
				}

				onScroll() {
					this.checkHeaderPosition();
					this.lastScroll = $(window).scrollTop();
				}

				checkHeaderPosition() {
					const headerHeight = 75;
					if($(window).scrollTop() > headerHeight) {
						$('.w-full-header').addClass('w-full-header--scrolled');
					} else {
						$('.w-full-header').removeClass('w-full-header--scrolled');
					}
					let offset = ($('.w-phat-trien-tab').offset().top + $('.w-sticky-nav-tab').height() - this.tabContainerHeight) - headerHeight;
					if($(window).scrollTop() > this.lastScroll && $(window).scrollTop() > offset) {
						$('.w-phat-trien-tab .elementor-tabs-wrapper').removeClass('elementor-container--top-first');
						$('.w-phat-trien-tab .elementor-tabs-wrapper').addClass('elementor-container--top-first'); 
					} 
					else if($(window).scrollTop() < this.lastScroll && $(window).scrollTop() > offset) {
						$('.w-phat-trien-tab .elementor-tabs-wrapper').removeClass('elementor-container--top-second');
						$('.w-phat-trien-tab .elementor-tabs-wrapper').addClass('elementor-container--top-first');
					}
					else {
						$('.w-phat-trien-tab .elementor-tabs-wrapper').removeClass('elementor-container--top-first');
						$('.w-phat-trien-tab .elementor-tabs-wrapper').removeClass('elementor-container--top-second');
					}
				}
			}
			new StickyNavigation();
		}
		else {
			class StickyNavigation {

				constructor() {
					this.lastScroll = 0;
					let self = this;
					$(window).scroll(() => { this.onScroll(); });
				}

				onScroll() {
					this.checkHeaderPosition();
					this.lastScroll = $(window).scrollTop();
				}

				checkHeaderPosition() {
					const headerHeight = 137;
					let offset = $('.w-full-header').offset().top - headerHeight;
					if($(window).scrollTop() > this.lastScroll && $(window).scrollTop() > offset) {
// 						$('.w-full-header').addClass('w-full-header--move-up');
					} 
					else if($(window).scrollTop() < this.lastScroll && $(window).scrollTop() > offset) {
// 						$('.w-full-header').removeClass('w-full-header--move-up');
					}
					else {
// 						$('.w-full-header').removeClass('w-full-header--move-up');
					}
				}
			}
			new StickyNavigation();
		}
	})
})