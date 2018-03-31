/**
 * Slider
 * 
 * @author Slava Yurthev
 */
define(['jquery', 'SY_Slider/js/bxslider'], function(){
	return function(config, element){
		jQuery(element).bxSlider(config);
	}
});