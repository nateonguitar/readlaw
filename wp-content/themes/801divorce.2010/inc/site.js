$(document).ready(function(){
	// round corners
	$('form#sidebarContactForm, .homeBox, .RoundCorner').corner("10px");
	
	// navigation (DISABLED)
	/*
	$('ul#nav li').hover(
		function(){ $(this).children('ul').show(); },
		function(){ $(this).children('ul').hide(); }
	);
	*/
	$('ul#nav li:last').addClass('last');
	
	// banner slideshow
	$('#bannerSlideshow').cycle({
		height:  'auto',	// container height 
	    fade:     1,		// true for fade, false for slide 
	    speed:    2000,		// any valid fx speed value 
	    timeout:  5000,		// ms duration for each slide 
	    random:   0,       // true for random, false for sequence 
	    fit:      0,       // force slides to fit container 
	    pause:    0,       // true to enable "pause on hover" 
	    autostop: 0        // true to end slideshow after X slides have been shown (where X == slide count) (note that if random == true not all slides are guaranteed to have been shown) 
	});
	
	// testimonial slideshow
	$('#testimonialSlideshow').cycle({
		height:  'auto',	// container height 
	    fade:     1,		// true for fade, false for slide 
	    speed:    2000,		// any valid fx speed value 
	    timeout:  5000,		// ms duration for each slide 
	    random:   0,       // true for random, false for sequence 
	    fit:      0,       // force slides to fit container 
	    pause:    0,       // true to enable "pause on hover" 
	    autostop: 0        // true to end slideshow after X slides have been shown (where X == slide count) (note that if random == true not all slides are guaranteed to have been shown) 
	});
			
	// form submit
	$('form.contactForm').submit(function(){
		if ($('#i_have_read_the_disclaimer').attr('checked')) {
			return true;
		} else {
			alert('Please verify that you have read the disclaimer.');
			return false;
		}			
	});	
	
	// anti spam form validation
	$('input,textarea').keypress(function(){
		this.form.elements.pv.value='verified';
	});
	
	// png fix for old IE browsers
	$(document).pngFix();
});