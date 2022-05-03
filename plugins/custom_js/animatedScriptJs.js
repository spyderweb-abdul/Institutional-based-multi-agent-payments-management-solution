// JavaScript Document

//For Viwport scroll animation
jQuery(document).ready(function() 
{
    jQuery('#anim').addClass("hide_me").viewportChecker({
        classToAdd: "visible animated bounceInLeft",
        offset: 100
       });

    jQuery('#intro-writeup').addClass("hide_me").viewportChecker({
        classToAdd: "visible animated zoomIn",
        offset: 100
       });

        jQuery('#three-enc').addClass("hide_me").viewportChecker({
        classToAdd: "visible animated zoomInLeft",
        offset: 100
       });

        jQuery('#three-proc').addClass("hide_me").viewportChecker({
        classToAdd: "visible animated zoomIn",
        offset: 100
       });


        jQuery('#three-tim').addClass("hide_me").viewportChecker({
        classToAdd: "visible animated zoomIn",
        offset: 100
       });


        jQuery('#three-chart').addClass("hide_me").viewportChecker({
        classToAdd: "visible animated zoomInRight",
        offset: 100
       });

        jQuery('#four-laptop').addClass("hide_me").viewportChecker({
        classToAdd: "visible animated fadeIn",
        offset: 100
       });


        jQuery('#tax').addClass("hide_me").viewportChecker({
        classToAdd: "visible animated fadeIn",
        offset: 100
       });


        jQuery('#gateway').addClass("hide_me").viewportChecker({
        classToAdd: "visible animated fadeIn",
        offset: 100
       });


        jQuery('#e-Commerce').addClass("hide_me").viewportChecker({
        classToAdd: "visible animated fadeIn",
        offset: 100
       });

        jQuery('#chart').addClass("hide_me").viewportChecker({
        classToAdd: "visible animated fadeIn",
        offset: 100
       });

        jQuery('#dashboard').addClass("hide_me").viewportChecker({
        classToAdd: "visible animated fadeIn",
        offset: 100
       });

        jQuery('#developer').addClass("hide_me").viewportChecker({
        classToAdd: "visible animated bounceIn",
        offset: 100
       });
});

//For preload icon | Script Credit: smallenvelope.com/display-loading-icon-page-loads-completely/
	   $(window).load(function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");;
	});