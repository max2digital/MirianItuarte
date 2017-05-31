jQuery(document).ready(function ($) {

    $(".twp-olmenu-btn a").click(function () {
        $(".twp-overlay").fadeToggle(200);
        $(this).toggleClass('twp-btn-open').toggleClass('twp-btn-close');
    });

    $('.twp-overlay-close').on('click', function () {
        $(".twp-overlay").fadeToggle(200);
        $(".twp-olmenu-btn a").toggleClass('twp-btn-open').toggleClass('twp-btn-close');
    });

    $('.twp-olmenu a').on('click', function () {
        $(".twp-overlay").fadeToggle(200);
        $(".twp-olmenu-btn a").toggleClass('twp-btn-open').toggleClass('twp-btn-close');
    });
	
	//OPEN MENU IN ANY CONTENT
	 $("a.twp-overlay-open").click(function () {
        $(".twp-overlay").fadeToggle(200);
    });

});