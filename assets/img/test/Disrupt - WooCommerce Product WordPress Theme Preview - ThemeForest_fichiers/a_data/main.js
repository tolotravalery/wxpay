/**
 * Created by createit on 09.05.2017.
 */

/*------------------------------------------------------------------
 Project: Disrupt
 Version: 1.0
 Last change: 12.06.2017
 -------------------------------------------------------------------*/
/*------------------------------------------------------------------

 [Table of contents]
 // 1. Helpers
 // 2. Main function
 // -- Basics
 // -- Navigation
 // -- Kenburns
 // -- Newsletter contact form
 // -- Navbar
 // -- Css animate
 // -- Media Sections
 // -- Contact form [add to Cart]
 // -- IconBox Stepper
 // -- Product Preview
 // -- Woo Gallery
 // -- Search Link

 -------------------------------------------------------------------*/


// Helpers //-----------------------------

var addClass, device_height, device_width, el_body, el_html, el_wrapper, getCookie, parseBoolean, setCookie, set_background, set_font_size, set_height, set_text_color, validatedata;

device_width = window.innerWidth > 0 ? window.innerWidth : screen.width;


device_height = window.innerHeight > 0 ? window.innerHeight : screen.height;

el_html = jQuery('html');

el_body = jQuery('body');

el_wrapper = jQuery('.ct-js-wrapper');


validatedata = function (attr, def) {
    if (attr !== void 0) {
        return attr;
    }
    return def;
};

parseBoolean = function (attr, def) {
    if (attr === 'true') {
        return true;
    } else if (attr === 'false') {
        return false;
    }
    return def;
};

setCookie = function (cname, cvalue, exdays) {
    var d, expires;
    if (exdays !== 'default') {
        d = new Date;
        d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
        expires = 'expires=' + d.toUTCString();
        document.cookie = cname + '=' + cvalue + '; ' + expires;
    } else {
        document.cookie = cname + '=' + cvalue;
    }
};

getCookie = function (cname) {
    var c, ca, i, name;
    name = cname + '=';
    ca = document.cookie.split(';');
    i = 0;
    while (i < ca.length) {
        c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length);
        }
        i++;
    }
    return '';
};

addClass = function (element) {
    if (element.hasClass('active')) {
        element.removeClass('active');
    } else {
        element.addClass('active');
    }
};

set_background = function () {
    if (jQuery('[data-background]').length > 0) {
        return jQuery('[data-background]').each(function () {
            var background, backgroundmobile, that;
            that = jQuery(this);
            background = jQuery(this).attr('data-background');
            backgroundmobile = jQuery(this).attr('data-background-mobile');
            if (that.attr('data-background').substr(0, 1) === '#') {
                that.css('background-color', background);
            } else if (that.attr('data-background-mobile') && device.mobile()) {
                that.css('background-image', 'url(' + backgroundmobile + ')');
            } else {
                that.css('background-image', 'url(' + background + ')');
            }
        });
    }
};


set_text_color = function () {
    if (jQuery('[data-color]').length > 0) {
        return jQuery('[data-color]').each(function () {
            var that;
            that = jQuery(this);
            that.css('color', that.attr('data-color'));
        });
    }
};

set_font_size = function () {
    if (jQuery('[data-font-size]').length > 0) {
        return $('[data-font-size]').each(function () {
            var that;
            that = $(this);
            that.css('font-size', that.attr('data-font-size') + 'px');
        });
    }
};

set_height = function () {
    if (jQuery('[data-height]').length > 0) {
        return jQuery('[data-height]').each(function () {
            var height, that;
            that = jQuery(this);
            height = that.attr('data-height');
            if (height.indexOf('%') > -1) {
                that.css('min-height', device_height * parseInt(height, 10) / 100);
            } else {
                that.css('min-height', parseInt(height, 10) + 'px');
            }
        });
    }
};



