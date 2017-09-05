// Mike Guillory
// Credo Web Development
// 201709041

$(document).ready(function(){

	//alert("WORKING!!!!!");

	// Set the focus on the input for total number of songs after a release date is selected
	$('#input_release_date').focusout(function(){

		$('#input_total_songs').focus();

	});



	

	// Disable the enter key to avoid prematurely submitting the form
	$('.form_input').keypress(function(event){
		if(event.which == 13 || event.which == 10){
			event.preventDefault();
			alert("Please use the Tab key.");
		}
	});
});

function insertCD(){

	//alert($('#input_image_path').val());

	// var cdData = { 
	// 	input_title: $('#input_title').val(),
	// 	input_price: $('#input_price').val(),
	// 	input_image_path:  $('#input_image_path').val() 
	// };
	// alert(cdData.input_title);

	// $.ajax({
	// 	url: 		'edit_cds/insert_cd',
	// 	type: 		'POST',
	// 	data: 		cdData,
	// 	dataType: 	'json',
	// 	context: 	'',
	// 	sucess: 	function(data){
	// 		//alert("success");
	// 	},
	// 	error: function(){

	// 	}
	// });


	$.ajax(
	{
		url: 		'edit_cds',
		type: 		'POST',
		data: 		'',
		dataType: 	'json',
		context: 	$('#here'),
		sucess: 	function(data)
		{
			alert("success");
			//$(this).html(data);
		},
		error: function(data)
		{
			alert("error");
			//$(this).html('data');
		},
	});
}

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
													"<label>Song Clip</label>"+
													"<input type='file' class='form_input' id='song-clip-input-" + i + "' name='song_clip_" + i + "' />"+
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
				alert("old total = " + oldTotal + " change in total = " + changeInTotal);
				for(i = 1; i <= changeInTotal; i++){
					$("#song-input-div").append("<div class='song-title-div' id='song-title-div-" + (oldTotal + i) + "'>"+
													"<label>Song " + (oldTotal + i) + "</label>&nbsp;"+
													"<input type='text' size='50' class='form_input' id='song-title-input-" + (oldTotal + i) + "' name='song_" + (oldTotal + i) + "'/>"+
													"<br/><div>"+
													"<label>Song Clip</label>"+
													"<input type='file' class='form_input' id='song-clip-input-" + i + "' name='song_clip_" + i + "' />"+
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