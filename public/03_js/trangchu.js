jQuery(document).ready(function ($) {
    jQuery('.banner-carousel').owlCarousel({
        items:1,
        nav:false,
        navText:["<div class='nav-btn prev-nav '></div>","<div class='nav-btn next-nav '></div>"],
        dots:false,
        loop:true,
        mouseDrag:false,
        autoplay:true,
        autoplayTimeout:8000,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
    });
    
    
});

jQuery(document).ready(function ($) {

    var autoplay = false;
    if(window.matchMedia("(max-width: 1023px)").matches)
        autoplay = true;
    $('[data-fancybox]').fancybox({
        fullScreen: {
            autoStart: autoplay
        },

        // Set `touch: false` to disable panning/swiping
        touch: {
            vertical: true, // Allow to drag content vertically
            momentum: true // Continue movement after releasing mouse/touch when panning
        },

        video: {
            tpl:
            '<video class="fancybox-video fancybox-fullscreen" controls controlsList="nodownload">' +
            '<source src="{{src}}" type="{{format}}" />' +
            'Sorry, your browser doesn\'t support embedded videos, <a href="{{src}}">download</a> and watch with your favorite video player!' +
            "</video>",
            format: "", // custom video format
            autoStart: true
        },
    });
});

jQuery(document).ready(function ($) {
    NewsCarouselInit();
    function NewsCarouselInit()
    {
        jQuery('.news-carousel').owlCarousel({
            nav:true,
            navText:["<div class='nav-btn prev-nav '><img width='28' height='28' src='https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/arr-next2.svg' alt='Prev'></div>","<div class='nav-btn next-nav '><img width='28' height='28' src='https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/arr-next2.svg' alt='Next'></div>"],
            dots:true,
            loop:false,
            margin:30,
            smartSpeed:450,
            responsive:{
                0:{
                    items:1,
                    slideBy:1,
                    stagePadding:0,
                    nav:false
                },
                    600:{
                    stagePadding:0,
                    items:2,
                },
        
                1024:{
                    items:3,
                    slideBy:3,
                    nav:true,
                    margin:20,
                    stagePadding:100,
                },
                1366:{
                    items:3,
                    slideBy:3,
                    nav:true,
                    stagePadding:0,
                }

            },
            
        });
    }
    
    setTimeout(function() { 
        EqualizeHeights();
    }, 10);
    
    var resizeTimer;
    $(window).on('resize', function(e) {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            EqualizeHeights();   
        }, 250);
    });
    function EqualizeHeights() {
        var max = 0;
        jQuery('.article__title').each(function (index, value) {
            max = max_value(max, $(this).find('a').height());
        });
        //jQuery('.article__title').css('min-height',max+'px');
    }
    function max_value($number1,$number2)
    {
        return Math.max($number1,$number2);
    }
    
    if($('.news').length)
    {
        var newsletterSection = new gsap.timeline({paused:true});
        ScrollTrigger.create({
            trigger: '.news',
            start: 'top center',
            onEnter: newsletterSectionAni,
        // markers: true
        });
        function newsletterSectionAni()
        {
            newsletterSection.play();
            
        }
        const gallerys = gsap.utils.toArray('.news-inner>div');
        gallerys.forEach((icon, i) => {
            newsletterSection.add(
                gsap.fromTo(icon, 
                {   alpha:0,
                    y:50,
                }, {
                    duration:.5, 
                    alpha:1,
                    y:0,
                    ease: 'power4.easeOut',
                }),
                
            "-=.25"); 
        });
    
    }
});




jQuery(document).ready(function($){
        
        jQuery('.tabs-navs a').on("click", function (e) {
            e.preventDefault();
            var $this = $(this);
            var id = $this.attr('href');
            $('.tabs-navs a').removeClass('active');
            $this.addClass('active');
            $('.tab-content').removeClass('active');
            $(id).addClass('active');
        });

        jQuery(document).on('mouseenter touchstart', '.layer-item', function () {
                var $this = jQuery(this);
                $('.layer-item').removeClass('active');
                $this.addClass('active');

            }).on('mouseleave', '.layer-item', function () {
                $('.layer-item').removeClass('active');
                $('.layer-item:first-child').addClass('active');
        });
        
        
        if($('.layers').length )
        {
            var layersSection = new gsap.timeline({paused:true});
            ScrollTrigger.create({
                trigger: '.layers',
                start: 'top 75%',
                onEnter: layersSectionAni,
            // markers: true
            });
            function layersSectionAni()
            {
                layersSection.play();
                
            }
            const gallerys = gsap.utils.toArray('.layer-item');
                gallerys.forEach((icon, i) => {
                    layersSection.add(
                        gsap.fromTo(icon, 
                        {   alpha:0,
                            y:50,
                        }, {
                            duration:.75, 
                            alpha:1,
                        y:0,
                            ease: 'power4.easeOut',
                        }),
                        
                    "-=.125"); 
                });
                    
            
        }

        
});


jQuery(document).ready(function ($) {

    if($('.development-section').length)
    {
        var developmentSection = new gsap.timeline({paused:true});
        ScrollTrigger.create({
            trigger: '.development-section',
            start: 'top center',
            onEnter: developmentSectionAni,
            
        });
        function developmentSectionAni()
        {
            developmentSection.play();
            
        }

        developmentSection.add(
            gsap.fromTo('.development-section .development-section__images', 
            {   alpha:0,
                y:50,
            }, {
                duration:.75, 
                alpha:1,
                delay:.5,
                y:0,
                ease: 'power4.easeOut',
            }),
            
        "0"); 

        developmentSection.add(
            gsap.fromTo('.development-section .section-title-wrapper', 
            {   alpha:0,
                y:50,
            }, {
                duration:.75, 
                alpha:1,
                delay:.5,
                y:0,
                ease: 'power4.easeOut',
                onComplete () {
                    AccorAni()
                }
            }),
            
        "0"); 
        
        const accordions = gsap.utils.toArray('.development-section .accordion ');
        accordions.forEach((icon, i) => {
            developmentSection.add(
                gsap.fromTo(icon, 
                {   alpha:0,
                    y:50,
                }, {
                    duration:.5, 
                    alpha:1,
                    y:0,
                    ease: 'power4.easeOut',
                }),
                
            "-=.25"); 
        });
        
        developmentSection.add(
            gsap.fromTo('.development-section .btn', 
            {   alpha:0,
                y:50,
            }, {
                duration:.75, 
                alpha:1,
                delay:.5,
                y:0,
                ease: 'power4.easeOut',
                
            }),
            
        "+=0"); 
    }


    
    $('body').on('click','.accordion__header', function(e) {
        jQuery('.accordion').removeClass('active');
        $(this).parent().addClass('active');
        AccorAni();
        var currentIndex = $(this).parent().index();
        showImage(currentIndex);
    });
    let images = $(".development-section__image");
    
    function showImage(index) {
        
        gsap.to(images, { opacity: 0, duration: 0.75 }); 
        gsap.to(images.eq(index), { opacity: 1, duration: 0.75 });
    }

    function AccorAni()
    {
        jQuery('.accordion').each(function (index) {
            if($(this).hasClass('active'))
            {
                LineAni($(this),true)
                ContentAni($(this),false)
            }
            else
            {
                LineAni($(this),false)
                ContentAni($(this),true)
            }
        });
        
    }
    function LineAni($this,reverse)
    {
        if(reverse)
        {
            gsap.to($this.find('.accordion__icon'), 0.35, {
                rotation: 180,
                autoAlpha: 1,
            });
        }
        else
        {
            gsap.to($this.find('.accordion__icon'), 0.35, {
                rotation: 0,
                autoAlpha: 1,
            });
        }
        
    }
    function ContentAni($this,reverse)
    {
        if(reverse)
        {
            gsap.to($this.find('.accordion__content'), 0, {
                height: 0,
                autoAlpha: 0,
                marginTop: 0, 
                paddingBottom: 0, 
                display:"none"
            });
            //$this.find(".counter").text('0');
        }
        else
        {
            gsap.to($this.find('.accordion__content'), 0.35, {
                height: 'auto',
                autoAlpha: 1,
                marginTop: '0.75rem', 
                paddingBottom: '0.75rem', 
                display:"flex"
            });

            $this.find(".counter").countimator({});
            gsap.to(window, {
                scrollTo: window.scrollY + 3,
                duration: 0.2, 
                
            });
            
            
        }
        
    }
});


jQuery(document).ready(function ($) {
    jQuery('[data-fancybox="gallery"]').fancybox({
            autoSize : true,
            fitToView : true,
            animationEffect : 'zoom-in-out',
            transitionEffect: "fade",
            
        });
        jQuery('.certificates-list').owlCarousel({
            nav:true,
            navText:["<div class='nav-btn prev-nav '><img width='28' height='28' src='https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/arr-next2.svg' alt='Prev'></div>","<div class='nav-btn next-nav '><img width='28' height='28' src='https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/arr-next2.svg' alt='Next'></div>"],
            dots:false,
            items:1,
            smartSpeed:450,
            mouseDrag:true,
            touchDrag:true,
            responsive:{
                0:{
                    items:1,
                    margin:16,
                    stagePadding:80,
                    center:true,
                },
                    600:{
                    margin:16,
                    stagePadding:80,
                    items:2,
                },
                
                1024:{
                    items:4,
                    margin:60,
                    dots:false,
                    loop:false, 
                    
                }
            },
        });

        if($('.certificates').length)
        {
            var ttSection = new gsap.timeline({paused:true});
            ScrollTrigger.create({
                trigger: '.certificates',
                start: 'top center',
                onEnter: ttSectionAni,
            // markers: true
            });
            function ttSectionAni()
            {
                ttSection.play();
                
            }
            const gallerys = gsap.utils.toArray('.certificate-item');
            gallerys.forEach((icon, i) => {
                ttSection.add(
                    gsap.fromTo(icon, 
                    {   alpha:0,
                        y:50,
                    }, {
                        duration:.5, 
                        alpha:1,
                        delay:.25,
                        y:0,
                        ease: 'power4.easeOut',
                    }),
                    
                "=-.25"); 
            });
        
        }
});

