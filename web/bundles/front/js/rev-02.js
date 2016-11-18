var tpj = jQuery;
var revapi92;
tpj(document).ready(function() {
    if (tpj("#rev_slider_92_1").revolution == undefined) {
        revslider_showDoubleJqueryError("#rev_slider_92_1");
    } else {
        revapi92 = tpj("#rev_slider_92_1").show().revolution({
            sliderType: "hero",
            jsFileLocation: "revolution/js/",
            sliderLayout: "fullwidth",
            dottedOverlay: "none",
            delay: 9000,
            navigation: {},
            responsiveLevels: [1240, 1024, 778, 480],
            gridwidth: [1240, 1024, 778, 480],
            gridheight: [500, 450, 400, 350],
            lazyType: "none",
            parallax: {
                type: "scroll",
                origo: "enterpoint",
                speed: 400,
                levels: [5, 10, 15, 20, 25, 30, 35, 40, 45, 50],
            },
            shadow: 0,
            spinner: "off",
            autoHeight: "off",
            disableProgressBar: "on",
            hideThumbsOnMobile: "off",
            hideSliderAtLimit: 0,
            hideCaptionAtLimit: 0,
            hideAllCaptionAtLilmit: 0,
            debugMode: false,
            fallbacks: {
                simplifyAll: "off",
                disableFocusListener: false,
            }
        });
    }
}); /*ready*/