var tpj = jQuery;
var revapi100;
tpj(document).ready(function() {
    if (tpj("#rev_slider_100_1").revolution == undefined) {
        revslider_showDoubleJqueryError("#rev_slider_100_1");
    } else {
        revapi100 = tpj("#rev_slider_100_1").show().revolution({
            sliderType: "hero",
            jsFileLocation: "revolution/js/",
            sliderLayout: "fullwidth",
            dottedOverlay: "none",
            delay: 9000,
            navigation: {},
            responsiveLevels: [1240, 1024, 778, 480],
            gridwidth: [1240, 1024, 778, 480],
            gridheight: [500, 500, 400, 300],
            lazyType: "none",
            parallax: {
                type: "mouse",
                origo: "slidercenter",
                speed: 2000,
                levels: [2, 3, 4, 5, 6, 7, 12, 16, 10, 50],
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