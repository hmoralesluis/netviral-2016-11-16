(function($) {
    $.fn.footerReveal = function(options) {
        var $this = $(this),
            $prev = $this.prev(),
            defaults = {
                shadow: true
            },
            options = $.extend(defaults, options);

        $this.css({
            position: 'fixed',
            bottom: '0',
            'z-index': -1000,
            margin: '0 auto'
        });
        $(function() {
            $prev.css({
                'margin-bottom': $this.css('height')
            });
            if (defaults.shadow) {
                $prev.css({});
            }
        });
    }
})(jQuery);

$(function() {
    $(".sticky-footer").footerReveal();
});