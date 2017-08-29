function slabTextHeadlines() {
    $("h1").slabText({
        // Don't slabtext the headers if the viewport is under 380px
        "viewportBreakpoint": 380
    });
}

// Load fonts using google font loader
var WebFontConfig = {
    google: {families: ['Open+Sans:400,700:latin', 'Oswald:700:latin']},
    // slabText the headers when the font has finished loading (or not)
    fontactive: slabTextHeadlines,
    fontinactive: slabTextHeadlines
};

(function () {
    var wf = document.createElement('script');
    wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
})();