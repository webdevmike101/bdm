<?php if(!defined('BASEPATH')) exit('No direct script access'); ?>	
	<!-- <script type="text/javascript" src="scripts/js/editCds.js"></script> -->
	<!-- <script type="text/javascript" src="scripts/js/lib/jquery-1.11.0.min.js"></script> -->
	<div id="editCDs"></div>
		<div id="editCDs_left" class="form">
			<?php 

				// if(isset($_SESSION["num_songs"]))
				// {
				// 	echo $_SESSION["song1"];
				// 	unset($_SESSION['num_songs']);
				// }		

				echo form_open_multipart("edit_cds/insert_cd");

				$image_path = array(
					'name'		=> 'userfile',
					'id'		=> 'input_image_path',
					'maxlength'	=> '100',
					'class'		=> 'form_input'
					);

				$song_clip = array(
					'name'		=> 'userfile',
					'id'		=> 'input_song_clip',
					'class'		=> 'form_input'
					);

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

				$date_id = 'id="datepicker"';
				$price_placeholder = 'placeholder="00.00"';
		
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
							}

							if(isset($_SESSION['total_songs'])){
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
				<?=form_input($price, $sp, $price_placeholder)?>
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
					<input type="hidden" id="hidden-total-songs" value="<?=sizeof($_SESSION['songTitles'])?>" />
					<?php foreach ($_SESSION['songTitles'] as $key => $song): ?>
						<div class='song-title-div' id='song-title-div-<?=$key + 1?>'>
							<label>Song <?=$key + 1?></label>
							<input type='text' size='50' class='form_input' id='song-title-input-<?=$key + 1?>' name='song_<?=$key + 1?>' value='<?=$song?>'/>
							<br/><div>
								<?=form_label('Song Clip:', 'userfile')?><!-- CI expects "userfile" by default. -->
								<?=form_upload($song_clip)?>
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div><br/>

			<!-- Get the Description of the CD -->
			<div>
				<?=form_label('Description:', 'description')?>
				<?=form_input($description, $sd)?>
			</div><br/>

			<!-- Upload an Image of the CD -->
			<div>
				<?=form_label('Image:', 'userfile')?><!-- <input type='file' id='input_image_path' /> -->
				<?=form_upload($image_path)?><!-- CI expects "userfile" by default. -->
			</div><br/>

			<!-- Submit the Form -->
			<div id="submit-btn-div">
				<?php echo form_submit('upload', "Upload"); ?>
			</div><br/>

			<!-- Dissplay any Errors -->
			<div id="errors">
				<?php
					if(isset($_SESSION['errors'])){

						echo $_SESSION['errors'];		
						unset($_SESSION['errors']);
					}	
				?>
			</div><!-- end #errors -->

			<div id="song-list-div">
				<!-- A space to list the songs -->
			</div><!-- end song-list-div-->

		</div><!-- end editCDs_left-->
		
	</div><!-- end editCDs-->
	<script type="text/javascript" src="scripts/js/scheduleDetails.js"></script>
	<script type="text/javascript" src="scripts/js/lib/jquery-ui-1.10.4.custom.min.js"></script>

	<script type="text/javascript">

		// Set the focus on the input for total number of songs after a release date is selected
		$('#input_release_date').focusout(function(){

			$('#input_total_songs').focus();

		});

		// Set up for displaying the correct number of song title fields after the total number of songs has been entered
		// and the Enter Song Titles button has been clicked
		// If we're coming back through because there were validation errors, "first_time_through" needs to be set to something other than
		// undefined, so it is set to the number of songs previously entered. That makes it easy to also set total_songs to the correct
		// number incase changes are made to the number of songs entered.
		var first_time_through = parseInt($('#hidden-total-songs').val());		
		var total_songs = first_time_through;

		function enterSongTitle(){

			if(checkForNumbersOnly($('#input_total_songs').val())){

				if(first_time_through === undefined || isNaN(first_time_through)){

					first_time_through = 1;

					// I'm not going to parseInt() total_songs so it can be matched against the regex
					total_songs = $('#input_total_songs').val();

					for(i = 1; i <= total_songs; i++){

						$("#song-input-div").append("<div class='song-title-div' id='song-title-div-" + i + "'>"+
															"<label>Song " + i + "</label>&nbsp;"+
															"<input type='text' size='50' class='form_input' id='song-title-input-" + i + "' name='song_" + i + "'/>"+
														"<br/><div>"+
																"<label for='userfile'>Song Clip:</label><!-- CI expects 'userfile' by default. -->"+
																"<input type='file' name='userfile' id='input_song_clip' class='form_input' />"+
															"</div>"+
														"</div>");
					}
				}
				else{
					var newTotal = parseInt($("#input_total_songs").val());
					var changeInTotal = 0;;

					if(newTotal < total_songs){
						var last = total_songs;
						changeInTotal = parseInt(total_songs) - parseInt(newTotal);
						total_songs = parseInt(total_songs) - changeInTotal;

						for(i = 1; i <= changeInTotal; i++){
							$('#song-title-div-' + last).remove();
							last--;
							//$('div:last-child', '#song-input-div').remove();
						}
					}
					else{
						changeInTotal = parseInt(newTotal)  - parseInt(total_songs);
						var oldTotal = parseInt(total_songs);
						total_songs = parseInt(total_songs)  + parseInt(changeInTotal) ;
						for(i = 1; i <= changeInTotal; i++){
							$("#song-input-div").append("<div class='song-title-div' id='song-title-div-" + (oldTotal + i) + "'>"+
															"<label>Song " + (oldTotal + i) + "</label>&nbsp;"+
															"<input type='text' size='50' class='form_input' id='song-title-input-" + (oldTotal + i) + "' name='song_" + (oldTotal + i) + "'/>"+
															"<br/><div>"+
																"<label for='userfile'>Song Clip:</label><!-- CI expects 'userfile' by default. -->"+
																"<input type='file' name='userfile' id='input_song_clip' class='form_input' />"+
															"</div>"+
														"</div>");
						}	
					}
				}	
			}
			else{

			 	alert("Please enter a valid number of songs.");
				// entry = undefined;
			}
		}

		function checkForNumbersOnly (numberOfSongs) {

			var only_numbers = /^[0-9]{1,2}$/; // from start "^" to end "$" any numbers from 0 to 9 "[0-9]" and only 1 or 2 numbers "{1,2}". All inclosed in two forward slashes
			if(numberOfSongs.match(only_numbers)){

			 	return true;
			 }
		}

		// Disable the enter key to avoid prematurely submitting the form
		$('.form_input').keypress(function(event){
			if(event.which == 13 || event.which == 10){
				event.preventDefault();
				alert("Please use the Tab key.");
			}
		})

	</script>
<body>
</html>





