jQuery(document).ready(function ($) {

    // Basics //-----------------------------

    /* Text Color */
    set_text_color();

    /* Font Size */
    set_font_size();

    /* Background Color */
    set_background();

    /* Height */
    set_height();

    /* Microsoft Smooth Scroll Disabler */
    var url;
    if (navigator.userAgent.match(/Trident\/7\./)) {
        $('body').on('mousewheel', function () {
            event.preventDefault();
            window.scrollTo(0, window.pageYOffset - event.wheelDelta / 1.5);
        });
    }

    /* Mobile class to bidy */
    if (el_body.hasClass('navigation-wide') && device_width <= 991){
        el_body.addClass('ct-mobile');
    } else if (!el_body.hasClass('navigation-wide') && device_width <= 600){
        el_body.addClass('ct-mobile');
    }

    /* Browsers */
    if ($.browser.mozilla) {
        el_html.addClass('browser-mozilla');
    }
    if ($.browser.msie) {
        el_html.addClass('browser-msie');
    }
    if ($.browser.webkit) {
        el_html.addClass('browser-webkit');
    }
    if ($.browser.safari) {
        el_html.addClass('browser-safari');
    }

    /* Tooltips */
    $('[data-toggle="tooltip"]').tooltip();

    // Smartphone or beacon padding fix

    if($('.navbar').hasClass('navbar-top') && !$('header.ct-header').length){
        el_body.addClass('ct-navbar-fix');
    }else if($('.navbar').hasClass('navbar-dark') && $('.navbar').hasClass('navbar-fixed') && !$('header.ct-header').length){

        el_body.addClass('ct-navbar-fix');
    }

    // Navigation //-----------------------------

    if (!device.mobile() && !device.tablet()){
        var $navigation = $('#navigation-vertical');
        if ($navigation.length > 0){
            var $sections = $('section');
            var $navigationElement = $('#navigation-vertical ul');
            $sections.each(function(){
                var $this = $(this);
                var $id = $this.attr('id');
                if ($id !== undefined){
                    $navigationElement.append('<li> <a href="#' + $id +'" data-scroll="#' + $id + '"></a></li>')
                }
            });

            /*Scrollspy*/

            $('body').scrollspy({
                target: '#navigation-vertical',
                offset: 100
            });
        }
    }

    /* Skroll data */
    var $skroll = $('nav .nav a[href^="#"]');
    $skroll.each(function(){
        var $this = $(this);
        var href = $this.attr('href');
        $this.attr('data-scroll', href)
    });

    /* Skrollr */
    var skroll;
    if (!device.mobile() && !device.tablet() && !el_html.hasClass('ie8')) {
        skroll = skrollr.init({
            forceHeight: false
        });
    }

    /* Page Scroll */
    $('[data-scroll]').on('click', function (e) {
        var scroll;
        e.preventDefault();
        scroll = $(this).attr('data-scroll');
        if (scroll === 'up') {
            $('html, body').animate({
                scrollTop: 0
            }, 900, 'swing');
        } else if (scroll.charAt(0) === '#') {
            if (device.mobile()) {
                $('html, body').animate({
                    scrollTop: $(scroll).offset().top - 50
                }, 900, 'swing');
            } else {
                $('html, body').animate({
                    scrollTop: $(scroll).offset().top - 80
                }, 900, 'swing');
            }
        }
        if ($(this).parent().hasClass('nav-item') && device.mobile()) {
            $('.navbar-beacon').removeClass('bounceInRight bounceInRight-duration').addClass('bounceOutRight bounceInRight-duration');
        }
        return false;
    });



    // Kenburns //-----------------------------

    function makekenburns($element) {
        // we set the 'fx' class on the first image
        // when the page loads
        $element.find('img')[0].className = "fx";
        // the third variable is to keep track of
        // where we are in the loop
        // if it is set to *1* (instead of 0)
        // it is because the first image is styled
        // when the page loads
        var images = $element.find('img'), numberOfImages = images.length, i = 1;
        if (numberOfImages == 1) {
            images[0].className = "singlefx";
        }
        // this calls the kenBurns function every
        // 4 seconds. You can increase or decrease
        // this value to get different effects
        window.setInterval(kenBurns, 7000);
        function kenBurns() {
            if (numberOfImages != 1) {
                if (i == numberOfImages) {
                    i = 0;
                }
                images[i].className = "fx";
                // we can't remove the class from the previous
                // element or we'd get a bouncing effect so we
                // clean up the one before last
                // (there must be a smarter way to do this though)
                if (i === 0) {
                    images[numberOfImages - 2].className = "";
                }
                if (i === 1) {
                    images[numberOfImages - 1].className = "";
                }
                if (i > 1) {
                    images[i - 2].className = "";
                }
                i++;
            }
        }
    }

    // Newsletter contact form //-----------------------------
    if ($('.ct-contactForm').length > 0 || $('.ct-newsletter').length > 0) {
        $('.ct-contactForm, .ct-newsletter').each(function () {
            var that = $(this);

            that.find('input, textarea').each(function () {
                var that = $(this);
                var thatButton = that.parent().parent().find('button');
                that.on('keyup', function () {
                    if (that.val() != 0) {
                        that.addClass('is-not-empty');
                        thatButton.addClass('is-not-empty');
                    } else {
                        that.removeClass('is-not-empty');
                        thatButton.removeClass('is-not-empty');
                    }
                })
            });
        });
    }

    // Navbar //-----------------------------

    /* Navbar Active Class */
    // url = window.location;
    // $('.navbar-default .navbar-nav').find('a').filter(function() {
    //     return this.href === url.href;
    // }).closest('li').addClass('active').closest("ul").parent().addClass('active');


    /* Menus variants */

    // Beacon
    var navbar_beacon = $('.navbar-beacon');
    if ($('.navbar').hasClass('navbar-dark')) {
        el_body.addClass('ct-menu-effect');
        $('.nav-item-toggle a i').on('click', function (e) {
            if (el_body.hasClass('cart-is-open')) {
                el_body.removeClass('cart-is-open');
            }
            el_body.toggleClass('ct-menu-effect-activated');
            if (!(navbar_beacon.hasClass('bounceInRight bounceInRight-duration'))) {
                navbar_beacon.removeClass('bounceOutRight bounceInRight-duration').addClass('bounceInRight bounceInRight-duration');
            } else {
                navbar_beacon.removeClass('bounceInRight bounceInRight-duration').addClass('bounceOutRight bounceInRight-duration');
            }
            e.preventDefault();
        });
    }

    el_wrapper.on('click', function () {
        if (navbar_beacon.hasClass('bounceInRight bounceInRight-duration')) {
            $('.ct-menu-mobile + .navbar-beacon').removeClass('bounceInRight bounceInRight-duration').addClass('bounceOutRight bounceInRight-duration');
        }
        if (!el_body.hasClass('navbar-inside')) {
            if (el_body.hasClass('cart-is-open')) {
                el_body.removeClass('cart-is-open');
            }
        }
    });

    if ($('.navbar-beacon').length > 0) {
        $('.navbar-beacon ul li.dropdown > a').on('click', function (e) {
            var $this = $(this);
            $this.parent().find('.dropdown-menu').slideToggle();
            $this.parent().toggleClass('is-active');
            e.preventDefault();
        });
    }

    $(window).on('scroll', function () {
        var scroll, pixes;
        scroll = $(window).scrollTop();


        /* Navbar Class */
        if (scroll > 80) {
            el_body.addClass('navbar-scrolled');
            $('.navbar--animated').addClass('animated-init navbar-fixed')
        } else {
            el_body.removeClass('navbar-scrolled');
            $('.navbar--animated').removeClass('animated-init navbar-fixed')
        }

    });



    // Css animate //-----------------------------

    if (device.mobile() || device.tablet() || device_width < 767) {
        $("body").removeClass("cssAnimate");
    } else {
        $('.cssAnimate .animated').each(function () {
            var that = $(this);
            if (that.data('time') != undefined) {
                var delay = that.attr('data-time');
                if (that.visible(true)) {
                    setTimeout(function () {
                        that.addClass('activate');
                        that.addClass(that.data('fx'));
                    }, delay)
                }
            }
            else {
                if (that.visible(true)) {
                    that.addClass('activate');
                    that.addClass(that.data('fx'));

                }
            }
        });
    }



    // Media Sections // ------------------------------------------------

    // Page Section PARALLAX // -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    if (jQuery().stellar && !device.isIE8) {
        if (!device.mobile() && !device.ipad() && !device.androidTablet()) {
            jQuery(window).stellar({
                horizontalScrolling: false, responsive: true, positionProperty: 'transform'
            });
        }
    }
    // Page Section DEFAULTS // -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    jQuery(".ct-mediaSection").each(function () {
        var $this = jQuery(this);
        var $height = $this.attr("data-height");
        // Page Section HEIGHT // -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        if (!(typeof $height === 'undefined')) {
            if ($height.indexOf("%") > -1) {
                $this.css('min-height', device_height);
                $this.css('height', device_height);
                if (!device.mobile()) {
                    $this.css('height', device_height + "px");
                    $this.css('min-height', device_height + "px");
                }
            } else {
                $this.css('min-height', $height + "px");
                $this.css('height', $height + "px");
                if (jQuery.browser.mozilla) {
                    $this.css('height', $height + "px");
                    $this.css('min-height', $height + "px");
                }
            }
        }
        // Page Section BACKGROUND COLOR // -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        if ($this.attr('data-type') == "color") {
            var $bg_color = $this.attr("data-bg-color");
            $this.css('background-color', $bg_color);
        }
        // Page Section BACKGROUND IMAGE // -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        if ($this.attr('data-type') == "pattern" || $this.attr('data-type') == "parallax" || $this.attr('data-type') == "video" || $this.attr('data-type') == "kenburns") {
            var $bg_image_fallback = $this.attr("data-bg-image-mobile");
            if (!(device.mobile() || device.ipad() || device.androidTablet())) {
                if ($this.attr('data-type') == "pattern" || $this.attr('data-type') == "parallax") {
                    var $bg_image = $this.attr("data-bg-image");
                    $this.css('background-image', 'url("' + $bg_image + '")');
                }
            } else {
                $this.css('background-image', 'url("' + $bg_image_fallback + '")');
            }
            // Page Section BACKGROUND POSITION FOR iDevices // -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
            if (device.mobile() || device.ipad() || device.androidTablet() || device.isIE8) {
                $this.css('background-attachment', 'scroll'); // iOS SUCKS
            }
        }
        // Page Section KENBURNS // -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        if ($this.attr('data-type') == "kenburns") {
            var images = $this.find('.ct-mediaSection-kenburnsImageContainer img');
            if (!(device.mobile() || device.ipad() || device.androidTablet())) {
                makekenburns($this.find('.ct-mediaSection-kenburnsImageContainer'));
            } else {
                images.each(function () {
                    $(this).remove();
                })
            }
        }
        // Page Section VIDEO // -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        if ($this.attr('data-type') == "video") {
            var $this = $(this);
            var $height = $this.attr("data-height");
            var $time = 1;
            if ($height.indexOf("%") > -1) {
                $this.css('min-height', device_height);
                $this.find('> .ct-u-display-table').css('height', device_height);
            } else {
                $this.css('min-height', $height + "px");
                $this.find('> .ct-u-display-table').css('height', $height + "px");
            }
            if (!$this.hasClass("html5")) {
                var $videoframe = $this.find('iframe')
                if ($videoframe.attr('data-startat')) {
                    $time = $videoframe.attr('data-startat');
                }
                if (!(device_width < 992) && !device.mobile()) {
                    if (typeof $f != 'undefined') {
                        var $video = '#' + $videoframe.attr('id');
                        var iframe = $($video)[0], player = $f(iframe), status = $('.status');
                        player.addEvent('ready', function () {
                            player.api('setVolume', 0);
                            player.api('seekTo', $time);
                        })
                    }
                }
            } else {
                //THIS IS WHERE YOU CALL THE VIDEO ID AND AUTO PLAY IT. CHROME HAS SOME KIND OF ISSUE AUTOPLAYING HTML5 VIDEOS, SO THIS IS NEEDED
                document.getElementById('video1').play();
            }
            if (device_width < 992 || device.mobile() || device.ipad() || device.androidTablet()) {
                $this.find(".ct-mediaSection-video").css('display', 'none');
            }
        }
    })
    // Page Section PARALLAX // -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    jQuery(".stellar-object").each(function () {
        var $this = jQuery(this);
        var $bg = $this.attr("data-image");
        var $height = $this.attr("data-height") + 'px';
        var $width = $this.attr("data-width") + 'px';
        var $top = $this.attr("data-top");
        var $left = $this.attr("data-left");
        $this.css('background-image', 'url("' + $bg + '")');
        $this.css('width', $width);
        $this.css('height', $height);
        $this.css('top', $top);
        $this.css('left', $left);
    });

    // Gallery for post gallery type // -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    var blogGallery = $('.ct-owlCarousel');
    if (blogGallery.length > 0){
        blogGallery.each(function(){
            var element = $(this);
            if (element.find('.gallery figure').length > 1){
                element.find('.gallery').addClass('owl-carousel');
                element.find('.owl-carousel').owlCarousel({
                    items:1,
                    loop:true,
                    margin:10,
                    merge:true,
                    nav: true,
                });
            }
        });
    }

    // FITVIDS - responsive video // -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------




    /* Selectize */
    if ($().selectize) {
        $('select').each(function() {
            $(this).selectize({
                create: true,
                sortField: 'text'
            });
        });
    }

    // Contact form [add to Cart] // -----------------------------------------------------------------------------------

    if ($('.ct-addToCart').length > 0) {
        var $addToCart = $('.ct-addToCart');

        $addToCart.each(function() {
            var $that = $(this);

            $that.on('keydown', function(e) {
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || (e.keyCode >= 35 && e.keyCode <= 40)) {
                    return;
                }
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
            var $i = 0;
            $that.find('.ct-input-increment').on('click', function() {
                var $j = $i + 1;
                $(this).each(function() {
                    $that.find('.input-required-value').val($j);
                });
                $i++;
                $('#required-value').val($i);
            });
            $that.find('.ct-input-decrement').on('click', function() {
                if($i > 0){
                    var $j = $i - 1;
                    $(this).each(function() {
                        $that.find('.input-required-value').val($j--);
                    });
                    $i--;
                    $('#required-value').val($i);
                }
            });

            var $button = $that.find('.btn-group');
            $button.click(function(e){
                var $piece = $that.find('input').val();
                if ($piece=='') {
                    $piece = 1;
                }
                var $select = $that.find('.ct-product-title select');
                var $id = jQuery( '#ct-woo-promo-section-product-id' ).val();
                var $variationId = $select.find('option:selected').val();
                var $attrQuery = $variationId ? jQuery( '#ct-hidden-variation-id-' + $variationId ).data('query') : '';
                var $url = window.location.href.match(/^.*\//);
                $url +='?add-to-cart=' + $id + '&quantity=' + $piece;
                if ( $variationId ) {
                    $url += '&variation_id=' + $variationId + $attrQuery;
                }
                $(this).attr('href', $url);


            });
        });
    }


    // IconBox stepper // -----------------------------------------------------------------------------------

    if ($('.ct-iconBox--stepped').length > 0) {
        if (device_width > 992){
            $('.ct-iconBox--stepped').each(function() {
                var that = $(this),
                    that_position = that.attr("data-padding-position");
                // that.addClass(that_position);
                that.find("[data-padding]").each(function(){
                    var element = $(this),
                        element_padding = element.attr("data-padding");

                    if(that_position !== "right"){
                        that_position = "left";
                    }
                    element.css("padding-"+that_position, element_padding);


                })
                // var $iStepped = $('.ct-iconBox--stepped'),
                //     $incrementBase = 0,
                //     $this = $(this),
                //     step = parseInt(validatedata($(this).attr("data-step"), 50), 10),
                //     stepMD = parseInt(validatedata($(this).attr("data-step-md"), 50), 10);
                //
                // $this.find('.ct-iconBox').not(':first-child').each(function() {
                //   var $this = $(this);
                //   if (device_width > 1199) {
                //     $this.css('padding-left', $incrementBase+=step);
                //     $iStepped.find('.ct-iconBox').eq(1).css('padding-left', step + 'px');
                //   } else if (device_width > 991 && device_width < 1200) {
                //     $this.css('padding-left', $incrementBase+=stepMD);
                //     $iStepped.find('.ct-iconBox').eq(1).css('padding-left', stepMD + 'px')
                //   }
                //
                // })
            });
        }
    }

    // Product preview // -----------------------------------------------------------------------------------

    if ($('.ct-productPreview').length > 0 ) {

        if ($('[data-width]').length > 0) {
            $('[data-width]').each(function() {
                var that = $(this),
                    dwidth = that.attr('data-width');
                that.find('.ct-iconBox-decorativeLine').css('width', dwidth);
            });
        }

        if ($('[data-left-position]').length > 0) {
            $('[data-left-position]').each(function() {
                var that = $(this),
                    dleft = that.attr('data-left-position');
                that.find('.ct-iconBox-decorativeLine').css('left', dleft);
            });
        }
        if ($('[data-right-position]').length > 0) {
            $('[data-right-position]').each(function() {
                var that = $(this),
                    dright = that.attr('data-right-position');
                that.find('.ct-iconBox-decorativeLine').css('right', dright);
            });
        }
    }


    // Woo Gallery // -----------------------------------------------------------------------------------

    var $galleryContainer = $('.ct-woo-singleGallery');
    var $galleryThumbnails = $('.ct-woo-singleProduct-gallery-thumb');

    $galleryThumbnails.on('click', function(e){
        e.preventDefault();
        var $tmp = $(this).data('thumbno');
        $('.ct-woo-singleGallery-bigGallery--content').hide();
        $galleryContainer.find('[data-gal="'+$tmp+'"]').show();
    })


    if (($('.ct-js-cart__button')).length > 0){
        $('.ct-js-cart__button').each(function(){
            var button_cart = $(this);
            button_cart.on("click", function(){
                el_body.toggleClass('cart-is-open');
            })
        })
    }


    const preloader = $('.ct-preloader');

    if (preloader.length > 0) {
        preloader.fadeOut('slow');
    }

    // Search Link // -----------------------------------------------------------------------------------

    if (($('.ct-search-link')).length > 0) {
        $('.ct-search-link').on('click', function(e) {
            e.preventDefault();
            $('.ct-searchForm').addClass('is-open');
        });
        $('.ct-searchForm-close').on('click', function(e) {
            $('.ct-searchForm').removeClass('is-open');
            e.preventDefault();
        })
    }


    var $team = $('.ct-team');

    if ($team.length > 0){
        $team.each(function(){
           var $this = $(this);
           var $teamSlide = $this.find('a.ct-personBox');
           $('.ct-teammember-close--button').on('click', function(e){
              e.preventDefault();
               var $this = $(this);
               var $container = $this.parent().parent().parent().parent();
               var $background = $this.parent().parent().parent().parent().parent();
               $background.fadeOut(700);
               $container.removeClass('blur-in').addClass('blur-out');
               e.stopPropagation();
           });
           $teamSlide.on('click', function(e){
               e.preventDefault();
               var $that = $(this);
               var $data = $that.data('person');
               var $teamMember = $('.ct-teamMember[data-person="'+ $data + '"]');
               $teamMember.fadeIn(1000);;
           })

        });
    }

// Admin Bar fix
    if (el_body.hasClass('admin-bar')){
        el_html.addClass('ct-wp-admin');
    }
});

// el_body.ctshop({
//     cart: 'ct-cart__product',
//     after_add_to_cart: function(){
//         $('.ct-cart').each(function(){
//             var item_value = $('#required-value').val(),
//                 cart = $(this),
//                 message = cart.find('.ct-cart__message');
//             if(item_value == 0){
//                 item_value = 1;
//             }
//             message.addClass('ct-cart__message-added');
//             setTimeout(function(){
//                 message.removeClass('ct-cart__message-added');
//             }, 1000)
//             $(this).find('li').last().find('.ct-cart__product-input').attr('value', item_value).trigger('focus').trigger('focusout');
//         })
//     }
// });





