
        jQuery(document).ready(function ($) {
            if($('.otherindustry-section').length)
            {
                var newsletterSection = new gsap.timeline({paused:true});
                ScrollTrigger.create({
                    trigger: '.otherindustry-section',
                    start: 'top 75%',
                    onEnter: newsletterSectionAni,
                // markers: true
                });
                function newsletterSectionAni()
                {
                    newsletterSection.play();
                    
                }
                const gallerys = gsap.utils.toArray('.otherindustry__item');
                gallerys.forEach((icon, i) => {
                    newsletterSection.add(
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
        });
        


        
        jQuery(document).ready(function ($) {
            jQuery('[data-fancybox="gallery"]').fancybox({
                autoSize : true,
                fitToView : true,
                animationEffect : 'zoom-in-out',
                transitionEffect: "fade",
                
            });

            $('.branch__image-carousel').each(function(index, value){
            
                $carousel =  jQuery(this);
                var loop = false;
                if($carousel.find('img').length > 1)
                    loop = true;
                $carousel.owlCarousel({
                    nav:false,
                    dots:true,
                    items:1,
                    loop:loop,
                    smartSpeed:450,
                    autoplay:true,
                    autoplayTimeout:5000,
                    onInitialized  : equalizeOwlItemHeights,
                });

                function equalizeOwlItemHeights(event) {
                
                    let maxHeight = 0;
                const $owl = jQuery(event.target);
                    
                    $owl.find('.owl-item').each(function () {
                    
                        let itemHeight = $(this).outerHeight();
                        console.log(itemHeight);
                        if (itemHeight > maxHeight) maxHeight = itemHeight;
                    });
                    $owl.find('.owl-item').css('height', maxHeight + 'px');
                }
            });

        

            

            $('.award-list').each(function(index, value){
                jQuery(this).owlCarousel({
                    nav:true,
                    navText:["<div class='nav-btn prev-nav '><img width='28' height='28' src='https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/arr-next2.svg' alt='Prev'></div>","<div class='nav-btn next-nav '><img width='28' height='28' src='https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/arr-next2.svg' alt='Next'></div>"],
                    dots:false,
                    items:1,
                    smartSpeed:450,
                    responsive:{
                        0:{
                            items:3,
                            margin:16,
                            stagePadding:0,
                            // center:true,
                            dots:true,
                            nav:false,
                        },
                        1024:{
                            items:4,
                            margin:16,
                            dots:false,
                            loop:false, 
                            mouseDrag:false,
                            touchDrag:false,
                        }
                    },
                });
            });
            

            if($('.supporting-section').length)
            {
                var newsletterSection = new gsap.timeline({paused:true});
                ScrollTrigger.create({
                    trigger: '.supporting-section',
                    start: 'top 75%',
                    onEnter: newsletterSectionAni,
                // markers: true
                });
                function newsletterSectionAni()
                {
                    newsletterSection.play();
                    
                }
                const gallerys = gsap.utils.toArray('.supporting__item');
                gallerys.forEach((icon, i) => {
                    newsletterSection.add(
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

            if($('.branch-section').length)
            {
                $('.branch-section').each(function ()
                {
                    var section = $(this);
                    var branchSection = new gsap.timeline({paused:true});
                    ScrollTrigger.create({
                        trigger: section,
                        start: 'top 75%',
                        onEnter: function () {
                            branchSection.play(); // Kích hoạt hoạt ảnh
                        },
                        // markers: true
                    });
                    
                    branchSection.add(
                        gsap.fromTo(section.find('.branch__image'), 
                        {   alpha:0,
                            x:(section.hasClass('swap')) ? 50 : -50,
                        }, {
                            duration:.75, 
                            alpha:1,
                            x:0,
                            ease: 'power4.easeOut',
                        }),
                        
                    "0"); 
                    branchSection.add(
                        gsap.fromTo(section.find('.branch__contents'), 
                        {   alpha:0,
                            x:(section.hasClass('swap')) ? -50 : 50,
                        }, {
                            duration:.75, 
                            alpha:1,
                            x:0,
                            ease: 'power4.easeOut',
                        }),
                        
                    "-=.25"); 
                });
                
            }
        });
        