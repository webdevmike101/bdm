<div>

	<?php 	

		$previousCD = null;
		$previousSong = null; 

	?>

	<?php foreach($cds as $cd): ?>

		<?php $middleSong = round($cd['total_songs']/2, PHP_ROUND_HALF_DOWN) + 1; ?>
	
		<?php if($cd['song_title']): ?>

			<?php if($cd['cd_title'] != $previousCD): ?>
			
				<div class="" style="margin-top: 50px; height: 220px">
					<div class="" style="float: left; width: 220px; height: 220px">
						<img src="<?php echo $cd['image_path']; ?>" height="220" width="220">
					</div>
					<h3 class="" style="float: left; width: 80%; margin-top: 10px; padding-left: 10px"><?php echo $cd['cd_title']; ?></h3>
					<ol class="" style="float: left; height: 120px; width: 280px">
					<?php $previousCD = $cd['cd_title']; ?>
				
			<?php endif; ?>
			
			<?php if($cd['song_title'] != $previousSong): ?>

				<?php if($cd['song_number'] ==  $middleSong): ?>
				
						</ol>
						<ol class="" start="<?php echo $middleSong; ?>" style="float: left; height: 120px; width: 280px">

				<?php endif; ?>

					<li><?php echo $cd['song_title']; ?></li>
					<?php $previousSong = $cd['song_title']; ?>
					
			<?php endif; ?>
			
			<?php if($cd['song_number'] == $cd['total_songs']): ?>
				
					</ol>
					<a href="#" class="">Click here to listen to samples</a>
					<h5 class="" style="width: 200px; float: left; margin: 0; text-align: center"><?php echo "$". $cd['price']; ?></h5>
					<h6 class="" style="width: 200px; float: left; margin: 0; text-align: center"><?php echo "Shipping Included"; ?></h6>
					<div id="payPalBuyDiv" class="">
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
							<input type="hidden" name="cmd" value="_s-xclick">
							<input type="hidden" name="hosted_button_id" value="6JZJBBTSHT426">
							<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer way to pay online!">
							<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
						</form>
					</div><!-- end#payPalBuyDiv -->
					<h4 class="" style="width: 80%; float: left; margin-top: 0; padding-left: 10px"><?php echo $cd['description']; ?></h4>
				</div>
				
			<?php endif; ?>

		<?php endif; ?>

	<?php endforeach; ?>

</div>