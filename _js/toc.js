// This JavaScript function creates a table of contents, based on headings of
// a tag of your choice.

// When a bookmark is provided before the tag, that bookmark is used for linking.
// When no bookmark is provided, script generates one; however, you will not be
// able to link to the generated bookmark from an external source.

// To use this function, link this file into your html in a <script> tag, then call the function on document ready.
// Here's a code snippet you can copy:

/*
	<script type="text/javascript" src="toc.js"></script>
	
	<script>
		$("document").ready(function() {
			gen_toc(false,"h4","toc");
		});
	</script>
*/

// If the first parameter is a boolean true, the function creates numbering for the TOC. Default is no numbering.
// The second parameter indicates the tag name you wish to use for TOC items; default is "h4". You may use another tag name.
// The third parameter indicates the ID of the element where you wish to drop the TOC; default is "toc". You may use another ID name.

// Snippet above explicitly uses defaults; it's equivalent to 'gen_toc();'.

function gen_toc(use_numbers,src_tag,target_id) {

	if (!src_tag) {src_tag = "h4"};
	if (!target_id) {target_id = "toc"};
	
    var counter = 1;
	var bookmark;
	var h4_text;
	var target = "#" + target_id;
	
	$(src_tag).each(function() {
	
		h4_text = $(this).text();
		bookmark = $(this).children("a:first").attr("name");

		if (use_numbers) {
			// Add index number to target's text
			$(this).prepend(counter + ". ");
		}
		
		if (bookmark) {
			$(target).append("<li><a href=\"#" + bookmark + "\">" + $(this).text() + "</a></li>");
		} else {
			$(target).append("<li><a href=\"#topic" + counter + "\">" + $(this).html() + "</a></li>");
			$(this).prepend("<a name=\"topic" + counter + "\" id=\"topic" + counter + "\"></a>");
		}
		counter++;
	});
}