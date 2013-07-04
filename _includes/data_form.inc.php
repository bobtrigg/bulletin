<p>
	<label for="bulletin_date">Date: </label>
	<input type="text" name="bulletin_date" id="bulletin_date" value="<?php echo display_date($bulletin_date); ?>" size="40" maxlength="60">
</p>
<p>
	<label for="title">Title: </label>
	<input type="text" name="title" id="title" value="<?php echo $title; ?>" size="40" maxlength="60">
</p>
<p>
	<label for="subtitle">Subtitle: </label>
	<input type="text" name="subtitle" id="subtitle" value="<?php echo $subtitle; ?>" size="40" maxlength="60">
</p>
<p>
	<label for="content">Content:<br>
	</label>
	<textarea name="content" id="content" cols="70" rows="10"><?php echo $content; ?></textarea>
</p>
<p>
	<label for="excerpt">Excerpt: </label>
	<br>
	<input type="text" name="excerpt" id="excerpt" value="<?php echo $excerpt; ?>" size="80" maxlength="200">
</p>

<p>Specify an image URL, or upload a file:</p>

	<blockquote>
		<p>
			<label for="img_file">Upload</label>
			<br>
			<input type="file" name="img_file" id="img_file" >
		</p>
		
		<p>
			<label for="graphic">File URL: </label>
			<br>
			<input type="input" name="graphic_link" id="graphic_link" size="80" maxlength="200">
		</p>
	</blockquote>
	
<p>
	<label for="position">Position: </label>
	<input type="text" name="position" id="position" value="<?php echo $position; ?>" size="2" maxlength="2">
</p>
<p>&nbsp;&nbsp;&nbsp;
	<input type="submit" name="submit" id="submit" value="Submit">
</p>
<p>
	<input name="submitted" type="hidden" id="submitted" value="true">
</p>
