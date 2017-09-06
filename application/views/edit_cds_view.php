<?php if(!defined('BASEPATH')) exit('No direct script access'); ?>	
	<!-- <script type="text/javascript" src="scripts/js/editCds.js"></script> -->
	<!-- <script type="text/javascript" src="scripts/js/lib/jquery-1.11.0.min.js"></script> -->
	<div id="editCDs">
		<div id="editCDs_left" class="form">
			<?php 

				echo form_open_multipart("edit_cds/insert_cd");

				$title = array(
					'name'		=> 'title',
					'id'		=> 'input_title',
					'maxlength'	=> '50',
					'class'		=> 'form_input'
					);

				$price = array(
					'name'		=> 'price',
					'id'		=> 'input_price',
					'maxlength'	=> '5',
					'minlength'	=> '5',
					'class'		=> 'form_input'
					);

				$release_date = array(
					'name'		=> 'release_date',
					'id'		=> 'input_release_date',
					'class'		=> 'form_input'
					);

				$total_songs = array(
					'name'		=> 'total_songs',
					'id'		=> 'input_total_songs',
					'maxlength'	=> '99',
					'minlength'	=> '1',
					'class'		=> 'form_input song_input',
					'autocomplete' => 'off'
					);

				$description = array(
					'name'		=> 'description',
					'id'		=> 'input_description',
					'class'		=> 'form_input'
					);

				$cd_image = array(
					'name'		=> 'cd_image',
					'id'		=> 'input_cd_image',
					'maxlength'	=> '100',
					'class'		=> 'form_input file_selection'
					);

				$st = ""; // SESSION title
				$sp = ""; // SESSION price
				$srd = ""; // SESSION release_date
				$sts = ""; // SESSION total_songs
				$sd = ""; // SESSION description

				if(isset($_SESSION['errors'])){

					$st = $_SESSION['title'];
					$sp = $_SESSION['price'];
					$srd = $_SESSION['release_date'];
					$sd = $_SESSION['description'];
					$sts = $_SESSION['total_songs'];
				}
							
			?>
			<h1>Edit CD's</h1>
	
			<!-- Get the CD Tilte -->
			<div>
				<?=form_label('Title:', 'title')?>
				<?=form_input($title, $st)?>
			</div><br/>

			<!-- Get the CD Price -->
			<div>
				<?=form_label('Price: $', 'price')?>
				<?=form_input($price, $sp)?>
			</div><br/>

			<!-- Get the CD Release Date -->
			<div>
				<?=form_label('Release Date:', 'release_date')?>
				<?=form_input($release_date, $srd)?>
			</div><br/>

		<!-- Get the Total Number of Songs on the CD -->
			<div>
				<?=form_label('Total Songs:', 'total_songs')?>
				<?=form_input($total_songs, $sts)?>

				<!-- A button to bring up the song title input fields -->
				<div style="display: inline; margin-left: 10px;">
					<input type="button" id="enterSongTitles" value="Enter Song Titles" onclick="enterSongTitle()" />
				</div>
			</div><br/>

			<!-- Get the song titles -->
			<div class="form_input" id="song-input-div" style="margin-left: 50px">
				<?php if(isset($_SESSION['total_songs']) && $_SESSION['total_songs'] > 0): ?>
					<input type="hidden" id="hidden-total-songs" value="<?=$sts?>" />
					<?php for($i = 1; $i <= $_SESSION['total_songs']; $i++): ?>
						<div class='song-title-div' id='song-title-div-<?=$i?>'>
							<label>Song <?=$i?></label>
							<input type='text' size='50' autocomplete='off' class='form_input' id='song-title-input-<?=$i?>' name='song_<?=$i?>' value='<?php echo($_SESSION["song_$i"]); ?>'/>
							<br/><div>
								<label>Song Clip</label>
								<input type='file' class='form_input file_selection' id='song-clip-input-'<?=$i?> name='song_clip_<?=$i?>'/>
							</div>
						</div>
					<?php endfor; ?>
				<?php endif; ?>
			</div><br/>

			<!-- Get the Description of the CD -->
			<div>
				<?=form_label('Description:', 'description')?>
				<?=form_input($description, $sd)?>
			</div><br/>

			<!-- Upload an Image of the CD -->
			<div>
				<?=form_label('Image:', 'cd_image')?><!-- CI expects "userfile" by default, but I'm changing it to cd_image in the controller. -->
				<?=form_upload($cd_image)?>
			</div><br/>

			<!-- Submit the Form -->
			<div id="submit-btn-div">
				<?php echo form_submit('upload', "Upload"); ?>
			</div><br/>

			<!-- Dissplay any Errors -->
			<div id="errors">
				<?php if(isset($_SESSION['errors'])): ?>

					<!-- Make errors easily accessable by javascript to display them in an alert box
						 rather than taking up space on the web page ///////////////////////////////// -->
					<input type='hidden' id='hidden-errors' value='<?php echo ($_SESSION['errors']); ?>' />

					<!-- Set the text in the Choose file box to red to make it obvious that the user
					     needs to reselect the file when there are errors ////////////////////////////// -->
					<style type="text/css">.file_selection{color: red;}</style>

					<!-- Display the errors //////////////////////////////////////////////////////////// -->
					<script type='text/javascript'> 

						var errors = $('#hidden-errors').val();
						// remove the html tags from the errors so they don't show in the alert box. ///////
						var errorsClean = errors.replace(/(<([^>]+)>)/ig,"");

							alert(errorsClean);

					</script>

					<?php	
						
						unset($_SESSION['errors']);
						unset($_SESSION['title']);
						unset($_SESSION['price']);
						unset($_SESSION['release_date']);
						unset($_SESSION['description']);
								
						$num_songs = $this->input->post('total_songs');

						for($i = 1; $i <= $num_songs; $i++)
						{
							unset($_SESSION['song_'.$i]);
							unset($_SESSION['song_clip_'.$i]);
						}

						unset($_SESSION['total_songs']);
						// unset($_SESSION['cd_image']);
					?>	

				<?php endif; ?>
			</div><!-- end #errors -->
		</div><!-- end editCDs_left-->
	</div><!-- end editCDs-->
	<script type="text/javascript" src="scripts/js/scheduleDetails.js"></script>
	<script type="text/javascript" src="scripts/js/lib/jquery-ui-1.10.4.custom.min.js"></script>
	<!-- editCds.js must be loded after the page or the number of songs can't be changed after
	     a failed upload without getting the song numbers out of whack. ////////////////////// -->
	<script type="text/javascript" src="scripts/js/editCds.js"></script>
	
<body>
</html>





















