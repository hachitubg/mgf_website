jQuery(function($){
	$(document).ready(function(){
		console.log('Custom script loaded.');
		dropdownProductCatMenu();
		//dropdownPhotosNav();
		//getSelectedProductCatMenuItem();
	})
	function dropdownProductCatMenu(){
		var menu = $(".menu-product-cat ul");
		menu.on("click", ".menu-item:first-child", function(e) {
			$(this).siblings().toggle();
		});
		var allOptions = menu.children('li:not(.menu-item:first-child)');
		menu.on("click", "li:not(.menu-item:first-child)", function() {
			allOptions.removeClass('selected');
			$(this).addClass('selected');
			menu.children('.menu-item:first-child').html($(this).html());
			allOptions.toggle();
		});
	}
	function getSelectedProductCatMenuItem(){
		$(window).on('load', function(){
			var menu = $(".menu-product-cat ul");
			var first_child = menu.find('li:first-child');
			var current = menu.find('.current-menu-item');
			menu.prepend(current);
		})
	}
})