jQuery(document).ready(function ($) {
					var flagshow = true;
					
					setTimeout(function(){
                            $('.suggestions_list').addClass('showtime');
							if(flagshow && $('.suggestions_list').hasClass('showpos'))
							{
								flagshow = false;
								hienthi_fomo();
							}
					}, Number(5000));

					$(window).scroll(function()
					{
						//nếu là page thì lấy body vì nhiều page dùng template khác nhau
						var ele = $('body');
						if($(window).scrollTop() > (ele.offset().top + ele.height()*Number(0.1) - jQuery(window).height())) 
						{
							$('.suggestions_list').addClass('showpos');
							if(flagshow && $('.suggestions_list').hasClass('showtime'))
							{
								flagshow = false;
								hienthi_fomo();
							}
						}
					});
					
					
					var demfomo = 0;
					var timeoutId = null;
					var isHovering = false;

					// Xử lý hover
					jQuery(document).ready(function($) {
						$('.suggestions_list').on('mouseenter', function() {
							isHovering = true;
						}).on('mouseleave', function() {
							isHovering = false;
							// Tiếp tục fadeout khi rời chuột
							//checkAndFadeOut();
						});
					});

					function hienthi_fomo() {
						demfomo++;
						var sogiay = {1: 0, 2: 10, 3: 10, 4: 10, 5: 10, 6: 10, 7: 10, 8: 10, 9: 10, 10: 10};
						var slfomo = jQuery('.suggestions_list .suggestions_item').length;
						
						timeoutId = setTimeout(function() {
							jQuery('.suggestions_list .suggestions_item:nth-child(' + demfomo + ')').addClass('show');
							
							setTimeout(function() {
								checkAndFadeOut();
							}, 7000);
							
						}, sogiay[demfomo] * 1000);
					}

					function checkAndFadeOut() {
						if (isHovering) {
							// Nếu đang hover, check lại sau 500ms
							setTimeout(checkAndFadeOut, 500);
						} else {
							// Fadeout và tiếp tục
							jQuery('.suggestions_list .suggestions_item:nth-child(' + demfomo + ')').removeClass('show');
							
							var slfomo = jQuery('.suggestions_list .suggestions_item').length;
							if (demfomo < slfomo) {
								hienthi_fomo();
							} else {
								// Reset để lặp lại từ đầu (nếu cần)
								demfomo = 0;
								// hienthi_fomo(); // Bỏ comment nếu muốn lặp vô hạn
							}
						}
					}

					
					jQuery('body').on('click', '.suggestions_item .close', function(e) {
                    	e.preventDefault();
						e.stopPropagation();
						//clearTimeout(timeoutId);
						jQuery('.suggestions_list .suggestions_item').removeClass('show');
                	});
					
					
				});



jQuery(document).ready(function ($) {
					var flagshow = true;
					var popup = Cookies.get('popup_1');
					if(popup)
					{
						flagshow = false;
					}
					setTimeout(function(){
                            $('[data-trigger=#newsletter]').addClass('showtime');
							if(flagshow && $('[data-trigger=#newsletter]').hasClass('showpos'))
							{
								flagshow = false;
								$('[data-trigger=#newsletter]').addClass('show');
							}
					}, Number(100000));

					$(window).scroll(function()
					{
						if($(window).scrollTop() > ($("body").height()*Number(0.3) - jQuery(window).height())) 
						{
							$('[data-trigger=#newsletter]').addClass('showpos');
							if(flagshow && $('[data-trigger=#newsletter]').hasClass('showtime'))
							{
								flagshow = false;
								$('[data-trigger=#newsletter]').addClass('show');
							}
						}
					});
					
					jQuery(document).click(function (event) {
						$target = jQuery(event.target);
						if (!$target.closest('.popup').length && jQuery('.popup').is(":visible")) {
							jQuery('.popup-wrapper').removeClass('show');
							Cookies.set('popup_1','value', { expires: 30 });
						} else {
							if ($target.closest('.popup__close').length) {
								jQuery('.popup-wrapper').removeClass('show');
								Cookies.set('popup_1','value', { expires: 30 });
							}
						}
					});
					jQuery('body').on('click', '.form-close-btn,.form__close', function(e) {
						e.stopPropagation();
						jQuery('.form-wrapper').removeClass('show');
						Cookies.set('popup_1','value', { expires: 30 });
					});
				});

jQuery(document).ready(function ($) {
                jQuery('body').on('click', '.form-close-btn,.form__close', function(e) {
                    e.stopPropagation();
                    jQuery('.form-wrapper').removeClass('show');
                });
                FormSubmit();
                function FormSubmit()
                {
                    $('form.newsletter-form').submit(function(e) {
                        e.preventDefault();
                        $('[name=save_form]').prop('disabled', true);
                        var flag = true;
                        var form = $(this);
                        $('.newsletter-form .invalid').remove();
                        $(".newsletter-form .form-group>*").removeClass('is-invalid');
                        var count_subject = 0;
                        $(".newsletter-form input[name ='subject[]']").each(function() {
                            if($(this).attr('type') == 'checkbox')
                            {
                                if($(".newsletter-form input[name ='subject[]']").is(':checked'))
                                {
                                    count_subject++;
                                }
                            }
                        
                        });
                        if(!count_subject)
                        {
                            flag = false;
                            $(".newsletter-form input[name ='subject[]']").addClass('is-invalid');
                            $(".newsletter-form input[name ='subject[]']").parent().append('<span class="invalid">'+$("input[name ='subject[]']").attr('data-missing-error')+'</span>');
                        }
                        if(!$(".newsletter-form input[name ='email']").val())
                        {
                            flag = false;
                            $(".newsletter-form input[name ='email']").addClass('is-invalid');
                            $(".newsletter-form input[name ='email']").parent().append('<span class="invalid">'+$("input[name ='email']").attr('data-missing-error')+'</span>');
                        }
                        else if(!isEmail($(".newsletter-form input[name ='email']").val()))
                        {
                            flag = false;
                            $(".newsletter-form input[name ='email']").addClass('is-invalid');
                            $(".newsletter-form input[name ='email']").parent().append('<span class="invalid">'+$("input[name ='email']").attr('data-format-error')+'</span>');
                        }
                    
                        if(flag)
                        {
                            var formData = form.serialize();
                            jQuery.ajax({
                                url: 'https://www.greenfeed.com.vn/wp-admin/admin-ajax.php',
                                type: "POST",
                                data: formData,
                                dataType: "json",
                                beforeSend: function (response) {
                                    jQuery('.loading').addClass('show');
                                },
                                success: function (json_data) {
                                    if(json_data && json_data.status)
                                    {
                                            $('.form-wrapper.show .form').empty();
                                            $('.form-wrapper.show .form').append(json_data.php);
                                            
                                    }
                                    jQuery('.loading').removeClass('show');
                                    $('.newsletter-form [name=save_form]').prop('disabled', false);
                                },
                            });
                        }
                        else
                        {
                            $('.newsletter-form input.is-invalid,textarea.is-invalid').first().focus();
                            $('.newsletter-form [name=save_form]').prop('disabled', false);
                        }
                    });

                    function isEmail(email) {
                        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                        return regex.test(email);
                    }
                    function isPhone(phone)
                    {
                        phone = phone.replace(/[^0-9]/g,'');
                        if (phone.length < 10 || phone.length > 11)
                        {
                            return false;
                        }
                        else
                        {
                            return true;
                        }
                    }
                    jQuery('body').on('input','.form-group input',function(){
                        jQuery(this).removeClass('is-invalid');
                        jQuery(this).parent().children('.invalid').remove();
                        jQuery(this).parent().removeClass('success');
                        if($(this).val().length > 3)
                        {
                            if($(this).attr('name') == 'phone')
                            {
                                if(isPhone($(this).val()))
                                {
                                    $(this).parent().addClass('success');
                                }
                            }
                            else if($(this).attr('name') == 'email')
                            {
                                if(isEmail($(this).val()))
                                {
                                    $(this).parent().addClass('success');
                                }
                            }
                            else
                            {
                                $(this).parent().addClass('success');
                            }
                            
                        }
                    });
                }
                rise_label();
                function rise_label()
                {
                    jQuery(".rise-label input, .rise-label textarea").focusin(function(){
                        jQuery(this).parent().addClass('active');
                    }).focusout(function(){
                        if(!jQuery(this).val())
                        {
                            jQuery(this).parent().removeClass('active');
                        }
                    });
                   
                }
                jQuery('a[href^="#newsletter"]').on('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        $this = $(this);
                        if(jQuery(e.target).closest('.cta__close').length)
                        {
                            $this.removeClass('show');
                        }
                        else
                        {
                            if($this.hasClass('circle-cta') && !window.matchMedia("(max-width: 1023px)").matches)
                            {
                                $this.removeClass('show');
                                $this.removeClass('circle-cta').addClass('show');
                                setTimeout(function(){
                                    $this.addClass('circle-cta');
                                }, 15000);
                            }
                            else
                            {
                                $('.form-wrapper[data-trigger="#newsletter"]').addClass('show');
                                var line = $('.form-wrapper[data-trigger="#newsletter"]').find('.form-line').php();
                                $('.form-wrapper[data-trigger="#newsletter"]').find('.form-line').empty().append(line);
                                if($this.hasClass('cta-btn'))
                                {
                                    $this.removeClass('show');
                                }
                            }
                        }
                    });
            });


