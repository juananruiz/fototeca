//sticky header
jQuery(window).resize(function () {
    jQuery(".navbar-collapse").css({maxHeight: $(window).height() - $(".navbar-header").height() + "px"});
});

//Sticky header on scroll
jQuery(document).ready(function () {
    $(window).load(function () {
        jQuery(".sticky").sticky({topSpacing: 0});
    });
});
