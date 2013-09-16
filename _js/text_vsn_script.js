/*
This script manages several functions used in generating
the text bulletin.

It removes graphic items (images and iframes).
It also adds link targets, encased in square brackets, to the displayed text.
Finally, it generates a table of contents.

The resulting text bulletin is displayed in a browser and should be
copied directly from the browser window: the HTML still contains many
tags which should not be included in the text.
*/

window.onload = function () {

	$("img").each(function() {
		(this).remove();
	});

	$("iframe").each(function() {
		(this).remove();
	});
	
	var link_array = document.getElementsByTagName('a');
	var link_text;
	
	for (var i = 0; i < link_array.length; i++) { 
		link_text = link_array[i].innerHTML + " [" + link_array[i].href + "] ";
		link_array[i].innerHTML = link_text;
	};	

	$("document").ready(function() {
		gen_toc(false);
	});
}
