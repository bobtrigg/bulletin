	<tr>
		<td style="background-color:<?php echo CUSTOM_BAR_BGCOLOR;?>;">
			<p style="margin-top:5px;margin-bottom:5px;margin-left:5px;font-family:Arial,Helvetica,sans-serif;font-size:16px;font-weight:bold;color:<?php echo CUSTOM_BAR_TEXT_COLOR;?>;">

			<?php echo $item_title; ?>
			
			</p>
		</td>
	</tr>
	<tr style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;" >
		<td style="font-size:12px;font-family:Verdana,Arial,Helvetica,sans-serif;margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;">
			<table width="100%"  border="0">
				<tr>
					<td width="110" valign="top">
						<p align="center"  style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;" >
						
							<?php 
								$dimensions = isset($image_url) ? resize_picture($image_url, 100) : array(0.0);
							?>

							<?php echo '<a href="' . make_full_url($webfile_url) . '#' . generate_bookmark($item_title) . '" target="_blank">'; ?>

								<img src="<?php echo make_full_url($image_url); ?>" alt="<?php echo $alt_text; ?>" style="margin-top:5px;margin-bottom:5px;padding-top:0;padding-bottom:0;" alt="<?php echo $item_title; ?>" width="<?php echo $dimensions[0]; ?>" height="<?php echo $dimensions[1]; ?>" border="0">
							</a>
						</p>
					</td>
					<td valign="top">
						<p style="font-size:12px;font-family:Arial,Helvetica,sans-serif;margin-top:10px;margin-left:10px;margin-bottom:0;padding-top:0;padding-bottom:0;">
						
						<?php echo $item_excerpt; ?>
						
						</p>
						<p style="font-size:12px;font-family:Arial,Helvetica,sans-serif;margin-top:10px;margin-left:10px;margin-bottom:0;padding-top:0;padding-bottom:0;">
					  
						<?php 
							echo '<a href="' . make_full_url($webfile_url) . '#' . generate_bookmark($item_title) . '">';
							echo '<b>Read more &gt;&gt;</b></a>';
						?>
						
						</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
