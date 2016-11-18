/******************************************
	-	PREPARE PLACEHOLDER FOR SLIDER	-
******************************************/
var revapi;
jQuery(document).ready(function() {
    revapi = jQuery("#rev_slider").revolution({
        sliderType: "standard",
        sliderLayout: "fullscreen",
        fullScreenOffsetContainer: ".header",
        fullScreenOffset: "50px",
        delay: 9000,
        navigation: {
            arrows: {
                enable: true
            }
        },
        gridwidth: 1230,
        gridheight: 720
    });
}); /*ready*/