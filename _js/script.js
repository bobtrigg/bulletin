function populatePics(text) {
	$(".graphic").each(function() {
		if (this.value === "") {
			this.value = text;
		}
	});
}
// create those event handlers.

function prepEventHandlers() {

	$( ".graphic" ).change(function() {
		var thisText = this.value;
		populatePics(thisText);
	});

};

window.onload = function () {
	prepEventHandlers();
}