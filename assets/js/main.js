(function ($) {
	"use strict";



	// preloader
	$(window).on('load', function () {
		$('#loading-center').delay(350).fadeOut('slow');
		$('#loading').delay(350).fadeOut('slow');
		$('body').delay(350).css({ 'overflow': 'visible' });
	})


	
	// sticky header
	var wind = $(window);
	var sticky = $('#sticky-header');
	wind.on('scroll', function () {
		var scroll = wind.scrollTop();
		if (scroll < 100) {
			sticky.removeClass('sticky-header');
		} else {
			sticky.addClass('sticky-header');
		}
	});

	// mobile menu start
	$('#mobile-menu').meanmenu({
		meanMenuContainer: '.mobile-menu',
		meanScreenWidth: "991"
	});

	$('.side-toggle').on('click', function () {
		$('.side-mobile-menu').addClass('info-open');
		$('.offcanvas-overlay').addClass('overlay-open');
	})

	$('.side-info-close,.offcanvas-overlay').on('click', function () {
		$('.side-mobile-menu').removeClass('info-open');
		$('.offcanvas-overlay').removeClass('overlay-open');
	})


	// SLIDER
	var menu = [];
	jQuery('.swiper-slide').each(function (index) {
		menu.push(jQuery(this).find('.slide-inner').attr("data-text"));
	});
	var interleaveOffset = 0.5;
	var swiperOptions = {
		loop: true,
		speed: 1000,
		parallax: true,
		autoplay: {
			delay: 6500,
			disableOnInteraction: false,
		},
		watchSlidesProgress: true,
		pagination: {
			el: '.swiper-pagination',
			clickable: true,
		},

		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},

		on: {
			progress: function () {
				var swiper = this;
				for (var i = 0; i < swiper.slides.length; i++) {
					var slideProgress = swiper.slides[i].progress;
					var innerOffset = swiper.width * interleaveOffset;
					var innerTranslate = slideProgress * innerOffset;
					swiper.slides[i].querySelector(".slide-inner").style.transform =
						"translate3d(" + innerTranslate + "px, 0, 0)";
				}
			},

			touchStart: function () {
				var swiper = this;
				for (var i = 0; i < swiper.slides.length; i++) {
					swiper.slides[i].style.transition = "";
				}
			},

			setTransition: function (speed) {
				var swiper = this;
				for (var i = 0; i < swiper.slides.length; i++) {
					swiper.slides[i].style.transition = speed + "ms";
					swiper.slides[i].querySelector(".slide-inner").style.transition =
						speed + "ms";
				}
			}
		}
	};

	var swiper = new Swiper(".swiper-container", swiperOptions);

	//data background
	$("[data-background]").each(function () {
		$(this).css("background-image", "url(" + $(this).attr("data-background") + ") ")
	})

	// brand-active
	$('.brand-active').owlCarousel({
		loop: true,
		margin: 30,
		items: 1,
		dots: false,
		autoplay: true,
		autoplayTimeout: 5000,
		autoplayHoverPause: true,
		responsive: {
			0: {
				items: 2
			},
			767: {
				items: 3
			},
			992: {
				items: 4
			},
			1200: {
				items: 5
			}
		}
	})
	// blog-post-active
	$('.gallery-post-active').owlCarousel({
		loop: true,
		margin: 0,
		items: 1,
		navText: ['<i class="far fa-angle-left"></i>', '<i class="far fa-angle-right"></i>'],
		nav: true,
		dots: false,
		responsive: {
			0: {
				items: 1
			}
		}
	})

	/* magnificPopup img view */
	$('.popup-image').magnificPopup({
		type: 'image',
		gallery: {
			enabled: true
		}
	});

	/* magnificPopup video view */
	$('.popup-video').magnificPopup({
		type: 'iframe'
	});

	// isotop
	$('.grid').imagesLoaded(function () {
		// init Isotope
		var $grid = $('.grid').isotope({
			itemSelector: '.grid-item',
			percentPosition: true,
			masonry: {
				// use outer width of grid-sizer for columnWidth
				columnWidth: '.grid-item',
			}
		});

		// filter items on button click
		$('.portfolio-menu').on('click', 'li', function () {
			var filterValue = $(this).attr('data-filter');
			$grid.isotope({ filter: filterValue });
		});
	});

	//for menu active class
	$('.portfolio-menu li').on('click', function (event) {
		$(this).siblings('.active').removeClass('active');
		$(this).addClass('active');
		event.preventDefault();
	});

	// Active Odometer Counter 
	jQuery('.odometer').appear(function (e) {
		var odo = jQuery(".odometer");
		odo.each(function () {
			var countNumber = jQuery(this).attr("data-count");
			jQuery(this).html(countNumber);
		});
	});

	/*------------------------------------------
        = SHOP PAGE GRID VIEW TOGGLE
    -------------------------------------------*/  
    if($(".woocommerce-toolbar-top").length) {
        var products = $(".products"),
            allButton = $(".products-sizes a"),
            grid4 = $(".grid-4"),
            grid3 = $(".grid-3"),
            listView = $(".list-view");

        allButton.each(function() {
            var $this = $(this);
            $this.on("click", function(e) {
                e.preventDefault();
                $this.addClass("active").siblings().removeClass('active');
                e.stopPropagation();
            })
        });

        grid4.on("click", function(f) {
            products.removeClass("list-view three-column");
            products.addClass("default-column");
            f.stopPropagation();
        });

        grid3.on("click", function(g) {
            products.removeClass("default-column list-view");
            products.addClass("three-column");
            g.stopPropagation();
        });

        listView.on("click", function(h) {
            products.removeClass("default-column three-column");
            products.addClass("list-view");
            h.stopPropagation();
        });
    }

	/*----------------------------
	= SHOP PRICE SLIDER
    ------------------------------ */
    if($("#slider-range").length) {
        $("#slider-range").slider({
            range: true,
            min: 12,
            max: 200,
            values: [0, 100],
            slide: function(event, ui) {
                $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
            }
        });

        $("#amount").val("$" + $("#slider-range").slider("values", 0) + " - $" + $("#slider-range").slider("values", 1));
    }

	    /*------------------------------------------
        = TOUCHSPIN FOR PRODUCT SINGLE PAGE
    -------------------------------------------*/
    if ($("input.product-count").length) {
        $("input.product-count").TouchSpin({
            min: 1,
            max: 1000,
            step: 1,
            buttondown_class: "btn btn-link",
            buttonup_class: "btn btn-link",
        });
    }  

	/*------------------------------------------
        = PRODUCT ARES QUICK VIEW
    -------------------------------------------*/
    if($("ul.products").length) {

        var product = $("ul.products li.product");

        product.each(function() {
            var quickViewLink = product.find('a[title="Quick view!"]');
            var closeQuickView = product.find(".quick-view-single-product-close-btn");
            var singleProduct = $(".quick-view-single-product");

            var owlStage = $(".owl-stage") ? $(".owl-stage") : null;
            var owlStageOuter = $(".owl-carousel .owl-stage-outer") ? $(".owl-carousel .owl-stage-outer") : null ;

            quickViewLink.on("click", function(e) {
                e.preventDefault();
                $(this).closest(".product").find(".quick-view-single-product").addClass("activve-quick-view-single-product");

                owlStage.addClass("transform-none");
                owlStageOuter.addClass("transform-none");
                return false;
            })

            closeQuickView.on("click", function(f) {
                singleProduct.removeClass("activve-quick-view-single-product");
                owlStage.removeClass("transform-none");
                owlStageOuter.removeClass("transform-none");
                return false;
            })
        })
    }

	/*------------------------------------------
        = woocommerce
    -------------------------------------------*/
    if($(".checkout-section").length) {
        var showLogInBtn = $(".woocommerce-info > a");
        var showCouponBtn = $(".showcoupon");
        var shipDifferentAddressBtn = $("#ship-to-different-address");
        var loginForm = $("form.login");
        var couponForm = $(".checkout_coupon");
        var shippingAddress = $(".shipping_address");

        loginForm.hide();
        couponForm.hide();
        shippingAddress.hide();

        showLogInBtn.on("click", function(event) {
            event.preventDefault();
            loginForm.slideToggle();
            event.stopPropagation();
        });

        showCouponBtn.on("click", function(event2) {
            event2.preventDefault();
            couponForm.slideToggle();
            event2.stopPropagation();
        })

        shipDifferentAddressBtn.on("click", function(event3) {
            shippingAddress.slideToggle();
            event3.stopPropagation();
        })
    }






})(jQuery);