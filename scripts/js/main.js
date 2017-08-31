// Mike Guillory
// Credo Web Development
// 20160403

$(document).ready(function(){

	//////////////////////////////////////////////////////////////////////////////////////////////////////
	// Current page ///////////////////////////////////////////////////////////////////////////////////

	var currentPage = location.pathname.split('/').slice(-1)[0];

	// add class="current" to link of current page
	if(currentPage == ""){
		$("a[href$='home']").addClass("current");
	}
	else{
		$("a[href$='"+currentPage+"']").addClass("current");
	}

	// end Current page ///////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////


	//////////////////////////////////////////////////////////////////////////////////////////////////////
	// if user clicks "listen here" link on home page fade in #listenPage after redirecting to buy page

	if(localStorage.getItem('lastPage')){
		$('#listenPage').fadeIn(600);
		localStorage.removeItem('lastPage');
	};

	//////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////

	// fade in #listenPage when user clicks "Click here to listen to samples"
	$('[id^=samples]').click(function(e){
		e.preventDefault();
		
		var cdId = '#' + $(e.target).parent().attr('id');
		var cdImage = $(cdId + ' img:first').attr('src');

		$('#samplingCdCoverImage').attr('src', cdImage);

		// Populate li's with song title links for the cd for which the user clicked "Click here to listen to samples"
		$.each($(cdId + ' li'), function(){
			$('#playlist').append('<li> <a href="#" data-src="' + $(this).attr('data-src') + '">' + $(this).text() + '</a></li>');
		});

		// audio.js player from http://kolber.github.io/audiojs/





		// Setup the player to autoplay the next track

			// It doesn't at the momment
			// Maybe you can use the code below

	            // var a = audiojs.createAll({
	            //     trackEnded: function() {
	            //         var next = $('ol li.playing').next();
	            //         if (!next.length) next = $('ol li').first();
	            //         next.addClass('playing').siblings().removeClass('playing');
	            //         audio.load($('a', next).attr('data-src'));
	            //         audio.play();
	            //     }





		// Don't create new players if there already is one
		if($('audio').attr('src') == null)
		{
			initializeAudioPlayer();
		};
		
		// Clear out the error message from previous error and reset the player
		$('.audiojs').removeClass('error');

		// Load the first song clip in the list
		a[0].load($('#playlist a:first').attr('data-src'));
		// Set the background to gray
		$('#playlist li:first').css('background-color', '#999');
		// Start the clip playing
		a[0].play();

		$('#listenPage').fadeIn(300);

		// Load in a track on click
		$('#playlist li a').click(function(e) {
			e.preventDefault();
			$('.audiojs').removeClass('error');
			$(this).parent().css('background-color', '#999').siblings().css('background-color', '#fff');
			title = ($(this).text());
			$("#titlePlaying").text(title);
			a[0].load($(this).attr('data-src'));
			// a[0].load($(e.target).attr('data-src'));
			a[0].play();
		});

		// fade out #listenPage when user clicks "Close"
		$('#close').click(function(e){
			e.preventDefault();
			fadeOutListenPage();
		});
	})  

	function initializeAudioPlayer()
	{
		a = audiojs.createAll({});
	}

	function fadeOutListenPage()
	{
		a[0].pause();
		$('#listenPage').fadeOut(300);	
		$('#playlist').empty();
	}
});