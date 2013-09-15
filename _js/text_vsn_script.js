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
