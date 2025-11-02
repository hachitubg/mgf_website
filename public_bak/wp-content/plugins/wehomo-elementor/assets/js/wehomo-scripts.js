jQuery(function ($) {
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/el_activities.default', function ($scope) {
            var wehomo_activities = $scope.find('#wehomo-activities');
            if ( wehomo_activities.length > 0 ){
                $(document).on( 'click', '.wehomo-pagination .page-numbers', function( event ) {
                    event.preventDefault();
                    var current = parseInt( $('.wehomo-pagination .current').html() );
                    var page;
                    if ($(this).hasClass('prev')){
                        page = current - 1;
                    }
                    else if ($(this).hasClass('next')){
                        page = current + 1;
                    }
                    else{
                        page = parseInt( $(this).html() );
                    }
                    var cat_id = $('#w-posts-by-category').attr('data-id');
                    var data = {
                        action: 'wehomo_load_posts_by_category',
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
                            $(".wehomo-loading").removeClass('show');
                            $('#w-posts-by-category').html(response.content);
                        }
                    })
                } );
            }
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/el_image_carousel.default', function ($scope) {
            var wehomo_carousel = $scope.find('.wehomo-image-carousel');
            if ( wehomo_carousel.length > 0 ){
                var template_1_rows = $scope.find('.carousel_1_rows');
                var template_2_rows = $scope.find('.carousel_2_rows');
                if ( template_2_rows.length > 0 ){
                    template_2_rows.slick({
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        dots: true,
                        rows: 2,
                        arrows: true,
                        prevArrow: wehomo_carousel.find('.prev-arrow'),
                        nextArrow: wehomo_carousel.find('.next-arrow'),
                        appendDots: wehomo_carousel.find('.w-dots'),
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
                }

                if ( template_1_rows.length > 0 ){
                    template_1_rows.slick({
                        slidesToShow: 5,
                        slidesToScroll: 5,
                        dots: true,
                        rows: 1,
                        arrows: true,
                        prevArrow: wehomo_carousel.find('.prev-arrow'),
                        nextArrow: wehomo_carousel.find('.next-arrow'),
                        appendDots: wehomo_carousel.find('.w-dots'),
                        responsive:  [
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: 3,
                                    slidesToScroll: 3,
                                }
                            },
                            {
                                breakpoint: 0,
                                settings: {
                                    slidesToShow: 2,
                                    slidesToScroll: 2
                                }
                            }
                        ]
                    });
                }

				$(document).on('click', ".elementor-tab-title",function(){
					template_1_rows.slick('refresh');
					template_2_rows.slick('refresh');
				});
// 				$(".elementor-tab-title").click(function(){
// 					template_1_rows.slick('refresh');
// 					template_2_rows.slick('refresh');
// 				});
				$(document).on('scroll', function(){
					$(window).resize();
				})
            }
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/el_timeline.default', function ($scope) {
            var wehomo_timeline = $scope.find('.wehomo-timeline');
            if ( wehomo_timeline.length > 0 ){
                $('.w-timeline-inner').slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    dots: false,
                    arrows: true,
					loop: true,
					infinite: true,
                    prevArrow: wehomo_timeline.find('.prev-arrow'),
                    nextArrow: wehomo_timeline.find('.next-arrow'),
                    responsive:  [{
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
							loop: true,
                        }
                    },
                    {
                        breakpoint: 0,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }]
                });
            }
        });
		elementorFrontend.hooks.addAction('frontend/element_ready/el_featured_awards.default', function ($scope) {
            var wehomo_awards = $scope.find('.wehomo-awards');
            if ( wehomo_awards.length > 0 ){
                $('.w-awards-inner').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true,
                    arrows: false,
					fade: true,
					appendDots: wehomo_awards.find('.w-dots'),
                    responsive:  [{
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 0,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }]
                });
            }
        });
		elementorFrontend.hooks.addAction('frontend/element_ready/el_recruit.default', function ($scope){
			$(document).on('click', '.w-recruit-term-item', function() {
				$('.w-recruit-term-item').removeClass('show');
				$(this).addClass("show");
				$(this).find($('.w-recruit-child-term-item')).removeClass('show');
				$(this).parents('.w-recruit-term-item').addClass('show');
			})
			$(document).on('change', '.w-select-recruit', function(event){
				event.stopPropagation();
				var optionSelected = $(this).find("option:selected");
				var term_id = optionSelected.val();
				var data = {
					action: 'wehomo_load_recruitment_item_by_term',
					term_id,
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
						$('.w-recruit-outer').html(response.content);
						wehomo_accordion_recruitment();
					}
				})
			});
			function wehomo_accordion_recruitment(){
				var accordions = null;
				var containers = null;
				var slideDuration = 400;
				var scrollDuration = 400;
				var body = null;
				var classNameShow = 'show';
				var classNameAccordion = '.w-recruitment-accordion';
				var classNameContainer = '.w-recruitment-content';
				var dataOffsetTop = 'offsetTop';
				jQuery(function($){
					$(document).ready(function(){
						body = $('html, body');
						accordions = $(classNameAccordion);
						containers = $(classNameContainer);
						accordions.each(function(){
							var openedAccordions=accordions.filter(function(){return $(this).hasClass(classNameShow);});
							openedAccordions.removeClass(classNameShow);
							openedAccordions.next(classNameContainer).stop(true).slideDown({
								duration:slideDuration,
								complete:function(){openedAccordions.addClass(classNameShow);}
							});
						});
						accordions.click(function(){
							var currentAccordion=$(this);
							var currentContainer=$(this).next(classNameContainer);
							var openedAccordions=accordions.filter(function(){return $(this).hasClass(classNameShow);});
							if(!currentAccordion.hasClass(classNameShow)){
								currentContainer.stop(true).slideDown({
									duration:slideDuration,
									complete:function(){currentAccordion.addClass(classNameShow);}
								});
								body.stop(true).animate({scrollTop:currentAccordion.data(dataOffsetTop)},scrollDuration);
							}else{
								currentContainer.stop(true).slideUp({
									duration:slideDuration,
									complete:function(){currentAccordion.removeClass(classNameShow);}
								});
							}
							containers.not(currentContainer).stop(true).slideUp({
								duration:slideDuration,
								complete:function(){openedAccordions.removeClass(classNameShow);}
							});
						});
					});
				})
			}

			var w_recruit = $scope.find('.wehomo-recruitment');
			if ( w_recruit.length > 0 ){
				wehomo_accordion_recruitment();
				$(document).on( 'click', '.w-recruit-term-item', function( event ) {
                    event.stopPropagation();
					term_id = $(this).attr('data-term-id');
					var data = {
                        action: 'wehomo_load_recruitment_item_by_term',
                        term_id,
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
                            $('.w-recruit-outer').html(response.content);
							wehomo_accordion_recruitment();
                        }
                    })
                } );
				function wehomo_accordion_recruitment(){
					var accordions = null;
					var containers = null;
					var slideDuration = 400;
					var scrollDuration = 400;
					var body = null;
					var classNameShow = 'show';
					var classNameAccordion = '.w-recruitment-accordion';
					var classNameContainer = '.w-recruitment-content';
					var dataOffsetTop = 'offsetTop';
					jQuery(function($){
						$(document).ready(function(){
							body = $('html, body');
							accordions = $(classNameAccordion);
							containers = $(classNameContainer);
							accordions.each(function(){
								var openedAccordions=accordions.filter(function(){return $(this).hasClass(classNameShow);});
								openedAccordions.removeClass(classNameShow);
								openedAccordions.next(classNameContainer).stop(true).slideDown({
									duration:slideDuration,
									complete:function(){openedAccordions.addClass(classNameShow);}
								});
							});
							accordions.click(function(){
								var currentAccordion=$(this);
								var currentContainer=$(this).next(classNameContainer);
								var openedAccordions=accordions.filter(function(){return $(this).hasClass(classNameShow);});
								if(!currentAccordion.hasClass(classNameShow)){
									currentContainer.stop(true).slideDown({
										duration:slideDuration,
										complete:function(){currentAccordion.addClass(classNameShow);}
									});
									body.stop(true).animate({scrollTop:currentAccordion.data(dataOffsetTop)},scrollDuration);
								}else{
									currentContainer.stop(true).slideUp({
										duration:slideDuration,
										complete:function(){currentAccordion.removeClass(classNameShow);}
									});
								}
								containers.not(currentContainer).stop(true).slideUp({
									duration:slideDuration,
									complete:function(){openedAccordions.removeClass(classNameShow);}
								});
							});
						});
					})
				}
			}
		})
		elementorFrontend.hooks.addAction('frontend/element_ready/el_featured_awards_home.default', function ($scope) {
			var wehomo_awards_home = $scope.find('.wehomo-awards-home');
			if ( wehomo_awards_home.length > 0 ){
				$('.w-awards-home-photo-wrap').slick({
					slidesToShow: 1,
					slidesToScroll: 1,
					arrows: false,
					fade: true,
					asNavFor: '.w-awards-home-timeline-nav'
				});
				$('.w-awards-home-timeline-nav').slick({
					slidesToShow: 50,
					slidesToScroll: 1,
					asNavFor: '.w-awards-home-photo-wrap',
					dots: false,
					focusOnSelect: true
				});
			}
		});
		elementorFrontend.hooks.addAction('frontend/element_ready/el_store_map.default', function ($scope) {
			$(document).on('click', '.w-store-list-item', function() {
				var location_map = $(this).attr("data-location");
				var image_map = $(this).attr("data-image");
				$(".w-store-list-item").removeClass("active");
				$(this).addClass("active");
				$(".w-store-gmaps").html(location_map);
				$(".w-store-thumbnail").attr("src", image_map);
			})
		});
    })
});