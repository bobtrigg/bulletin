<?php
	
	if (defined('FANCY_BOX') && (FANCY_BOX != '')) {
		echo "<link rel=\"stylesheet\" href=\"" . FANCY_BOX .  "jquery.fancybox.css\" type=\"text/css\" media=\"screen\" />\n";
		echo "<script type=\"text/javascript\" src=\"" . FANCY_BOX . "jquery.fancybox.pack.js\"></script>\n";
	}
?>
<script>
	$(document).ready(function() {
		$('.fancybox').fancybox();
	});
</script>
