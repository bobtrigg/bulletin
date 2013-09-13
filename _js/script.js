function populatePics(text) {
	$(".graphic").each(function() {
		if (this.value === "") {
			this.value = text;
		}
	});
}

function redisplay_view_link(id) {	

	var input_obj = document.getElementById(id);
	var input_val = input_obj.value;
	var input_len = input_val.length;
	var input_link_id = id + "_view";
	var input_link = document.getElementById(input_link_id);
	var input_val_sfx = input_val.substring(input_len-3);
	
	if (input_val != "") {

		if (input_val_sfx == "jpg" ||
			input_val_sfx == "gif" ||
			input_val_sfx == "png" ||
			input_val_sfx == "pdf") {
					
				input_link.innerHTML = "View";
				input_link.href = input_obj.value;
				
				if (input_val_sfx == 'pdf') {
					$("#" + input_link_id).removeClass('fancybox');
				} else {
					$("#" + input_link_id).addClass('fancybox');
				}
		}
	}
}
// create those event handlers.

function prepEventHandlers() {

	// Event handler for when subtitle is changed:
	// If excerpt is blank, default it to new subtitle
	$("#subtitle").change(function() {
		var excerpt = document.getElementById('excerpt');
		if (excerpt.value == '' || excerpt.value == ' ') {
			excerpt.value = this.value;
		}
	});

	// If any of the graphics change, default all with no value to the value in the changed field
	$( ".graphic" ).change(function() {
		var thisText = this.value;
		populatePics(thisText);
	});
	
	// Next three handlers display a link to view a graphic when its value changes
	$( "#graphic" ).change(function() {
		redisplay_view_link("graphic");
	});
	
	$( "#large_graphic" ).change(function() {
		redisplay_view_link("large_graphic");
	});
	
	$( "#thumbnail" ).change(function() {
		redisplay_view_link("thumbnail");
	});
	
	// Display view links at the start of the program
	redisplay_view_link("graphic");
	redisplay_view_link("large_graphic");
	redisplay_view_link("thumbnail");

};

window.onload = function () {
	prepEventHandlers();
}