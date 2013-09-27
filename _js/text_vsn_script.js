/*
This script manages several functions used in generating
the text bulletin.

> It removes graphic items (images and iframes).
> It adds link targets, encased in square brackets, to the displayed text.
> It adds sequence numbers to ordered lists and asterisks to unordered lists
> Finally, it generates a table of contents.

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
	
	$("ul li").each(function() {
		(this).innerHTML = "* " + (this).innerHTML;
	});

	var saved_parent_ol = null;
	var this_parent_ol;
	var item_num = 1;
	
	$("ol li").each(function() {
	
		this_parent_ol = (this).parentNode;
	
		if (saved_parent_ol == null) {
			saved_parent_ol = this_parent_ol;
		}

		if (this_parent_ol != saved_parent_ol) {
			saved_parent_ol = this_parent_ol;
			item_num = 1;
		}
		
		(this).innerHTML = item_num++ + ". " + (this).innerHTML;
		
	});

	$("document").ready(function() {
		gen_toc(false);
	});
}