jQuery(document).ready(function ($) {
                var temp_minipopup = '<div class="mini-popup"> <span class="close-btn mini-popup__close"><img width="10" height="10" src="https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/close.svg" alt="Close"></span> <div class="mini-popup__content">{{content}}</div> </div>';
                $demand = $('#demand').selectize({
                    onInitialize: function () {
                        $('#demand').next().find('div.selectize-input > input').prop('disabled', 'disabled');
                    },
                    onDropdownOpen:  function(value)
                    {
                        //remove disbale option
                        var s = this;
                        $.each(this.options, function (e) {
                        if($(this)[0].disabled)
                        {
                            s.removeOption($(this)[0].text);
                        }
                        });
                        //clear default value
                        if(this.getValue() && this.options[this.getValue()].disabled == true)
                        {
                            this.clear(); 
                        }
                    },
                    onChange: function(value) {
                        if(value.toLowerCase() == 'đặt hàng' || value.toLowerCase() == 'order')
                        {
                            $('.cooperate-form #product')[0].selectize.clear();
                            $('.cooperate-form  #product').parent().removeClass('success');
                            $('.cooperate-form  #product').parent().addClass('hideexport');
                        }
                        else
                        {
                            $('.cooperate-form  #product').parent().removeClass('hideexport');
                        }
                    }
                });
                $product = $('.cooperate-form  #product').selectize({
                     onInitialize: function() {
                        this.$control_input.attr('readonly', true);
                    },
                    onDropdownOpen:  function(value)
                    {
                        var s = this;
                        $.each(this.options, function (e) {
                            if($(this)[0].disabled)
                            {
                                s.removeOption($(this)[0].text);
                            }
                        });
                        if(this.getValue() && this.options[this.getValue()].disabled == true)
                        {
                            this.clear(); 
                        }
                    },
                    onChange: function(value) {
                        var s = this;
                        var demand = $('#demand')[0].selectize.getValue();
                        if((demand.toLowerCase() == 'đặt hàng' || demand.toLowerCase() == 'order') &&(value.toLowerCase() == 'g kitchen' || value.toLowerCase() == 'mamachoice' || value.toLowerCase() == 'wyn'))
                        {
                            jQuery.ajax({
                                url: 'https://www.greenfeed.com.vn/wp-admin/admin-ajax.php',
                                type: "POST",
                                data: { action: "food_notes", food: value, security: jQuery('[name=dt_nonce]').val() },
                                dataType: "html",
                                success: function (response) {
                                if(response)
                                {
                                        var html = temp_minipopup;
                                        html = html.replace("{{content}}", response);
                                        $('body').append(html).addClass('minipopup-show');
                                        s.clear();
                                        $('.cooperate-form #product').parent().removeClass('success');
                                        //Show placehoder when deselect
                                }
                                },
                            });
                        }
                        
                    }
                });
                
                 $country = $('.form-wrapper[data-trigger="#cooperate"] #country').selectize({
                    persist: false,
                    create: false,
                    onInitialize: function () {
                        this.$control_input.attr('readonly', true);
                        var s = this;
                        this.revertSettings.$children.each(function () {
                            $.extend(s.options[this.value], $(this).data());
                        });
                    },
                    onDropdownOpen: function(value)
                    {
                        var s = this;
                        $.each(this.options, function (e) {
                        if($(this)[0].disabled)
                        {
                                s.removeOption($(this)[0].text);
                        }
                        });
                        if(this.getValue() && this.options[this.getValue()].$order == 1)
                        {
                            this.clear(); 
                        }
                    },
                    onChange: function(value) {
                        if (!value.length) return;
                        var option = this.options[value];
                       district.disable();
                       district.clearOptions(); 
                       province.disable(); 
                       province.clearOptions();  
                       $('.cooperate-form #province').parent().removeClass('success');
                       $('.cooperate-form #district').parent().removeClass('success');

                        jQuery.ajax({
                            url: 'https://www.greenfeed.com.vn/wp-admin/admin-ajax.php',
                            type: "POST",
                            data: { action: "province_by_country", country: option.id, security: jQuery('[name=dt_nonce]').val() },
                            dataType: "json",
                            success: function (json_data) {
                                console.log(json_data);
                                
                                if(json_data)
                                {
                                    province.clearOptions();
                                    province.load(function(callback) {
                                        province.enable();
                                        callback(json_data);
                                    }); 
                                    
                                }
                            },
                        });
                        //scroll2bottom
                        if ($('.form-wrapper[data-trigger="#cooperate"] .form').length)
                        {
                            $('.form-wrapper .form').animate({
                                scrollTop: $('.form-wrapper[data-trigger="#cooperate"] .form').get(0).scrollHeight
                            },100,'linear'); 
                        }
                        
                    },
                    score: function (search)
                    {
                        return function (option)
                        {
                            search = removeVietnameseTones(search.toLowerCase());
                            var option_value = removeVietnameseTones(option.text.toLowerCase());
                            if (option_value.indexOf(search) > -1)
                            {
                                return 1;
                            }
                            return 0;
                        }
                    },
                    
                });


                $province = $('.form-wrapper[data-trigger="#cooperate"] #province').selectize({
                    // persist: false,
                    // create: false,
                    // Template với data-id
                    render: {
                        option: function(item, escape) {
                            return '<div class="option" data-id="' + escape(item.id) + '">' +
                                '<span class="province-name">' + escape(item.text) + '</span>' +
                                (item.code ? '' : '') +
                                '</div>';
                        },
                        item: function(item, escape) {
                            return '<div class="item" data-id="' + escape(item.id) + '">' +
                                escape(item.text) +
                                '</div>';
                        }
                    },
                    onInitialize: function () {
                        this.$control_input.attr('readonly', true);
                        var s = this;
                        this.revertSettings.$children.each(function () {
                            $.extend(s.options[this.value], $(this).data());
                        });
                    },
                    onDropdownOpen: function(value)
                    {
                        var s = this;
                        $.each(this.options, function (e) {
                        if($(this)[0].disabled)
                        {
                                s.removeOption($(this)[0].text);
                        }
                        });
                        if(this.getValue() && this.options[this.getValue()].$order == 1)
                        {
                            this.clear(); 
                        }
                    },
                    onChange: function(value) {
                        if (!value.length) return;
                        var option = this.options[value];
                        // district.disable();
                        // district.clearOptions();  
                        var selectedCountry = country.getValue();
                        var selectedOptionCountry = country.options[selectedCountry];
                        var countryId = selectedOptionCountry.id;
                         $('.cooperate-form #district').parent().removeClass('success');
                    
                        console.log('country: '+countryId);
                        
                        jQuery.ajax({
                            url: 'https://www.greenfeed.com.vn/wp-admin/admin-ajax.php',
                            type: "POST",
                            data: { action: "district_by_province", province: option.id, country: countryId, security: jQuery('[name=dt_nonce]').val() },
                            dataType: "json",
                            success: function (json_data) {
                               
                                if(json_data)
                                {
                                    district.clearOptions();
                                    district.load(function(callback) {
                                        district.enable();
                                        callback(json_data);
                                    }); 
                                    
                                }
                            },
                        });
                        //scroll2bottom
                        if ($('.form-wrapper[data-trigger="#cooperate"] .form').length)
                        {
                            $('.form-wrapper .form').animate({
                                scrollTop: $('.form-wrapper[data-trigger="#cooperate"] .form').get(0).scrollHeight
                            },100,'linear'); 
                        }
                        
                    },
                    score: function (search)
                    {
                        return function (option)
                        {
                            search = removeVietnameseTones(search.toLowerCase());
                            var option_value = removeVietnameseTones(option.text.toLowerCase());
                            if (option_value.indexOf(search) > -1)
                            {
                                return 1;
                            }
                            return 0;
                        }
                    },
                    
                });
                $district = $('.form-wrapper[data-trigger="#cooperate"] #district').selectize({
                     onInitialize: function() {
                        this.$control_input.attr('readonly', true);
                    },
                    onDropdownOpen:  function(value)
                    {
                    var s = this;
                        $.each(this.options, function (e) {
                        if($(this)[0].disabled)
                        {
                            s.removeOption($(this)[0].text);
                        }
                        });
                    },
                });
                var district  = $district[0].selectize;
                var province = $province[0].selectize;
                var country = $country[0].selectize;
                district.disable();

                function removeVietnameseTones(str) {
                    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a"); 
                    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e"); 
                    str = str.replace(/ì|í|ị|ỉ|ĩ/g,"i"); 
                    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o"); 
                    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u"); 
                    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y"); 
                    str = str.replace(/đ/g,"d");
                    str = str.replace(/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, "A");
                    str = str.replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, "E");
                    str = str.replace(/Ì|Í|Ị|Ỉ|Ĩ/g, "I");
                    str = str.replace(/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g, "O");
                    str = str.replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g, "U");
                    str = str.replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g, "Y");
                    str = str.replace(/Đ/g, "D");
                    // Một vài bộ encode coi các dấu mũ, dấu chữ như một kí tự riêng biệt nên thêm hai dòng này
                    str = str.replace(/\u0300|\u0301|\u0303|\u0309|\u0323/g, ""); // ̀ ́ ̃ ̉ ̣  huyền, sắc, ngã, hỏi, nặng
                    str = str.replace(/\u02C6|\u0306|\u031B/g, ""); // ˆ ̆ ̛  Â, Ê, Ă, Ơ, Ư
                    // Remove extra spaces
                    // Bỏ các khoảng trắng liền nhau
                    str = str.replace(/ + /g," ");
                    str = str.trim();
                    // Remove punctuations
                    // Bỏ dấu câu, kí tự đặc biệt
                    str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'|\"|\&|\#|\[|\]|~|\$|_|`|-|{|}|\||\\/g," ");
                    return str;
                }

                jQuery('body').on('click', '.form-close-btn,.form__close', function(e) {
                    e.stopPropagation();
                    jQuery('.form-wrapper').removeClass('show');
                });
                jQuery('body').on('click', '.mini-popup', function(e) {
                    e.stopPropagation();
                });
                jQuery('body').on('click', '.mini-popup__close', function(e) {
                    e.stopPropagation();
                    $('.mini-popup').remove();
                    $('body').removeClass('minipopup-show');
                });
                jQuery('body').on('click', '.scrollbot-btn', function(e) {
                    $('.form-wrapper.show .form').animate({
                        scrollTop: $('.form-wrapper.show[data-trigger="#cooperate"] .form').get(0).scrollHeight
                    },100,'linear'); 
                    
                });

                ScrollArrow();
                function ScrollArrow()
                {
                    $('.form').scroll(function() {
                        if($(this).scrollTop() + $(this).outerHeight() < $(this).get(0).scrollHeight - 60)
                        {
                            $('.scrollbot-btn').fadeIn('faster');
                            $('.scrollbot-btn').css('top',get_rem_value($(this).scrollTop() + $(this).outerHeight()) - 2.5 +'rem');
                        }
                        else
                        {
                            $('.scrollbot-btn').fadeOut('faster');
                        }
                        
                    });
                }
                function get_rem_value(px)
                {
                    return px/parseFloat(jQuery('html').css('font-size'));
                }
                function isPhone(phone)
                    {
                        phone = phone.replace(/[^0-9]/g,'');
                        if (phone.length < 10 || phone.length > 11)
                        {
                            return false;
                        }
                        else
                        {
                            return true;
                        }
                    }
                    FormSubmit();
                    function FormSubmit()
                    {
                        $('form.cooperate-form').submit(function(e) {
                            e.preventDefault();
                            $('[name=save_form]').prop('disabled', true);
                            var flag = true;
                            var form = $(this);
                            $('.cooperate-form .invalid').remove();
                            $(".cooperate-form .form-group>*").removeClass('is-invalid');

                            $(".cooperate-form input[name ='fullname'],.cooperate-form input[name ='privacy_policy'],.cooperate-form .select-group select").each(function() {
                                if($(this).attr('type') == 'checkbox')
                                {
                                    if(!$(this).is(':checked'))
                                    {
                                        flag = false;
                                        $(this).addClass('is-invalid');
                                        $(this).parent().append('<span class="invalid">'+$(this).attr('data-missing-error')+'</span>');
                                    }
                                }
                                else if($(this).prop("tagName").toLowerCase() == 'select')
                                {
                                    if(!$(this).val() || $(this).val() == $(this).attr('placeholder'))
                                    {
                                        flag = false;
                                        $(this).addClass('is-invalid');
                                        $(this).parent().append('<span class="invalid">'+$(this).attr('data-missing-error')+'</span>');
                                    }
                                }
                                else
                                {
                                    if(!$(this).val() || $(this).val().length < 3)
                                    {
                                        flag = false;
                                        $(this).addClass('is-invalid');
                                        $(this).parent().append('<span class="invalid">'+$(this).attr('data-missing-error')+'</span>');
                                    }
                                }
                            });
                            if(!$(".cooperate-form input[name ='phone']").val())
                            {
                                flag = false;
                                $(".cooperate-form input[name ='phone']").addClass('is-invalid');
                                $(".cooperate-form input[name ='phone']").parent().append('<span class="invalid">'+$("input[name ='phone']").attr('data-missing-error')+'</span>');
                            }
                            else if(!isPhone($(".cooperate-form input[name ='phone']").val()))
                            {
                                flag = false;
                                $(".cooperate-form input[name ='phone']").addClass('is-invalid');
                                $(".cooperate-form input[name ='phone']").parent().append('<span class="invalid">'+$("input[name ='phone']").attr('data-format-error')+'</span>');
                            }
                            if(!$(".cooperate-form input[name ='email']").val())
                            {
                                flag = false;
                                $(".cooperate-form input[name ='email']").addClass('is-invalid');
                                $(".cooperate-form input[name ='email']").parent().append('<span class="invalid">'+$("input[name ='email']").attr('data-missing-error')+'</span>');
                            }
                            else if(!isEmail($(".cooperate-form input[name ='email']").val()))
                            {
                                flag = false;
                                $(".cooperate-form input[name ='email']").addClass('is-invalid');
                                $(".cooperate-form input[name ='email']").parent().append('<span class="invalid">'+$("input[name ='email']").attr('data-format-error')+'</span>');
                            }
                        
                            if(flag)
                            {
                                                                var formData = form.serialize();
                                formData = formData+"&SubmitPlatform=Website&SourceMedium=" + 'Unknown'+"&current_url="+window.location.href+"&current_title=Công ty Cổ phần MGF Việt Nam";
                                jQuery.ajax({
                                    url: 'https://www.greenfeed.com.vn/wp-admin/admin-ajax.php',
                                    type: "POST",
                                    data: formData,
                                    dataType: "json",
                                    beforeSend: function (response) {
                                        jQuery('.loading').addClass('show');
                                    },
                                    success: function (json_data) {
                                        if(json_data && json_data.status)
                                        {

                                            //Add2GSheet(form.serializeObject());
                                            Add2Manychat(formData);
                                            if($('body').hasClass('page-template-cooperate-form'))
                                            {
                                                $('.coopform .form-wrapper .form').empty();
                                                $('.coopform .form-wrapper .form').append(json_data.php);
                                            }
                                            else
                                            {
                                                $('.form-wrapper.show .form').empty();
                                                $('.form-wrapper.show .form').append(json_data.php);
                                            }
                                           
                                            // dataLayer.push({'event': '05b.orip.success'});
                                            // fbq('track', "CompleteRegistration");
                                        }
                                        jQuery('.loading').removeClass('show');
                                        $('.cooperate-form [name=save_form]').prop('disabled', false);
                                    },
                                });
                            }
                            else
                            {
                                $('.cooperate-form input.is-invalid,textarea.is-invalid').first().focus();
                                $('.cooperate-form [name=save_form]').prop('disabled', false);
                            }
                        
                        });
                        $.fn.serializeObject = function()
                        {
                        var o = {};
                        var a = this.serializeArray();
                        $.each(a, function() {
                            if (o[this.name]) {
                                if (!o[this.name].push) {
                                    o[this.name] = [o[this.name]];
                                }
                                o[this.name].push(this.value || '');
                            } else {
                                o[this.name] = this.value || '';
                            }
                        });
                        return o;
                        };
                    function Add2GSheet(data)
                    {
                                                var url = 'https://script.google.com/macros/s/AKfycbzdK0YTQOHPFhoTSb9B7kn5jUHWlSBli98HxtTNpdCvbmJ5eVdDZ-L8RADFe49VP6jmjQ/exec';
                        $.ajax({
                            url: url,
                            method: "GET",
                            dataType: "json",
                            data: {
                                'STT' : '',
                                'Tên' :  data.fullname,
                                'SĐT' :  data.phone,
                                'Khu vực' :  data.district+' '+data.province,
                                'Quan tâm' :  data.demand,
                                'Danh mục SP' :  data.product,
                                'Nội dung' :  data.messenge,
                                'Ngày liên hệ fanpage' :  '2025-11-01 13:00:06',
                                'Status' :  'chờ gọi',
                                'Submit Platform' :  'Website', 
                                'Source Medium' : 'Unknown'
                            },
                            success: function (response) {
                
                            },
                        });
                    }
                    function Add2Manychat(data)
                    {
                        jQuery.ajax({
                            url: 'https://www.greenfeed.com.vn/fb_chatbot_alert/sale-regis-alert-sales.php', 
                            type: "POST",
                            data: data,
                            dataType: "json",
                            success: function (json_data) {
                            
                            },
                        });
                    }
                    function isEmail(email) {
                        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                        return regex.test(email);
                    }
                    function isPhone(phone)
                    {
                        phone = phone.replace(/[^0-9]/g,'');
                        if (phone.length < 10 || phone.length > 11)
                        {
                            return false;
                        }
                        else
                        {
                            return true;
                        }
                    }
                    jQuery('body').on('input','.form-group input',function(){
                        jQuery(this).removeClass('is-invalid');
                        jQuery(this).parent().children('.invalid').remove();
                        jQuery(this).parent().removeClass('success');
                        if($(this).val().length > 3)
                        {
                            if($(this).attr('name') == 'phone')
                            {
                                if(isPhone($(this).val()))
                                {
                                    $(this).parent().addClass('success');
                                }
                            }
                            else if($(this).attr('name') == 'email')
                            {
                                if(isEmail($(this).val()))
                                {
                                    $(this).parent().addClass('success');
                                }
                            }
                            else
                            {
                                $(this).parent().addClass('success');
                            }
                            
                        }
                        
                    });
                    jQuery('body').on('change','.form-group select',function(){
                        jQuery(this).removeClass('is-invalid');
                        jQuery(this).parent().children('.invalid').remove();
                        if($(this).val() && $(this).val() != $(this).attr('placeholder'))
                        {
                            $(this).parent().addClass('success');
                        }
                    });
                }
                rise_label();
                function rise_label()
                {
                    jQuery(".rise-label input, .rise-label textarea").focusin(function(){
                        jQuery(this).parent().addClass('active');
                    }).focusout(function(){
                        if(!jQuery(this).val())
                        {
                            jQuery(this).parent().removeClass('active');
                        }
                    });
                }
                jQuery('a[href^="#cooperate"]').on('click', function(e) {
                    e.preventDefault();
                        e.stopPropagation();
                        $this = $(this);
                        if(jQuery(e.target).closest('.cta__close').length)
                        {
                            $this.removeClass('show');
                        }
                        else
                        {
                            if($this.hasClass('circle-cta') && !window.matchMedia("(max-width: 1023px)").matches)
                            {
                                $this.removeClass('show');
                                $this.removeClass('circle-cta').addClass('show');
                                setTimeout(function(){
                                    $this.addClass('circle-cta');
                                }, 15000);
                            }
                            else
                            {
                                $('.form-wrapper[data-trigger="#cooperate"]').addClass('show');
                                var line = $('.form-wrapper[data-trigger="#cooperate"]').find('.form-line').php();
                                $('.form-wrapper[data-trigger="#cooperate"]').find('.form-line').empty().append(line);
                                if($this.hasClass('cta-btn'))
                                {
                                    $this.removeClass('show');
                                }
                                /* set default val */
                                if($('.g3f-tabs__navs').length)
                                {
                                    var s = $product[0].selectize;
                                    var val = $('.g3f-tabs__navs').find('.btn.active').attr('href').replace('#', '');
                                    val = removeVietnameseTones(val.toLowerCase().replace("-", " "));
                                    $.each(s.options, function (e) {
                                    if(removeVietnameseTones($(this)[0].text.toLowerCase()) == val)
                                    {
                                            $product[0].selectize.setValue($(this)[0].text);
                                    }
                                    });
                                }
                                                                if ($(".form-wrapper.show .form").outerHeight() < ($(".form-wrapper.show .form-content").height() + 80) ) {
                                    if(!$(".form-wrapper.show .form .scrollbot-btn").length)
                                    {
                                        $(".form-wrapper.show .form").append('<div class="scrollbot-btn"><span class="nav-arrow arrow-1"></span> <span class="nav-arrow arrow-2"></span> <span class="nav-arrow arrow-3"></span></div>');
                                        $('.scrollbot-btn').css('top',get_rem_value($(".form-wrapper.show .form").scrollTop() + $(".form-wrapper.show .form").outerHeight()) - 2.5 +'rem');
                                    }   
                                }
                            }
                        }
                        
                    });
            });



