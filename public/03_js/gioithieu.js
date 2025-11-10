
jQuery(document).ready(function ($) {
    if($('.philosophy-section').length)
    {
        var newsletterSection = new gsap.timeline({paused:true});
        ScrollTrigger.create({
            trigger: '.philosophy-section',
            start: 'top 75%',
            onEnter: newsletterSectionAni,
        // markers: true
        });
        function newsletterSectionAni()
        {
            newsletterSection.play();
            
        }
        const gallerys = gsap.utils.toArray('.philosophy-inner>div');
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
if($('.brands').length)
    {
        var ttSection = new gsap.timeline({paused:true});
        ScrollTrigger.create({
            trigger: '.brands',
            start: 'top 75%',
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
            start: 'top 75%',
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
        if($('.mision-section').length)
        {
            var newsletterSection = new gsap.timeline({paused:true});
            ScrollTrigger.create({
                trigger: '.mision-section',
                start: 'top 75%',
                onEnter: newsletterSectionAni,
            // markers: true
            });
            function newsletterSectionAni()
            {
                newsletterSection.play();
                
            }
            const gallerys = gsap.utils.toArray('.mision-row');
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

            newsletterSection.add(
                gsap.from(".value-item", {
                    scale: 0,       
                    opacity: 0,      
                    duration: 1,    
                    stagger: {
                        amount: 1.5,   
                        each: 0.1,     
                        from: "start"
                    },
                    ease: "back.out(1.25)" 
                })
            ,"+=0"); 

            newsletterSection.add(
                gsap.from(".light-1", {
                    x: -50,       
                    opacity: 0,      
                   
                    duration:.75, 
                    ease: 'power4.easeOut',
                })
            ,"+=0"); 
        }

    });
    


    
     jQuery(document).ready(function ($) {
        if($('.culture-section').length)
        {
            var newsletterSection = new gsap.timeline({paused:true});
            ScrollTrigger.create({
                trigger: '.culture-section',
                start: 'top 75%',
                onEnter: newsletterSectionAni,
            // markers: true
            });
            function newsletterSectionAni()
            {
                newsletterSection.play();
                
            }
            const gallerys = gsap.utils.toArray('.culture-inner>div');
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
        

            newsletterSection.add(
                gsap.from(".culture__behavior", {
                    scale: 0,       
                    opacity: 0,      
                    duration: 1,    
                    stagger: {
                        amount: 1.5,   
                        each: 0.1,     
                        from: "start"
                    },
                    ease: "back.out(1.25)" 
                })
            ,"+=0"); 

        }

    });
    

     jQuery(document).ready(function($){
          
            jQuery('.program-list').owlCarousel({
                nav:true,
                navText:["<div class='nav-btn prev-nav '><img width='28' height='28' src='https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/arr-next2.svg' alt='Prev'></div>","<div class='nav-btn next-nav '><img width='28' height='28' src='https://www.greenfeed.com.vn/wp-content/themes/greenfeed/assets/images/arr-next2.svg' alt='Next'></div>"],
                dots:false,
                items:1,
                smartSpeed:450,
                center:true,
                startPosition: Math.floor($(".owl-carousel .item").length / 2),
                responsive:{
                    0:{
                        items:1,
                        margin:16,
                        stagePadding:0,
                        center:true,
                        dots:true,
                        mouseDrag:true,
                        touchDrag:true,
                    },
                    1024:{
                        items:3,
                        margin:40,
                        dots:false,
                        loop:false, 
                        mouseDrag:false,
                        touchDrag:false,
                    }
                },
            });
           

            if($('.program').length )
            {
                var commitSection = new gsap.timeline({paused:true});
                ScrollTrigger.create({
                    trigger: '.program',
                    start: 'top 75%',
                    onEnter: commitSectionAni,
                // markers: true
                });
                function commitSectionAni()
                {
                    commitSection.play();
                    
                }
                commitSection.add(
                        gsap.fromTo('.program-item', 
                        {   alpha:0,
                            y:50,
                        }, {
                            duration:.75, 
                            alpha:1,
                            y:0,
                            ease: 'power4.easeOut',
                }),"-=.25"); 
                        
                
            }
    });

// SVG Animation on Scroll - Copied from trangchu.js
jQuery(document).ready(function ($) {
    // Function to check if element is in viewport
    function isElementInViewport(el) {
        var rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    // Function to check if element is partially in viewport
    function isElementPartiallyInViewport(el) {
        var rect = el.getBoundingClientRect();
        var windowHeight = (window.innerHeight || document.documentElement.clientHeight);
        var windowWidth = (window.innerWidth || document.documentElement.clientWidth);
        
        var vertInView = (rect.top <= windowHeight) && ((rect.top + rect.height) >= 0);
        var horInView = (rect.left <= windowWidth) && ((rect.left + rect.width) >= 0);
        
        return (vertInView && horInView);
    }

    // Function to handle scroll
    function handleScroll() {
        var brandsImages = $('.brands__images');
        
        if (brandsImages.length > 0) {
            brandsImages.each(function() {
                if (isElementPartiallyInViewport(this) && !$(this).hasClass('animate-in')) {
                    $(this).addClass('animate-in');
                }
            });
        }
    }

    // Run on scroll
    $(window).on('scroll', handleScroll);
    
    // Run on page load
    handleScroll();
});