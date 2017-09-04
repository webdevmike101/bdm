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
					'name'		=> 'userfile',
					'id'		=> 'input_cd_image',
					'maxlength'	=> '100',
					'class'		=> 'form_input'
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
			<?=CI_VERSION;?>
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
			</div><br/>

			<!-- Get the Description of the CD -->
			<div>
				<?=form_label('Description:', 'description')?>
				<?=form_input($description, $sd)?>
			</div><br/>

			<!-- Upload an Image of the CD -->
			<div>
				<?=form_label('Image:', 'userfile')?><!-- <input type='file' id='input_image_path' /> -->
				<?=form_upload($cd_image)?><!-- CI expects "userfile" by default. -->
			</div><br/>

			<!-- Submit the Form -->
			<div id="submit-btn-div">
				<?php echo form_submit('upload', "Upload"); ?>
			</div><br/>

			<!-- Dissplay any Errors -->
			<div id="errors">
				<?php if(isset($_SESSION['errors'])): ?>

					<input type='hidden' id='hidden-errors' value='<?php echo ($_SESSION['errors']); ?>' />

					<style type="text/css">#input_cd_image{color: red;}</style>

					<script type='text/javascript'> 

					var e = $('#hidden-errors').val();
					var eClean = e.replace(/(<([^>]+)>)/ig,"");

						alert(eClean);

					</script>
				


					<?php	
						
						unset($_SESSION['errors']);
						unset($_SESSION['title']);
						unset($_SESSION['price']);
						unset($_SESSION['release_date']);
						unset($_SESSION['description']);
						unset($_SESSION['total_songs']);
						unset($_SESSION['cd_image']);
					?>	

				<?php endif; ?>
			</div><!-- end #errors -->
		</div><!-- end editCDs_left-->
	</div><!-- end editCDs-->
	<script type="text/javascript" src="scripts/js/scheduleDetails.js"></script>
	<script type="text/javascript" src="scripts/js/lib/jquery-ui-1.10.4.custom.min.js"></script>
	
<body>
</html>





















