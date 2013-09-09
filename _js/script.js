function populatePics(text) {
	$(".graphic").each(function() {
		if (this.value === "") {
			this.value = text;
		}
	});
}

function redisplay(id) {

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

	$( ".graphic" ).change(function() {
		var thisText = this.value;
		populatePics(thisText);
	});
	
	$( "#graphic" ).change(function() {
		redisplay("graphic");
	});
	
	$( "#large_graphic" ).change(function() {
		redisplay("large_graphic");
	});
	
	$( "#thumbnail" ).change(function() {
		redisplay("thumbnail");
	});
	
	redisplay("graphic");
	redisplay("large_graphic");
	redisplay("thumbnail");

};

window.onload = function () {
	prepEventHandlers();
}