jQuery(document).ready(function ($) {
                jQuery('body').on('click', '.form-close-btn,.form__close', function(e) {
                    e.stopPropagation();
                    jQuery('.form-wrapper').removeClass('show');
                });
                MoveEle();
                function MoveEle()
                {
                    if(!$('.site-main').children('.form-wrapper[data-trigger="#contact"]').length)
                    {
                        var html = $('.form-wrapper[data-trigger="#contact"]').prop('outerHTML');
                        $('.form-wrapper[data-trigger="#contact"]').remove();
                        $('.site-main').append(html);
                    }
                }
                FormSubmit();
                function FormSubmit()
                {
                    $('form.contact-form:not(.reception_form):not(.contact_form_2)').submit(function(e) {
                        e.preventDefault();
                        $('[name=save_form]').prop('disabled', true);
                        var flag = true;
                        var form = $(this);
                        $('.contact-form:not(.reception_form):not(.contact_form_2) .invalid').remove();
                        $(".contact-form:not(.reception_form):not(.contact_form_2) .form-group>*").removeClass('is-invalid');

                        $(".contact-form:not(.reception_form):not(.contact_form_2) input[name ='fullname'],.contact-form:not(.reception_form):not(.contact_form_2) input[name ='privacy_policy'],.contact-form:not(.reception_form):not(.contact_form_2) #messenge").each(function() {
                            if($(this).attr('type') == 'checkbox')
                            {
                                if(!$(this).is(':checked'))
                                {
                                    flag = false;
                                    $(this).addClass('is-invalid');
                                    $(this).parent().append('<span class="invalid">'+$(this).attr('data-missing-error')+'</span>');
                                }
                            }
                            else if($(this).prop("tagName").toLowerCase() == 'select')
                            {
                                if(!$(this).val() || $(this).val() == $(this).attr('placeholder'))
                                {
                                    flag = false;
                                    $(this).addClass('is-invalid');
                                    $(this).parent().append('<span class="invalid">'+$(this).attr('data-missing-error')+'</span>');
                                }
                            }
                            else
                            {
                                if(!$(this).val() || $(this).val().length < 3)
                                {
                                    flag = false;
                                    $(this).addClass('is-invalid');
                                    $(this).parent().append('<span class="invalid">'+$(this).attr('data-missing-error')+'</span>');
                                }
                            }
                        });
                        if(!$(".contact-form:not(.reception_form):not(.contact_form_2) input[name ='phone']").val())
                        {
                            flag = false;
                            $(".contact-form:not(.reception_form):not(.contact_form_2) input[name ='phone']").addClass('is-invalid');
                            $(".contact-form:not(.reception_form):not(.contact_form_2) input[name ='phone']").parent().append('<span class="invalid">'+$("input[name ='phone']").attr('data-missing-error')+'</span>');
                        }
                        else if(!isPhone($(".contact-form:not(.reception_form):not(.contact_form_2) input[name ='phone']").val()))
                        {
                            flag = false;
                            $(".contact-form:not(.reception_form):not(.contact_form_2) input[name ='phone']").addClass('is-invalid');
                            $(".contact-form:not(.reception_form):not(.contact_form_2) input[name ='phone']").parent().append('<span class="invalid">'+$("input[name ='phone']").attr('data-format-error')+'</span>');
                        }
                        if(!$(".contact-form:not(.reception_form):not(.contact_form_2) input[name ='email']").val())
                        {
                            flag = false;
                            $(".contact-form:not(.reception_form):not(.contact_form_2) input[name ='email']").addClass('is-invalid');
                            $(".contact-form:not(.reception_form):not(.contact_form_2) input[name ='email']").parent().append('<span class="invalid">'+$("input[name ='email']").attr('data-missing-error')+'</span>');
                        }
                        else if(!isEmail($(".contact-form:not(.reception_form):not(.contact_form_2) input[name ='email']").val()))
                        {
                            flag = false;
                            $(".contact-form:not(.reception_form):not(.contact_form_2) input[name ='email']").addClass('is-invalid');
                            $(".contact-form:not(.reception_form):not(.contact_form_2) input[name ='email']").parent().append('<span class="invalid">'+$("input[name ='email']").attr('data-format-error')+'</span>');
                        }
                       
                        if(flag)
                        {
                            var formData = form.serialize();
                            jQuery.ajax({
                                url: 'https://www.greenfeed.com.vn/wp-admin/admin-ajax.php',
                                type: "POST",
                                data: formData,
                                dataType: "json",
                                beforeSend: function (response) {
                                    jQuery('.loading').addClass('show');
                                },
                                success: function (json_data) {
                                    if(json_data && json_data.status)
                                    {
                                            $('.form-wrapper.show .form').empty();
                                            $('.form-wrapper.show .form').append(json_data.php);
                                            dataLayer.push({'event': '06c.cps'});
                                    }
                                    jQuery('.loading').removeClass('show');
                                    $('.contact-form:not(.reception_form):not(.contact_form_2) [name=save_form]').prop('disabled', false);
                                },
                            });
                        }
                        else
                        {
                            $('.contact-form:not(.reception_form):not(.contact_form_2) input.is-invalid,textarea.is-invalid').first().focus();
                            $('.contact-form:not(.reception_form):not(.contact_form_2) [name=save_form]').prop('disabled', false);
                        }
                    
                    });

                    function isEmail(email) {
                        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                        return regex.test(email);
                    }

                    function isPhone(phone)
                    {
                        phone = phone.replace(/[^0-9]/g,'');
                        if (phone.length < 10 || phone.length > 11)
                        {
                            return false;
                        }
                        else
                        {
                            return true;
                        }
                    }
                    jQuery('body').on('input','.form-group input',function(){
                        jQuery(this).removeClass('is-invalid');
                        jQuery(this).parent().children('.invalid').remove();
                        jQuery(this).parent().removeClass('success');
                        if($(this).val().length > 3)
                        {
                            if($(this).attr('name') == 'phone')
                            {
                                if(isPhone($(this).val()))
                                {
                                    $(this).parent().addClass('success');
                                }
                            }
                            else if($(this).attr('name') == 'email')
                            {
                                if(isEmail($(this).val()))
                                {
                                    $(this).parent().addClass('success');
                                }
                            }
                            else
                            {
                                $(this).parent().addClass('success');
                            }
                            
                        }
                    });
                }
                rise_label();
                function rise_label()
                {
                    jQuery(".rise-label input, .rise-label textarea").focusin(function(){
                        jQuery(this).parent().addClass('active');
                    }).focusout(function(){
                        if(!jQuery(this).val())
                        {
                            jQuery(this).parent().removeClass('active');
                        }
                    });
                   
                }
                jQuery('a[href^="#contact"]').on('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        $this = $(this);
                        if(jQuery(e.target).closest('.cta__close').length)
                        {
                            $this.removeClass('show');
                        }
                        else
                        {
                            if($this.hasClass('circle-cta') && !window.matchMedia("(max-width: 1023px)").matches)
                            {
                                $this.removeClass('show');
                                $this.removeClass('circle-cta').addClass('show');
                                setTimeout(function(){
                                    $this.addClass('circle-cta');
                                }, 15000);
                            }
                            else
                            {
                                $('.form-wrapper[data-trigger="#contact"]').addClass('show');
                                var line = $('.form-wrapper[data-trigger="#contact"]').find('.form-line').php();
                                $('.form-wrapper[data-trigger="#contact"]').find('.form-line').empty().append(line);
                                if($this.hasClass('cta-btn'))
                                {
                                    $this.removeClass('show');
                                }
                            }
                        }
                    });

                    $provincecf = $('.form-wrapper[data-trigger="#contact"] #province').selectize({
                    persist: false,
                    create: false,
                    onInitialize: function () {
                        //this.$control_input.attr('readonly', true);
                        var s = this;
                        this.revertSettings.$children.each(function () {
                            $.extend(s.options[this.value], $(this).data());
                        });
                    },
                    onDropdownOpen: function(value)
                    {
                        var s = this;
                        $.each(this.options, function (e) {
                        if($(this)[0].disabled)
                        {
                                s.removeOption($(this)[0].text);
                        }
                        });
                        if(this.getValue() && this.options[this.getValue()].$order == 1)
                        {
                            this.clear(); 
                        }
                    },
                    onChange: function(value) {
                        if (!value.length) return;
                        var option = this.options[value];
                        // district.disable();
                        // district.clearOptions();       
                        jQuery.ajax({
                            url: 'https://www.greenfeed.com.vn/wp-admin/admin-ajax.php',
                            type: "POST",
                            data: { action: "district_by_province", province: option.id, security: jQuery('[name=dt_nonce]').val() },
                            dataType: "json",
                            success: function (json_data) {
                               
                                if(json_data)
                                {
                                    
                                    districtcf.clearOptions();
                                    districtcf.load(function(callback) {
                                       
                                        districtcf.enable();
                                        callback(json_data);
                                    }); 
                                    
                                }
                            },
                        });
                        //scroll2bottom
                        if ($('.form-wrapper[data-trigger="#contact"] .form').length)
                        {
                            $('.form-wrapper.show .form').animate({
                                scrollTop: $('.form-wrapper[data-trigger="#contact"] .form').get(0).scrollHeight
                            },100,'linear'); 
                        }
                        
                    },
                    score: function (search)
                    {
                        return function (option)
                        {
                            search = removeVietnameseTones(search.toLowerCase());
                            var option_value = removeVietnameseTones(option.text.toLowerCase());
                            if (option_value.indexOf(search) > -1)
                            {
                                return 1;
                            }
                            return 0;
                        }
                    },
                    
                });
                $districtcf = $('.form-wrapper[data-trigger="#contact"] #district').selectize({
                     onInitialize: function() {
                        //this.$control_input.attr('readonly', true);
                    },
                    onDropdownOpen:  function(value)
                    {
                    var s = this;
                        $.each(this.options, function (e) {
                        if($(this)[0].disabled)
                        {
                            s.removeOption($(this)[0].text);
                        }
                        });
                    },
                });
                districtcf  = $districtcf[0].selectize;
                provincecf = $provincecf[0].selectize;
                districtcf.disable();
            });


