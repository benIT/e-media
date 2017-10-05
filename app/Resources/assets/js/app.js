(function ($) {
    console.log('logs immediately');
    $(document).ready(function () {
        console.log('logs after ready');
        $("h1").slabText({
            // Don't slabtext the headers if the viewport is under 380px
            "viewportBreakpoint": 380
        });
        $('select').chosen({allow_single_deselect: true});
        $('#loading').fadeOut(500);
    });
})(jQuery);