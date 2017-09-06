<?php if(!defined('BASEPATH')) exit('No direct script access'); ?>


		<div id="listenPage">	
			<div id="listenFrame">
				<div id="listenDiv">			
					<div id="samplingCdCoverImageDiv">
						<img id="samplingCdCoverImage" height="213" width="213"></img>
					</div><!-- end #samplingCdCoverImageDiv -->
					<div id="songListDiv">
						<ol id="playlist">	
						</ol><!-- end #playlist -->
					</div><!-- end #songListDiv -->
					<div id="playerDiv">
						<audio></audio>
					</div><!-- end #playerDiv -->
				</div><!-- end #listenDiv -->
				<div id="closeDiv">
					<a id="close" href="#">Close</a>
				</div><!-- end #closeDiv -->
			</div><!-- end #listenFrame -->
			<div id="listenBackGround">
			</div><!-- end #listenBackGround -->
		</div><!-- end  #listenPage-->



<p style="text-align: center; font-size: 20px; font-family: 'times new roman'; font-weight: bold; margin-top: 30px">Purchase Brian Dorsey's CDs either through the PayPal<br/> button below, or by emailing your request to bdorsey@bell.net</p>
<hr/ style="margin-bottom: -30px">
<div>

	<?php 	

		$previousCD = null;
		$previousSong = null; 

	?>

	<?php foreach($cds as $cd): ?>

		<?php $middleSong = round($cd['total_songs']/2, PHP_ROUND_HALF_DOWN) + 1; ?>
	
		<!-- SEE XAMPP\HTDOCS\PHP\PDO\CONNECT.PHP !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->
			
		<div class="cdListingDiv" id="cd_<?php echo $cd['cd_id'] ?>">
			<div class="cdImageDiv">
				<img src="images/cds/<?php echo $cd['image_name']; ?>" height="230" width="230">
			</div>
			<h3 class="cdTitle"><?php echo $cd['cd_title']; ?></h3>
			<ol class="songList">
				<?php if(isset($cd[0])): ?>			
			
					<?php for($i = 0; $i < $cd['total_songs']; ++$i): ?>

						<?php if($cd[$i]['song_number'] ==  $middleSong): ?>
					
							</ol>
							<ol class="singList" start="<?php echo $middleSong; ?>">

						<?php endif; ?>

						<?php 
								$songTitle = $cd[$i]['song_title']; 
								$clipName = $cd[$i]['clip_name'];
								$cdTitle = $cd['cd_title'];
						?>
						<li data-src="music/clips/<?php echo $cdTitle."/".$clipName; ?>"><?php echo $songTitle; ?></li>

					<?php endfor; ?>
				<?php endif; ?>

			</ol>
			<a id="samples_<?php echo $cd['cd_id'] ?>" href="#" class="listenClick">Click here to listen to samples</a>
			<h5 class="price"><?php echo "$". $cd['price']; ?></h5>
			<h6 class="shippingIncluded"><?php echo "Shipping Included"; ?></h6>
			<div class="payPalBuyDiv">
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="6JZJBBTSHT426">
					<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer way to pay online!">
					<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
				</form>
			</div><!-- end payPalBuyDiv -->
			<h4 class="cdDescription"><?php echo $cd['description']; ?></h4>
		</div><!-- end cdListingDiv-->

		<div id="playerDiv<?php echo $cd['cd_id']; ?>">
			<!-- <audio></audio> -->
		</div><!-- end #playerDiv -->

		<hr/>
	<?php endforeach; ?>

</div>
<p style="color: #ff0000; font-family: 'times new roman'; font-style: italic; font-size: 36px; font-weight: bold; text-align: center; margin: 100px 0 50px 0">Watch for Brian's new CD coming soon!</p>
<p style="text-align: center">If you would like to help Brian Dorsey Ministries</p>
<div id="payPalDonateDiv" style="text-align: center; margin-bottom: 100px">
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="9Q56VPRFFRGPJ">
						<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer way to pay online!">
						<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
					</form>
				</div><!-- end #payPalDonateDiv -->