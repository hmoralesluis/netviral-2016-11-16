var tpj = jQuery;
var revapi110;
tpj(document).ready(function() {
    if (tpj("#rev_slider_110_1").revolution == undefined) {
        revslider_showDoubleJqueryError("#rev_slider_110_1");
    } else {
        revapi110 = tpj("#rev_slider_110_1").show().revolution({
            sliderType: "hero",
            jsFileLocation: "revolution/js/",
            sliderLayout: "fullwidth",
            dottedOverlay: "none",
            delay: 20000,
            navigation: {},
            responsiveLevels: [1240, 1024, 778, 778],
            gridwidth: [1240, 1024, 778, 480],
            gridheight: [600, 500, 400, 300],
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
            fullScreenAlignForce: "off",
            fullScreenOffsetContainer: "",
            fullScreenOffset: "60px",
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

        var api = revapi110,
            ElementsToBlur = api.find('.toblur.tp-caption'),
            ElementsToUnBlur = api.find('.tounblur.tp-caption'),
            UnBlurFactor = 2,
            UnBlurStart = 3,
            UnBlurEnd = 0,
            BlurStart = 0,
            BlurEnd = 5,
            BlurFactor = 2,
            blurCall = new Object();

        // SOME CODE FOR BLUR AND UNBLUR ELEMENTS
        // EXTEND THE REVOLUTION SLIDER FUNCTION
        // CHANGE ONLY IF YOU KNOW WHAT YOU DO
        blurCall.inmodule = "parallax";
        blurCall.atposition = "start";
        blurCall.callback = function() {
            var proc = api.revgetparallaxproc(),
                blur = UnBlurStart + (proc * UnBlurStart * UnBlurFactor) + UnBlurEnd,
                nblur = Math.abs(proc * BlurEnd * BlurFactor) + BlurStart;
            blur = blur < UnBlurEnd ? UnBlurEnd : blur;
            nblur = nblur > BlurEnd ? BlurEnd : nblur;
            ElementsToUnBlur = jQuery(ElementsToUnBlur.selector);
            punchgs.TweenLite.set(ElementsToUnBlur, {
                '-webkit-filter': 'blur(' + (blur) + 'px)',
                'filter': 'blur(' + (blur) + 'px)'
            });
            punchgs.TweenLite.set(ElementsToBlur, {
                '-webkit-filter': 'blur(' + (nblur) + 'px)',
                'filter': 'blur(' + (nblur) + 'px)'
            });
        }
        api.bind("revolution.slide.layeraction", function(e) {
            blurCall.callback();
        });
        api.bind("revolution.slide.onloaded", function(e) {
            revapi109.revaddcallback(blurCall);
        });
    }
}); /*ready*/