jQuery.event.special.touchstart = { setup: function( _, ns, handle ) { this.addEventListener('touchstart', handle, { passive: !ns.includes('noPreventDefault') }); } }; jQuery.event.special.touchmove = { setup: function( _, ns, handle ) { this.addEventListener('touchmove', handle, { passive: !ns.includes('noPreventDefault') }); } };
                    jQuery(function($) {
            MainMenu();
            // SearchBox();
            Mobile_Nav();
            Sticky_Header();
            UserAgent();
            if(window.matchMedia("(max-width: 1023px)").matches)
            {
                FooterMenu();
            }
            function MainMenu()
            {
                jQuery('.dt-main-menu #primary > li.dropdown ').on("mouseenter", function() {
                    jQuery('.dt-primary-menu').addClass('open-submenu');
                    if($(this).hasClass('menu-item-4574') || $(this).hasClass('menu-item-6310'))
                        jQuery('.header-main').addClass('open-submenu');
                }).on("mouseleave", function() {
                    jQuery('.dt-primary-menu').removeClass('open-submenu');
                    jQuery('.header-main').removeClass('open-submenu');
                });
}

function Sticky_Header() {
    let LastScrollPos = 0;
    let ticking = false;

    function onScroll() {
        if (!ticking) {
            window.requestAnimationFrame(updateStickyHeader);
            ticking = true;
        }
    }

    function updateStickyHeader() {
        let offset = $('#dt-header').offset();
        if (!offset) return;

        let trigger_point = offset.top + $(window).height();
        let trigger_point_header = offset.top + $('#dt-header').height();
        let ScollPos = $(document).scrollTop();

        
            if (ScollPos < LastScrollPos && !$(".dt-toc").hasClass('expand')) {
                if (ScollPos >= 1)
                {
                    if (!$('body').hasClass('sticky-header')) {
                        $('body').addClass('sticky-header').removeClass('sticky-header-down');
                        $('.home .header-main').removeClass('header-transition');
                    }
                }
                else
                {
                    $('body').removeClass('sticky-header sticky-header-down');
                }
                
            } else {
                    if (ScollPos >= trigger_point_header) {
                        if (!$('body').hasClass('sticky-header-down')) {
                        $('body').removeClass('sticky-header').addClass('sticky-header-down');
                        $('body').removeClass('offcanvas-active');
                        $('.dt-main-menu .dt-dropdown-menu-wrapper').removeClass('active');
                    }
                } 
                else 
                {
                    $('body').removeClass('sticky-header sticky-header-down');
                }
                
            }
        

        if (ScollPos >= trigger_point) {
            if (ScollPos < LastScrollPos) {
                if (!$('body').hasClass('sticky')) {
                    $('body').addClass('sticky').removeClass('sticky-down');
                    
                }
            } else {
                if (!$('body').hasClass('sticky-down')) {
                    $('body').removeClass('sticky').addClass('sticky-down');
                    
                }
            }
        } else {
            $('body').removeClass('sticky sticky-down');
        }

        LastScrollPos = ScollPos;
        ticking = false;
    }

    $(window).on('scroll', onScroll);
}

function Mobile_Nav() 
{
    jQuery(document).on("click", ".offcanvas-menu", function (event) {
        event.stopPropagation();
        event.preventDefault();
        jQuery("body").toggleClass('offcanvas-active');
        $('.dt-main-menu').find('.dt-dropdown-menu-wrapper').removeClass('active');
    });

    jQuery(document).click(function (event) {
        $target = jQuery(event.target);
        if (!$target.closest('.dt-main-menu').length && jQuery('.dt-main-menu').is(":visible")) {
            jQuery('body').removeClass('offcanvas-active');
            $('.dt-main-menu').find('.dt-dropdown-menu-wrapper').removeClass('active');
        } else {
            if ($target.closest('.offcanvas-close').length) {
            jQuery('body').removeClass('offcanvas-active');
            $('.dt-main-menu').find('.dt-dropdown-menu-wrapper').removeClass('active');
            }

        }
    });

    $('.dt-main-menu .menu-item .dt-dropdown-menu-wrapper').each(function(index, value){
        $(this).append('<span class="back">Trở lại</span>')
    });

    jQuery('.dt-primary-menu li > a > .caret').on('click', function(e) {
        e.preventDefault();
        $(this).parent().siblings('.dt-dropdown-menu-wrapper').addClass('active');
    });
    jQuery('.dt-primary-menu .back').on('click', function(e) {
        e.preventDefault();
        $(this).parent().removeClass('active');
    });
    // jQuery('.dt-primary-menu li > a > .caret').on('click', function(e) {
    //     e.preventDefault();
    //     $(this).parent().siblings('.dt-dropdown-menu-wrapper').addClass('active');
    // });
}
            
function FooterMenu()
{
    jQuery('.footer-menu > .dropdown > a').on('click', function(e) {
        e.preventDefault();
        jQuery(this).parent().toggleClass('expanded');
    });
}
            
function UserAgent()
{
    if(navigator.userAgent.match(/iPhone/)) {
        $('html').addClass('iphone');
    }
    else if(navigator.userAgent.match(/iPad/i))
    {
        $('html').addClass('ipad');
    }
    else if(navigator.userAgent.indexOf('Mac OS X') != -1) {
        $("html").addClass("macos");
    }
    if(navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1)
    {
        $("html").addClass("safari");
    }
    
}

            if($('.breadcrumb').length && window.matchMedia("(max-width: 1023px)").matches)
            {
                const $container = $('.dt-breadscrumb');
                const $scroll = $('.breadcrumb');

                function updateMask() {
                    const scrollLeft = $scroll.scrollLeft();
                    const maxScroll = $scroll[0].scrollWidth - $scroll[0].clientWidth;
                    const leftFade = scrollLeft > 5 ? 'transparent' : 'black';
                    const rightFade = scrollLeft < maxScroll - 5 ? 'transparent' : 'black';

                    const maskValue = `linear-gradient(to right, ${leftFade} 0%, black 20%, black 70%, ${rightFade} 100%)`;

                    $container.css({
                        '-webkit-mask-image': maskValue,
                        'mask-image': maskValue
                    });
                }

                $scroll.on('scroll', updateMask);
                $(window).on('resize', updateMask);
                updateMask();
            }
            
            // if($('.menu-top-bar-container').length && window.matchMedia("(max-width: 1023px)").matches)
            // {
            //     const $container = $('.menu-top-bar-container');
            //     const $scroll = $('.dt-secondary-menu');
            //     $container.append('<div class="prev"><span class="m_scroll_arrows unu"></span> <span class="m_scroll_arrows doi"></span> <span class="m_scroll_arrows trei"></span></div><div class="next"><span class="m_scroll_arrows unu"></span> <span class="m_scroll_arrows doi"></span> <span class="m_scroll_arrows trei"></span></div>');
            //     function showTopbarArrow() {
            //         const scrollLeft = $scroll.scrollLeft();
            //         const maxScroll = $scroll[0].scrollWidth - $scroll[0].clientWidth;
            //         if(scrollLeft < maxScroll - 5) //scroll sang phải
            //         {
            //            $container.find('.prev').fadeOut();
            //             $container.find('.next').fadeIn();
                        
            //         }
            //         else
            //         {
                        
            //             $container.find('.prev').fadeIn();
            //             $container.find('.next').fadeOut();
            //         }
                    
            //     }

            //     jQuery('body').on('click', '.menu-top-bar-container .next' ,function(e) {
            //         e.preventDefault();
            //         $scroll.animate({
            //             scrollLeft: $scroll[0].scrollWidth - $scroll[0].clientWidth
            //         }, 500);
            //     });

            //     jQuery('body').on('click', '.menu-top-bar-container .prev' ,function(e) {
            //         e.preventDefault();
            //         $scroll.animate({
            //             scrollLeft: 0
            //         }, 500);
            //     });

            //     $scroll.on('scroll', showTopbarArrow);
            //     $(window).on('resize', showTopbarArrow);
            //     showTopbarArrow();
            // }

            setTimeout(function() { 
                scrollToHash()
            }, 0);
            function scrollToHash()
            {
                
                const hash = window.location.hash;
                if (hash && $(hash).length) {
                    gsap.to(window, {
                    duration: 1.5,
                    scrollTo: {
                        y: $(hash), 
                        offsetY: 100 
                    },
                   ease: "back.out(1.4)",
             
                    });
                }
                
            }
            CLinkWithHash();
            function CLinkWithHash()
            {
                $("a").each(function() {
                    const href = $(this).attr("href");
                    const baseUrl = location.href.replace(location.hash, "");
                    if (typeof href === "string" && href.includes("#") && href.indexOf(baseUrl) >= 0) {
                    $(this).addClass("clinkhash");
                    }
                });
                $('.clinkhash').on('click', function(e) 
                {
                    var url = $(this).attr("href");
                    var tabid = $(this).attr("href").substring(url.indexOf('#'));
                    if ($(tabid).length) {
                        gsap.to(window, {
                            duration: 1.5,
                            scrollTo: {
                            y: $(tabid),
                            offsetY: 100
                            },
                           ease: "back.out(1.4)",
                            
                        });
                        }
                });
            }
            //Counter
            // if($(".counter").length)
            //     $(".counter").countimator();

            //
            jQuery(document).on('mouseenter', '.brands__content li,.sidebar-category__item ', function () {
                    var $this = jQuery(this);
                    gsap.to(this, 0.5, {
                        x: 5,
                        overwrite: "all",
                        ease: Back.easeOut });

                }).on('mouseleave', '.brands__content li,.sidebar-category__item ', function () {
                    gsap.to(this, 0.5, {
                        x: 0,
                        overwrite: "all",
                        ease: Back.easeOut });
            });

            if($('.news').length )
            {
                var newsSection = new gsap.timeline({paused:true});
                ScrollTrigger.create({
                    trigger: '.news',
                    start: 'top 75%',
                    onEnter: newsSectionAni,
                // markers: true
                });
                function newsSectionAni()
                {
                    newsSection.play();
                    
                }
                const gallerys = gsap.utils.toArray('.news__main,.news__list');
                gallerys.forEach((icon, i) => {
                    newsSection.add(
                        gsap.fromTo(icon, 
                        {   alpha:0,
                            y:50,
                        }, {
                            duration:.75, 
                            alpha:1,
                            y:0,
                            ease: 'power4.easeOut',
                        }),
                        
                    "-=.25"); 
                });
            
            }
            
            function getCookie(name) {
                var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
                return match ? match[2] : null;
            }

            function setCookie(name, value, days) {
                var expires = "";
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    expires = "; expires=" + date.toUTCString();
                }
                document.cookie = name + "=" + value + "; path=/" + expires;
            }

          
                if (!getCookie("cookieConsent")) {
                    setTimeout(function() {
                        $("#cookiePopup").addClass("show"); 
                    }, 2000);
                }

                $("#acceptCookie").click(function() {
                    setCookie("cookieConsent", "accepted", 365);
                    $("#cookiePopup").removeClass("show"); 
                    (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                    })(window,document,'script','dataLayer','GTM-P3CNJCZ');
                });

                $("#rejectCookie").click(function() {
                    setCookie("cookieConsent", "rejected", 365);
                    $("#cookiePopup").removeClass("show");
                });
            
        });
        function showpage() {
            const el = document.querySelector('body');
            el.classList.remove("fade-in");
        }
        document.addEventListener("DOMContentLoaded", showpage);
        /**
         * @fileoverview dragscroll - scroll area by dragging
         * @license MIT, see http://github.com/asvd/dragscroll
         */
        (function(root,factory){if(typeof define==='function'&&define.amd){define(['exports'],factory)}else if(typeof exports!=='undefined'){factory(exports)}else{factory((root.dragscroll={}))}}(this,function(exports){var _window=window;var _document=document;var mousemove='mousemove';var mouseup='mouseup';var mousedown='mousedown';var EventListener='EventListener';var addEventListener='add'+EventListener;var removeEventListener='remove'+EventListener;var newScrollX,newScrollY;var dragged=[];var reset=function(i,el){for(i=0;i<dragged.length;){el=dragged[i++];el=el.container||el;el[removeEventListener](mousedown,el.md,0);_window[removeEventListener](mouseup,el.mu,0);_window[removeEventListener](mousemove,el.mm,0)}
        dragged=[].slice.call(_document.getElementsByClassName('dragscroll'));for(i=0;i<dragged.length;){(function(el,lastClientX,lastClientY,pushed,scroller,cont){(cont=el.container||el)[addEventListener](mousedown,cont.md=function(e){if(!el.hasAttribute('nochilddrag')||_document.elementFromPoint(e.pageX,e.pageY)==cont){pushed=1;lastClientX=e.clientX;lastClientY=e.clientY;e.preventDefault()}},0);_window[addEventListener](mouseup,cont.mu=function(){pushed=0},0);_window[addEventListener](mousemove,cont.mm=function(e){if(pushed){(scroller=el.scroller||el).scrollLeft-=newScrollX=(-lastClientX+(lastClientX=e.clientX));scroller.scrollTop-=newScrollY=(-lastClientY+(lastClientY=e.clientY));if(el==_document.body){(scroller=_document.documentElement).scrollLeft-=newScrollX;scroller.scrollTop-=newScrollY}}},0)})(dragged[i++])}}
        if(_document.readyState=='complete'){reset()}else{_window[addEventListener]('load',reset,0)}
        exports.reset=reset}))


        jQuery(document).ready(function ($) {

            var flag_enter = false;
            var $removetransition, $removetransparent;
            $removetransparent = setTimeout(function() { 
                $('.home .header-main').addClass('header-transparent header-transition');
                $removetransition = setTimeout(function() { 
                    if(!flag_enter)
                        $('.home .header-main').removeClass('header-transition');
                    }, 3000);
            }, 5000);
            
           
            jQuery(document).on('mouseover', '.header-main', function () {
                    flag_enter = true;
                    clearTimeout($removetransition);
                    clearTimeout($removetransparent);
                    $('.home .header-main').removeClass('header-transparent header-transition');

                }).on('mouseleave', '.header-main', function () {
                    flag_enter = false;
                    $('.home .header-main').addClass('header-transparent header-transition');
                    $removetransition = setTimeout(function() { 
                        if(!flag_enter)
                            $('.home .header-main').removeClass('header-transition');
                    }, 3000);
            });
            
            if($('.brands').length)
            {
                var trigger = 'top center';
                if(window.matchMedia("(max-width: 1023px)").matches)
                    ttSectionAni();
                var ttSection = new gsap.timeline({paused:true});
                ScrollTrigger.create({
                    trigger: '.brands',
                    start: trigger,
                    onEnter: ttSectionAni,
                // markers: true
                });
                function ttSectionAni()
                {
                    ttSection.play();
                    
                }
                const gallerys = gsap.utils.toArray('.brands-inner>div');
                gallerys.forEach((icon, i) => {
                    ttSection.add(
                        gsap.fromTo(icon, 
                        {   alpha:0,
                            y:50,
                        }, {
                            duration:.5, 
                            alpha:1,
                            delay:.25,
                            y:0,
                            ease: 'power4.easeOut',
                        }),
                        
                    "=-.25"); 
                });
            
            }

            BrandSection();
            function BrandSection()
            {
                var BrandTL = new gsap.timeline({paused:true});
                ScrollTrigger.create({
                    trigger: '.brands',
                    start: 'top center',
                    onEnter: BrandAni,
                });
                function BrandAni()
                {
                    //BrandTL.play();
                    BrandTL.timeScale(1.875).play();
                }
              

                gsap.set('#g3f,#cb1,#cb2,#cb3,#cb15,#cb25,#cb35,#cb12,#cb13,#cb14,#cb22,#cb23,#cb24,#cb25,#cb32,#cb33,#cb34,#cb2c', {
                    scale:'0',
                    alpha:0,
                    transformOrigin: "center",
                });

                MorphSVGPlugin.convertToPath("#linefood,#linefarm,#linefeed"); 

                gsap.set('#linefood,#linefarm,#linefeed', {
                    alpha:0,
                    drawSVG:"0% 0%",autoAlpha:1
                    //transformOrigin: "center bottom",
                    
                });

                gsap.set('#food,#farm,#feed', {
                    alpha:0,
                    x:-20,
                });

                var g3f = gsap.to('#g3f',1, {
                    scale:1,
                    alpha:1,
                    transformOrigin: "center",
                    ease: 'power4.easeOut',
                
                });
                BrandTL.add(g3f,0);


                var cb1 = gsap.to('#cb1',.75, {
                    scale:1,
                    alpha:1,
                    transformOrigin: "center",
                    ease: Back.easeOut
                
                });
                
                BrandTL.add(cb1,"+=0");

                var e1 = gsap.to('#cb12,#cb13',.5, {
                        scale:1,
                        alpha:1,
                        ease: Back.easeOut
                    });
                BrandTL.add(e1, ">");
                var e1 = gsap.to('#cb14,#cb15',.5, {
                        scale:1,
                        alpha:1,
                        ease: Back.easeOut
                    });
                BrandTL.add(e1, ">");

                var linefeed = gsap.to('#linefeed',.75, {
                    alpha:1,
                    drawSVG:"100%",
                    ease: Back.easeOut
                });

                var feed = gsap.to('#feed',.75, {
                    alpha:1,
                    x:0,
                    ease: Back.easeOut
                });

                BrandTL.add(linefeed,"+=0");
                BrandTL.add(feed,"+=0");

               

                var cb3 = gsap.to('#cb3',.75, {
                    scale:1,
                    alpha:1,
                    transformOrigin: "center",
                    ease: Back.easeOut
                
                });

                BrandTL.add(cb3,"+=0");

                var e1 = gsap.to('#cb32,#cb33',.5, {
                        scale:1,
                        alpha:1,
                        ease: Back.easeOut
                    });
                BrandTL.add(e1, ">");
                var e1 = gsap.to('#cb34,#cb35',.5, {
                        scale:1,
                        alpha:1,
                        ease: Back.easeOut
                    });
                BrandTL.add(e1, ">");
                
                var linefarm = gsap.to('#linefarm',.75, {
                    alpha:1,
                    drawSVG:"-100%",
                    ease: Back.easeOut
                });

                var farm = gsap.to('#farm',.75, {
                    alpha:1,
                    x:0,
                    ease: Back.easeOut
                });

                BrandTL.add(linefarm,"+=0");
                BrandTL.add(farm,"+=0");
                
                var cb2 = gsap.to('#cb2',.75, {
                    scale:1,
                    alpha:1,
                    transformOrigin: "center",
                    ease: Back.easeOut
                
                });

                BrandTL.add(cb2,"+=0");

                var e1 = gsap.to('#cb22,#cb23',.5, {
                        scale:1,
                        alpha:1,
                        ease: Back.easeOut
                    });
                BrandTL.add(e1, ">");
                var e1 = gsap.to('#cb24,#cb25',.5, {
                        scale:1,
                        alpha:1,
                        ease: Back.easeOut
                    });
                BrandTL.add(e1, ">");

                
                var linefood = gsap.to('#linefood',.75, {
                    alpha:1,
                    drawSVG:"-100%",
                    ease: Back.easeOut
                });

                var food = gsap.to('#food',.75, {
                    alpha:1,
                    x:0,
                    ease: Back.easeOut
                });

                BrandTL.add(linefood,"+=0");
                BrandTL.add(food,"+=0");

                var cb2c = gsap.fromTo('#cb2c',{   
                    alpha:0,
                    scale:.875,
                }, {
                    duration:  1,
                    scale:1,
                    alpha:1,
                    transformOrigin: "center",
                    ease: 'power4.easeOut',
                   onComplete () {
                        Balloon();
                    }
                
                });
                var cb2cr = gsap.to('#cb2c',5, {
                    rotation: 360, 
                    repeat: -1,
                    ease: 'none',

                });

                
                BrandTL.add(cb2c,"+=0");
                BrandTL.add(cb2cr,"+=0");
                
                function Random(min,max) {return min+Math.random()*(max-min)};
                function Balloon() 
                {
                    var balloons = new gsap.timeline({repeat: -1});
                    const titles = gsap.utils.toArray('#cb15,#cb35,#cb251,#cb252,#cb253');
                    titles.forEach((title, i) => {
                        balloons.to(title, 
                        {
                            duration:  5,
                            transformOrigin: '50% 50%',
                            y: Random(-7,7),
                            x: Random(-7,7),
                            scale:1.1,
                            ease: 'power4.easeOut',
                        },"+=5").to(title, 
                        {
                            duration:  5,
                            y: 0,
                            x: 0,
                            scale:1,
                            ease: 'power4.easeOut',
                        });
                    })
                }
                
                return BrandTL;
            }
        });
