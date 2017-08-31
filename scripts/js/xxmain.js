// Mike Guillory
// Credo Web Development
// 20160403

$(document).ready(function(){

	var currentPage = location.pathname.split('/').slice(-1)[0];

	// add class="current" to link of current page
	if(currentPage == ""){
		$("a[href$='home']").addClass("current");
	}
	else{
		$("a[href$='"+currentPage+"']").addClass("current");
	}

	// if user clicks "listen here" link on home page fade in #listenPage after redirecting to buy page
	if(localStorage.getItem('lastPage')){
		$('#listenPage').fadeIn(600);
		localStorage.removeItem('lastPage');
	};
	
	// fade in #listenPage when user clicks "Click here to listen to samples"
	$('.listenClick').click(function(e){
		e.preventDefault();
		$('#listenPage').fadeIn(300);
	});
		
	// audio.js player from http://kolber.github.io/audiojs/
	$(function() { 
		// Setup the player to autoplay the next track
		var a = audiojs.createAll({});
		
		// Load in the first track
		var audio = a[0];
		first = $('ol a').attr('data-src');
		title = $('li').first().text();			
		$('ol li').first().addClass('playing');
		audio.load(first);
		$("#titlePlaying").text(title);

		// Load in a track on click
		$('ol li a').click(function(e) {
			e.preventDefault();
			$(this).parent().css('background-color', '#999').siblings().css('background-color', '#fff');
			title = ($(this).text());
			$("#titlePlaying").text(title);
			audio.load($(this).attr('data-src'));
			audio.play();
		});

		// fade out #listenPage when user clicks "Close"
		$('#close').click(function(e){
			e.preventDefault();
			audio.pause();
			$('#listenPage').fadeOut(300);	
		})
		
		// prevent default behavior when user clicks "Click here to listen to samples" link
		$('#samples').click(function(e) {
		  e.preventDefault();
		});
    });	
    // end audio.js	  
});