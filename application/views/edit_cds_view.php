<?php if(!defined('BASEPATH')) exit('No direct script access'); ?>	
	<!-- <script type="text/javascript" src="scripts/js/editCds.js"></script> -->
	<!-- <script type="text/javascript" src="scripts/js/lib/jquery-1.11.0.min.js"></script> -->

	<div id="edit-cds-div">
		<div id="edit-cds-container">
			<div id="edit-cds-left" class="form">
				<form id="cd-form" name="cd-form" action="<?php echo base_url()."edit_cds/insert_cd"; ?>" onsubmit="return validate_cd_input()" method="POST" enctype="multipart/form-data" novalidate>
					<?php 
						// echo form_open_multipart('edit_cds/insert_cd', 'id="cd-form"');
						$title = array(
							'name'		=> 'title',
							'id'		=> 'input_title',
							'maxlength'	=> '50',
							'class'		=> 'form_input',
							'required'	=> 'required'
						);
						$price = array(
							'name'		=> 'price',
							'id'		=> 'input_price',
							'class'		=> 'form_input',
							'type'		=> 'number',
							'required'	=> 'required'
						);
						$release_date = array(
							'name'		=> 'release_date',
							'id'		=> 'input_release_date',
							'class'		=> 'form_input',
							'required'	=> 'required'
						);
						$total_songs = array(
							'name'		=> 'total_songs',
							'id'		=> 'input_total_songs',
							'type'		=> 'number',
							'max'		=> '99',
							'min'		=> '1',
							'class'		=> 'form_input song_input',
							'autocomplete' => 'off',
							'required'	=> 'required'
						);
						$description = array(
							'name'		=> 'description',
							'id'		=> 'input_description',
							'class'		=> 'form_input',
							'rows'		=> '5',
							'cols'		=> '50',
							'required'	=> 'required'
						);
						$cd_image = array(
							'name'		=> 'cd_image',
							'id'		=> 'input_cd_image',
							'maxlength'	=> '100',
							'class'		=> 'form_input file_selection',
							'onchange'	=> 'check_image_file_extension()',
							'required'	=> 'required'
						);

						$errors = isset($_SESSION['errors']);

						$st = $errors ? $_SESSION['title'] : null;
						$sp = $errors ? $_SESSION['price'] : null;
						$srd = $errors ? $_SESSION['release_date'] : null;
						$sd = $errors ? $_SESSION['description'] : null;
						$sts = $errors ? $_SESSION['total_songs'] : null;									
					?>
				<h1 id="add-edit">Add New CD</h1>
		
				<!-- Get the CD Tilte -->
				<div>
					<?=form_label('Title:', 'title')?>
					<?=form_input($title, $st)?>
				</div><br/>

				<input type="hidden" id="cd-id" name="cd_id" />

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
				<input type="hidden" id="hidden-total-songs" value="<?=$sts?>" />
				<div class="form_input" id="song-input-div" style="margin-left: 50px">

					<!--  editCds.js -->

				</div><br/>

				<!-- Get the Description of the CD -->
				<div>
					<?=form_label('Description:', 'description')?></br>
					<?=form_textarea($description, $sd)?>
				</div><br/>

				<!-- Upload an Image of the CD -->
				<div>
					<?=form_label('Image:', 'cd_image')?><!-- CI expects "userfile" by default, but I'm changing it to cd_image in the controller. -->
					<?=form_upload($cd_image)?>
				</div><br/>

				<!-- Submit the Form -->
				<div id="submit-btn-div">
					<?php echo form_submit('submit-btn', "Upload"); ?>
					<span id="delete-cancel-btns-span"><!--- style="visibility: hidden"> -->
						<!-- <button type="button" id="update-btn" onclick="updateCd()">Update</button> -->
						<button type="reset" id="cancel-btn" onclick="cancelUpdate()">Cancel</button>
						<!-- <button type="button" id="delete-btn" onclick="deleteCd()" style="margin-left: 140px">Delete</button> -->
					</span>
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
			</div><!-- end #edit-cds-left-->
			<div id="edit-cds-right">
					<p style="font-weight: bold; font-size: 18px; text-align: center; margin-bottom: 10px">Click a CD to edit the details</p>
					<script> var cds = [] </script>
					<?php foreach($cds as $cd): ?>
						<script> cds[ <?php echo $cd['cd_id']; ?> ] = <?php echo json_encode($cd); ?> ; </script>
						<hr style="margin: 0 0 20px 0;"></hr>
						<div class="edit-cds-cd-list-div">
							<div class="edit-cd-image" id="<?php echo $cd['cd_id']; ?>">
								<img src="images/cds/<?php echo strtolower($cd['cd_title'])."/".$cd['image_name']; ?>" class="black" height="230" width="230">
							</div>
							<div class="edit-cd-details">
								<ul>
									<li><?php echo $cd['cd_title']; ?></li>
									<li>$<?php echo $cd['price']; ?></li>
									<li><?php echo $cd['release_date']; ?></li>
								</ul>
								<ol>			
									
									<?php for($i = 0; $i < $cd['total_songs']; ++$i): ?>
										<li id="<?php echo $cd[$i]['clip_name']; ?>"><?php echo $cd[$i]['song_title']; ?></li>
									<?php endfor; ?>
								</ol>
							</div><!-- end cdListingDiv-->
							<div class="edit-cd-description">
								<p><?php echo $cd['description']; ?></p>
							</div>						
						</div>
					<?php endforeach; ?>
					<hr style="margin: 0 0 20px 0;"></hr>
			</div><!-- end #edit-cds-right -->
		</div><!-- end #edit-cds-container -->
	</div><!-- end #edit-cds-div -->
	<script type="text/javascript" src="scripts/js/scheduleDetails.js"></script>
	<script type="text/javascript" src="scripts/js/lib/jquery-ui-1.10.4.custom.min.js"></script>
	<!-- editCds.js must be loded after the page or the number of songs can't be changed after
	     a failed upload without getting the song numbers out of whack. ////////////////////// -->
	<script type="text/javascript" src="scripts/js/editCds.js"></script>

	<!-- Display the errors //////////////////////////////////////////////////////////// -->
	<script type='text/javascript'> 

		var errors = $('#hidden-errors').val();
		// remove the html tags from the errors so they don't show in the alert box. ///////
		if(errors){
			
			var errorsClean = errors.replace(/(<([^>]+)>)/ig,"");

			alert(errorsClean);	
		}

	</script>
	
	

<body>
</html>





