jQuery(document).ready(function ($) {

            $('a[href="#product"]').click(function(e) {
                e.preventDefault(); // Ngăn chặn cuộn mặc định
                let targetOffset = $("#product").offset().top - 220;
                gsap.to(window, { duration: 1.5, scrollTo: targetOffset, ease: Back.easeOut });
            });

            ProductCarouselInit();
            var owl;
            function ProductCarouselInit()
            {
                owl = jQuery('.products-carousel').owlCarousel({
                   nav:true,
                    navText:["<div class='nav-btn prev-nav '><img width='28' height='28' src='https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/arr-next2.svg' alt='Prev'></div>","<div class='nav-btn next-nav '><img width='28' height='28' src='https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/arr-next2.svg' alt='Next'></div>"],
                    dots:false,
                    loop:false,
                    margin:20,
                    stagePadding:0,
                    items:4,
                    smartSpeed:450,
                    autoplay: false,
                    //autoplayTimeout: 10000, 
                    autoplayHoverPause: true,
                    responsive:{
                        0:{
                            items:1,
                            nav:false,
                            dots:true,
                            margin:12,
                            stagePadding:50,
                        },
                        600:{
                            stagePadding:0,
                            items:2,
                        },
                        1024:{
                            items:4,
                            stagePadding:40,
                        }
                    },
                    // onInitialized  : slidecounter,
                    onTranslated: checkDirection 
                });
            }
           var restartTimeout;
            function checkDirection(event) {
               
                var count = event.item.count; // Tổng số item
                var itemsPerPage = event.page.size; // Số item trên mỗi trang
                var currentPage = event.item.index; // Trang hiện tại (bắt đầu từ 0)
                var totalPages = Math.ceil(count / itemsPerPage); // Tổng số trang (bắt đầu từ 0)
                if(window.matchMedia("(max-width: 1023px)").matches)
                    totalPages--;

                clearTimeout(restartTimeout);
                
                if (currentPage >= totalPages) {
                    restartTimeout = setTimeout(function(){
                        jQuery('.products-carousel').trigger("to.owl.carousel", [0, 500]); // Quay về trang đầu tiên trong 0.5s
                    }, 5000); // Chờ 5 giây rồi quay lại
                }
            }

            var dropsSection = new gsap.timeline({paused:true,onComplete () { changeflagDrops(); }});
            var valueSection = new gsap.timeline({paused:true});
            ScrollTrigger.create({
                trigger: '.product-section',
                start: 'top center',
                onEnter: valueSectionAni,
            });
            function valueSectionAni()
            {
                jQuery('.products-carousel').trigger('play.owl.autoplay', [5000]);

                valueSection.play();
                setTimeout(function() { 
                    dropsSection.play();
                }, 200);
            }

            const gallerys = gsap.utils.toArray('.product-section .product-item');
            gallerys.forEach((icon, i) => {
                valueSection.add(
                    gsap.fromTo(icon, 
                    {   alpha:0,
                        y:50,
                    }, {
                        duration:.75, 
                        alpha:1,
                        y:0,
                        ease: 'power4.easeOut',
                    }),
                    
                "-=.35"); 
            });
           
           var flag_drop = false;
           function changeflagDrops()
            {
                flag_drop = true;
            }
            const drops = gsap.utils.toArray('.product-section .product-item .b0');
          
            drops.forEach((icon, i) => {
                dropsSection.add(
                    gsap.to(icon, 
                    {
                       duration: .55, 
                       morphSVG:"#b1"+(i)+"", 
                        ease: 'power4.easeOut',
                    }),
                    
                "-=.25"); 
            });


            $(".product-item").each(function(i, el) {
                var tl = new gsap.timeline({paused: true});
                var ele_child = $(el).find('.b0')[0];
                tl.to(ele_child, { duration: .375, morphSVG:"#b2"+(i)+"", ease: 'power4.easeOut',});
                el.animation = tl;
                $(el).on("mouseenter",function(){
                   if(flag_drop)
                    this.animation.play();
                }).on("mouseleave",function(){
                    if(flag_drop)
                    this.animation.reverse();
                });
                
            });
        });



