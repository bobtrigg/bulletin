<?php

// A little housekeeping
$max_file_size = 1048576;

if ((!isset($item_object->bulletin_date)) || is_null($item_object->bulletin_date) || ($item_object->bulletin_date == '')) {
	$year = date('Y');
	$item_object->bulletin_date = '';
} else {
	$components = explode('/',$item_object->bulletin_date);
	if (count($components) >= 2) {
		$year = $components[2];
	} else {
		$year = date('Y');
	}
}
?>

<div id="text_entries">
	<p>
		<label for="bulletin_date">Date: </label>
		<input type="text" name="bulletin_date" id="bulletin_date" value="<?php echo $item_object->bulletin_date;?>" size="40" maxlength="60" />
	</p>
	<p>
		<!-- Tooltip -->
		<a href="#" data-tip-type="text" data-tip-source="Suggestion: use multiples of 5 or 10 to more easily rearrange items." class="tooltip"><img src="Images/InfoIconTrnsprnt30.png" class="info_button" /></a>
		
		<label for="position">Position:&nbsp;&nbsp;&nbsp;</label>
		<input type="text" name="position" id="position" value="<?php echo $item_object->position; ?>" size="2" maxlength="2" />
	</p>

	<p>
		<label for="title">Title: </label>
		<input type="text" name="title" id="title" value="<?php echo $item_object->title; ?>" size="40" maxlength="200" />
	</p>
	<p>
		<label for="subtitle">Subtitle: </label>
		<input type="text" name="subtitle" id="subtitle" value="<?php echo $item_object->subtitle; ?>" size="40" maxlength="200" />
		<br><a href="#" id="dupe_subtitle">Use this for the excerpt</a>
	</p>
	<p>
		<!-- Tooltip -->
		<a href="#" data-tip-type="text" data-tip-source="This bookmarks this item so it can be easily found by a browser. if not specified, a less user-friendly default value will be used." class="tooltip"><img src="Images/InfoIconTrnsprnt30.png" class="info_button" /></a>
		
		<label for="bookmark">Bookmark: </label>
		<input type="text" name="bookmark" id="bookmark" value="<?php echo $item_object->bookmark; ?>" size="40" maxlength="200" />
	</p>

	<p>
		<label for="content">Content:<br>
		</label>
		<textarea name="content" id="content" cols="70" rows="25"><?php echo $item_object->content; ?></textarea>
	</p>
	<p>
		<label for="excerpt">Excerpt:<br></label>
		<textarea name="excerpt" id="excerpt" cols="70" rows="10"><?php echo $item_object->excerpt; ?></textarea>
	</p>
</div>

<div id="graphic_entries">

	<h3>Specify image URLs, or upload files:</h3>

	<p>
		<a href="upload.php?year=<?php echo $year ?>" target="_blank">Upload a file</a>
	</p>

	<p>
		<!-- Tooltip -->
		<a href="#" data-tip-type="text" data-tip-source="This file will go into the web page bulletin, in line with text." class="tooltip"><img src="Images/InfoIconTrnsprnt30.png" class="info_button" /></a>
		
		<label for="graphic">Inline file URL:</label>
		<input type="text" name="graphic" id="graphic" class="graphic" value="<?php echo $item_object->graphic; ?>" maxlength="200"  />
		<br><a href="#" id="graphic_view" class="fancybox view_link" target="_blank"></a>

		</p>

	<p>
		<!-- Tooltip -->
		<a href="#" data-tip-type="text" data-tip-source="Provide a short description for non-displaying browsers and assistive technology." class="tooltip"><img src="Images/InfoIconTrnsprnt30.png" class="info_button" /></a>
		
		<label for="alt_text">Alt text:</label>
		<input type="text" name="alt_text" id="alt_text" value="<?php echo $item_object->alt_text; ?>" maxlength="200"  />
	</p>
	
	<p>
		<!-- Tooltip -->
		<a href="#" data-tip-type="text" data-tip-source="This is the largest graphic. Ideal max dimension 1200 pixels." class="tooltip"><img src="Images/InfoIconTrnsprnt30.png" class="info_button" /></a>
		
		<label for="graphic_link">Large graphic file URL:</label>
		<input type="text" name="graphic_link" id="graphic_link" class="graphic" value="<?php echo $item_object->graphic_link; ?>" maxlength="200" />
		<br><a href="#" id="graphic_link_view" class="fancybox view_link" target="_blank"></a>
	</p>

	<p>
		<!-- Tooltip -->
		<a href="#" data-tip-type="text" data-tip-source="Provide a small file for your email. If you leave this blank, a larger file will be used, increasing bandwidth." class="tooltip"><img src="Images/InfoIconTrnsprnt30.png" class="info_button" /></a>
		
		<label for="thumbnail">Thumbnail file URL:</label>
		<input type="text" name="thumbnail" id="thumbnail" class="graphic" value="<?php echo $item_object->thumbnail; ?>" maxlength="200"  />
		<br><a href="#" id="thumbnail_view" class="fancybox view_link" target="_blank"></a>
	</p>

</div>
	
<?php 
	if (isset($_SESSION['date']) && $_SESSION['date'] != '') {
		$return_str = "?date=" . $_SESSION['date'];
	} else {
		$return_str = ""; 
	}
?>

<p>&nbsp;&nbsp;&nbsp;
	
	Approved: <input name="approved" type="checkbox" id="approved" <?php if ($item_object->approved) {echo "checked";} ?>>&nbsp;&nbsp;&nbsp;

	<?php   // Add 'Previouw' button if editing and previous item exists
		if (!is_null($prev_item_id)) {
			echo "<input type=\"submit\" name=\"submit\" id=\"previous\" value=\"Previous\" />&nbsp;&nbsp;\n";
		}
	?>
	
	<input type="submit" name="submit" id="submit" value="Save and Return" />&nbsp;&nbsp;
	
	<?php   // Add 'Next' button if editing and next item exists
		if (!is_null($next_item_id)) {
		echo "<input type=\"submit\" name=\"submit\" id=\"next\" value=\"Next\" />&nbsp;&nbsp;\n";
		}
	?>
	
	<a href="list_items.php<?php echo $return_str; ?>"><input type="button" name="cancel" id="cancel" value="Cancel"></a>
	<input id="image_folder" type="hidden" value="<?php echo parse_date_string(IMAGE_FOLDER,new DateTime($item_object->bulletin_date)) ?>" />
	<input name="submitted" type="hidden" id="submitted" value="true" />
</p>
