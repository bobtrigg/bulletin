<p>
	<label for="bulletin_date">Date: </label>
	<input type="text" name="bulletin_date" id="bulletin_date" value="<?php echo $bulletin_date; ?>" size="40" maxlength="60" />
</p>
<p>
	<label for="title">Title: </label>
	<input type="text" name="title" id="title" value="<?php echo $title; ?>" size="40" maxlength="60" />
</p>
<p>
	<label for="subtitle">Subtitle: </label>
	<input type="text" name="subtitle" id="subtitle" value="<?php echo $subtitle; ?>" size="40" maxlength="60" />
</p>

<?php 	$max_file_size = 1048576; ?>

<p>
	<label for="content">Content:<br>
	</label>
	<textarea name="content" id="content" cols="70" rows="10"><?php echo $content; ?></textarea>
</p>
<p>
	<label for="excerpt">Excerpt: </label>
	<br>
	<input type="text" name="excerpt" id="excerpt" value="<?php echo $excerpt; ?>" size="80" maxlength="200" />
</p>

<p>Specify an image URL, or upload a file:</p>

	<blockquote>
		<p>
			<label for="img_file">Upload</label>
			<br>
			<!-- <input type="file" name="img_file" id="img_file" >  -->

			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size;?>" />
			<p><input type="file" name="file_upload" /></p>

		</p>

		<p>
			<label for="graphic">File URL: </label>
			<br>
			<input type="input" name="graphic" id="graphic" value="<?php echo $graphic; ?>" size="80" maxlength="200"  />
		</p>

		<p>
			<label for="alt_text">Alt text: </label>
			<br>
			<input type="input" name="alt_text" id="alt_text" value="<?php echo $alt_text; ?>" size="80" maxlength="200"  />
		</p>
		
		<p>
			<label for="thumbnail">File URL: </label>
			<br>
			<input type="input" name="thumbnail" id="thumbnail" value="<?php echo $thumbnail; ?>" size="80" maxlength="200"  />
		</p>

	</blockquote>
	
<p>
	<label for="position">Position: </label>
	<input type="text" name="position" id="position" value="<?php echo $position; ?>" size="2" maxlength="2" />
</p>

<?php 
	if (isset($_SESSION['date']) && $_SESSION['date'] != '') {
		$return_str = "?date=" . $_SESSION['date'];
	} else {
		$return_str = ""; 
	}
?>

<p>&nbsp;&nbsp;&nbsp;
	<input type="submit" name="submit" id="submit" value="Submit" />&nbsp;&nbsp;
	<a href="list_items.php<?php echo $return_str; ?>"><input type="button" name="cancel" id="cancel" value="Cancel"></a>

	</p>
<p>
	<input name="submitted" type="hidden" id="submitted" value="true" />
</p>
