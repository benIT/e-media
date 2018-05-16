(function ($) {
    $(document).ready(function () {
        $("h1").slabText({
            // Don't slabtext the headers if the viewport is under 380px
            "viewportBreakpoint": 380
        });
        $('select').chosen({
            allow_single_deselect: true,
            placeholder_text: Translator.trans('select.multiple', {}, 'common'),
            width: '100%'
        });
        $('#loading').fadeOut();
    });
})(jQuery);