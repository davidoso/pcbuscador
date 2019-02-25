(function($) {
    showToastNotif = function(heading, text, position, icon) {
        'use strict';
        resetToastPosition();
        $.toast({
            heading: heading,
            text: text,
            position: String(position),
            showHideTransition: 'slide',
            icon: icon, // 4 options (and therefore background color): info, error, warning, success
            stack: false,
            loaderBg: '#ab47bc'
        })
    }

    resetToastPosition = function() {
        // to remove previous position class
        $('.jq-toast-wrap').removeClass('bottom-left bottom-right top-left top-right mid-center');
        // to remove previous position style
        $(".jq-toast-wrap").css({"top": "", "left": "", "bottom":"", "right": ""});
    }
})(jQuery);