jQuery(document).ready(function ($) {
                jQuery('.clients-list').owlCarousel({
                    nav:false,
                    navText:["<div class='nav-btn prev-nav '><img width='28' height='28' src='https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/arr-next2.svg' alt='Prev'></div>","<div class='nav-btn next-nav '><img width='28' height='28' src='https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/arr-next2.svg' alt='Next'></div>"],
                    dots:true,
                    items:3,
                    smartSpeed:450,
                    responsive:{
                        0:{
                            items:2,
                            margin:16,
                            // center:true,
                        },
                          600:{
                           
                            items:4,
                        },
                        1024:{
                            items:6,
                            margin:30,
                            dots:false,
                            loop:false, 
                            mouseDrag:false,
                            touchDrag:false,
                        }
                    },
                });

                    if($('.clients').length)
                    {
                        var ttSection = new gsap.timeline({paused:true});
                        ScrollTrigger.create({
                            trigger: '.clients',
                            start: 'top center',
                            onEnter: ttSectionAni,
                        // markers: true
                        });
                        function ttSectionAni()
                        {
                            ttSection.play();
                            
                        }
                        const gallerys = gsap.utils.toArray('.client-item');
                        gallerys.forEach((icon, i) => {
                            ttSection.add(
                                gsap.fromTo(icon, 
                                {   alpha:0,
                                    y:50,
                                }, {
                                    duration:.5, 
                                    alpha:1,
                                    delay:.25,
                                    y:0,
                                    ease: 'power4.easeOut',
                                }),
                                
                            "=-.425"); 
                        });
                    
                    }
            });

