// Mike Guillory
// Credo Web Development
// 20180223

// Get the current action attribute of the form, which will be insert_cd
var currentAction = $('form').attr('action');
var updating = false;

$(document).ready(function(){

	// Set the focus on the input for total number of songs after a release date is selected
	$('#input_release_date').focusout(function(){

		$('#input_total_songs').focus();

	});

	// Disable the enter key to avoid prematurely submitting the form
	$('.form_input').keypress(function(e){
		if(e.which == 13){
			e.preventDefault();
			alert("Please use the Tab key to move to the next input.");
		}
	});

	function formatPrice(price)
	{
		return price.toString().replace(/(\d{2})(?=(\d))/, '$1.');
	}

	$('#input_price').on('keyup', function(e){
		var input = e.target.value;
		if(input.length < 4 && input.length > 0)
		{
			// var price = input;
			var price = formatPrice(input);
			$(e.target).val(price);
		}
	});

	$('#input_price, #input_total_songs').on('keydown', function(e) {
		
		var key = e.which;
		var max = (this.id == 'input_price') ? 5 : 2;

		// dissable the arrow keys
		if([37, 38, 39, 40].indexOf(key) >= 0) {
			e.preventDefault();
		}

		// dissable all keys except tab, backspace, and enter to limit
		// number of digits in these fields
		if(this.value.length == max && !([8, 9, 13].indexOf(key) >= 0)) 
		{
			return false;
		}
	});

	// Update the CD
	$('.edit-cd-image').on('click', function(){

		updating = true;

		var id = this.id;
		var cd = cds[id];

		var title = cd.cd_title;
		var price = cd.price;
		var releaseDate = cd.release_date;
		var totalSongs = cd.total_songs;
		var description = cd.description;

		action = currentAction.replace('insert_cd', 'update_cd');

		$('form').attr('action', action);
		$('#add-edit').text("Edit " + title);
		$('#cd-id').val(id);
		$('#input_title').val(title);
		$('#input_price').val(price);
		$('#input_release_date').val(releaseDate);
		$('#input_total_songs').val(totalSongs);
		$('#hidden-total-songs').val(totalSongs);
		$('#input_description').val(description);

		$('#enterSongTitles').val("Number of Songs");
		$('input[name="submit-btn"]').css('background', '#f00').val("Update");			

		$("#song-input-div").empty();

		// This "if" is just to make sure that build_song_input_listing() completes before the
		// song-title-inputs are populated.
		if(build_song_input_listing(totalSongs)){	

			for(var i = 1; i <= totalSongs; i++ ){

				$('#song-title-input-' + i).val(cd[i - 1].song_title);
				$('#song-clip-input-' + i).val(cd[i - 1].clip_name);
			}
		};
	});
});

function cancelUpdate(e){

	updating = false;

	$('#add-edit').html('Add New CD');
	$("#song-input-div").empty();
	$('input[name="submit-btn"]').css({background: '#0f0'}).val("Upload");
	$('form').attr('action', actionInsert);
}

function deleteCd(){

	updating = false;
}

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

	// $.ajax(
	// {
	// 	url: 		'edit_cds',
	// 	type: 		'POST',
	// 	data: 		'',
	// 	dataType: 	'json',
	// 	context: 	$('#here'),
	// 	sucess: 	function(data)
	// 	{
	// 		alert("ajax success");
	// 		//$(this).html(data);
	// 	},
	// 	error: function(data)
	// 	{
	// 		alert("ajax error");
	// 		//$(this).html('data');
	// 	},
	// });
}

// Set up for displaying the correct number of song title fields after the total number of songs has been entered
// and the Enter Song Titles button has been clicked
// If we're coming back through because there were validation errors, "first_time_through" needs to be set to something other than
// undefined, so it is set to the number of songs previously entered. That makes it easy to also set total_songs to the correct
// number in case changes are made to the number of songs entered.

var songTitleType = "";

function enterSongTitle(){

	var old_total = parseInt($('#hidden-total-songs').val());		
	var first_time_through = isNaN(old_total) ? true : false;

	if(checkForNumbersOnly($('#input_total_songs').val())){

		var new_total_songs = parseInt($("#input_total_songs").val());
		songTitleType = updating ? "text" : "file";

		if(first_time_through)
		{
			$("#song-input-div").empty();
			build_song_input_listing(new_total_songs);
		}
		else
		{
			var last = old_total;
			var changeInTotal = 0;

			if(new_total_songs < old_total){

				changeInTotal = old_total - new_total_songs;
				new_total_songs = new_total_songs - changeInTotal;

				for(i = 1; i <= changeInTotal; i++){
					$('#song-title-div-' + last).remove();
					last--;
				}
			}
			else
			{
				var start_from = parseInt($('#song-title-div-' + last).attr('id').slice(-1));
				changeInTotal = new_total_songs - old_total;
				build_song_input_listing(changeInTotal, start_from);	
			}
		}	
	}
	else{

	 	alert("Please enter a valid number of songs.");
		// entry = undefined;
	}

	$('[id^="song-clip-input-"]').on('click', function(){
		this.type = "file";
	});
}

function checkForNumbersOnly (numberOfSongs) {

	var only_numbers = /^[0-9]{1,2}$/; // from start "^" to end "$" any numbers from 0 to 9 "[0-9]" and only 1 or 2 numbers "{1,2}". All inclosed in two forward slashes
	if(numberOfSongs.match(only_numbers)){

	 	return true;
	 }
}

function build_song_input_listing(songs, start_from = 0)
{
	for(i = 1; i <= songs; i++){

		var song_title_div = $('<div>').appendTo($("#song-input-div"));
		song_title_div.attr('class', 'song-title-div');
		song_title_div.attr('id', `song-title-div-${start_from + i}`);

		var song_label = $('<label>').appendTo(song_title_div);
		song_label.html(`Song ${start_from + i}`);

		var song_title_input = $('<input>').appendTo(song_title_div);
		song_title_input.attr('required', 'required');
		song_title_input.attr('type', 'text');
		song_title_input.attr('class', 'form_input');
		song_title_input.attr('id', `song-title-input-${start_from + i}`);
		song_title_input.attr('name', `song_${start_from + i}`);

		var div = $('<div>').appendTo(song_title_div);

		var clip_label = $('<label>').appendTo(song_title_div);
		clip_label.attr('class', 'clip');
		clip_label.html('Clip');
		
		var song_clip_input = $('<input>').appendTo(song_title_div);
		song_clip_input.attr('required', 'required');
		song_clip_input.attr('type', `${songTitleType}`);
		song_clip_input.attr('class', 'form_input');
		song_clip_input.attr('id', `song-clip-input-${start_from + i}`);
		song_clip_input.attr('name', `song_clip_${start_from + i}`);
		song_clip_input.on('change', function(e) {check_audio_file_extension(e)});
	}

	// This return is just here for the if(build_song_input_listing()) statement above
	// that ensures build_song_input_listing() completes before the script moves on.
	return true;
}