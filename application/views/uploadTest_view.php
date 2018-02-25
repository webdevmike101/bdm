<?php if(!defined('BASEPATH')) exit('No direct script access'); ?>
<!DOCTYPE html>
<html lang="en">
<head></head>
<body>	
	<div class="form">
			<?php 	

				echo form_open_multipart("edit_cds/uploadTest");

				$image = array(
					'name'		=> 'userfile',
					'id'		=> 'input_image',
					'class'		=> 'form_input'
					);

				$song_clip = array(
					'name'		=> 'userfile',
					'id'		=> 'input_song_clip',
					'class'		=> 'form_input'
					);
							
			?>

		<div>
			<?=form_label('Clip:', 'userfile')?><!-- CI expects "userfile" by default. -->
			<?=form_upload($song_clip)?>
		</div><br/>

			<!-- Upload an Image of the CD -->
		<div>
			<?=form_label('Image:', 'userfile')?><!-- <input type='file' id='input_image_path' /> -->
			<?=form_upload($image)?><!-- CI expects "userfile" by default. -->
		</div><br/>

		<!-- Submit the Form -->
		<div id="submit-btn-div">
			<?php echo form_submit('upload', "Upload"); ?>
		</div>
	</div>
</body>
</html>





