jQuery(document).ready(function ($) {
    if($('.newsletter-section').length) {
        var newsletterSection = new gsap.timeline({paused:true});
        ScrollTrigger.create({
            trigger: '.newsletter-section',
            start: 'top center',
            onEnter: newsletterSectionAni,
        // markers: true
        });
        function newsletterSectionAni()
        {
            newsletterSection.play();
            
        }
        const gallerys = gsap.utils.toArray('.newsletter-section-inner>div');
        gallerys.forEach((icon, i) => {
            newsletterSection.add(
                gsap.fromTo(icon, 
                {   alpha:0,
                    y:50,
                }, {
                    duration:.5, 
                    alpha:1,
                    y:0,
                    ease: 'power4.easeOut',
                }),
                
            "-=.25"); 
        });

    }
});


jQuery(document).ready(function ($) {
    jQuery('.banner-carousel').owlCarousel({
        items:1,
        nav:false,
        navText:["<div class='nav-btn prev-nav '></div>","<div class='nav-btn next-nav '></div>"],
        dots:false,
        loop:true,
        mouseDrag:false,
        autoplay:true,
        autoplayTimeout:8000,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
    });
});


        jQuery(document).ready(function ($) {

                    var autoplay = false;
                    if(window.matchMedia("(max-width: 1023px)").matches)
                        autoplay = true;
                    $('[data-fancybox]').fancybox({
                        fullScreen: {
                            autoStart: autoplay
                        },

                        // Set `touch: false` to disable panning/swiping
                        touch: {
                            vertical: true, // Allow to drag content vertically
                            momentum: true // Continue movement after releasing mouse/touch when panning
                        },

                        video: {
                            tpl:
                            '<video class="fancybox-video fancybox-fullscreen" controls controlsList="nodownload">' +
                            '<source src="{{src}}" type="{{format}}" />' +
                            'Sorry, your browser doesn\'t support embedded videos, <a href="{{src}}">download</a> and watch with your favorite video player!' +
                            "</video>",
                            format: "", // custom video format
                            autoStart: true
                        },
                    });
                });