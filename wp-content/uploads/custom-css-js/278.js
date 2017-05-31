<!-- start Simple Custom CSS and JS -->
<script type="text/javascript">
jQuery(document).ready(function($){
	$('#advanced_menu_toggle').remove();
  	$('nav.main_menu').remove();
	$('.av-logo-container > .inner-container').css('position', 'relative');
	$('.twp-olmenu-btn.twp_menu_outside.twp_menu_center').appendTo('.av-logo-container > .inner-container').css('text-align', 'right');
  	
  	$('.social_bookmarks').appendTo('.av-logo-container > .inner-container');
  	$('.social_bookmarks li a').css('font-size', '20px');
  
  	$('.twp-olmenu-btn.twp_menu_outside.twp_menu_center').remove();
  	$('#iwpmenu_icon').appendTo('.av-logo-container > .inner-container');

});</script>
<!-- end Simple Custom CSS and JS -->
