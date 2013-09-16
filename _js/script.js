/*
This script contains several functions used to manage the displays
in the bulletin item web forms (create_item.php and edit_item.php).

It populates all image URLs when the first one is changed to something other than the default.
When any image URL is changed, it displays or changes the link to display the image;
if the image is .jpg, .gif, or .png, it uses fancybox to pop out the image.
*/

function populatePics(text) {
	$(".graphic").each(function() {
	
		var image_folder = document.getElementById('image_folder').value;
	
		if (this.value === "" || this.value === image_folder) {
			this.value = text;
			redisplay_view_link(this.id);
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
	var image_folder = document.getElementById('image_folder').value;
	
	if (input_val != "" && input_val != image_folder) {

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

function update_image_url(id, url, default_folder) {

	var this_url = document.getElementById(id);
	
	if (this_url.value == '' || this_url.value == ' ' || this_url.value == default_folder) {
		this_url.value = url;
	}
}

function propogate_image_url(id) {

	var default_folder = document.getElementById('image_folder').value;
	var input_obj = document.getElementById(id);
	var curr_url = input_obj.value;
	
	if (curr_url != '' && curr_url != ' ' && curr_url != default_folder) {
	
		update_image_url('graphic',curr_url,default_folder);
		update_image_url('graphic_link',curr_url,default_folder);
		update_image_url('thumbnail',curr_url,default_folder);
		
	}
}

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
		propogate_image_url("graphic");
	});
	
	$( "#graphic_link" ).change(function() {
		redisplay_view_link("graphic_link");
		propogate_image_url("graphic_link");
	});
	
	$( "#thumbnail" ).change(function() {
		redisplay_view_link("thumbnail");
		propogate_image_url("thumbnail");
	});
	
	// Display view links at the start of the program
	redisplay_view_link("graphic");
	redisplay_view_link("graphic_link");
	redisplay_view_link("thumbnail");

};

window.onload = function () {
	prepEventHandlers();
}