var songCount = 1;

		$("#songTitle").keypress(function(e){
		    if (e.keyCode == 13) 
		    {
		    	e.preventDefault();
		    	nextSong();
		    }
		});

		var i = 1;

		$('#input_total_songs').focusout(enterSong());	

		function enterSong(){

			$('#song-input-div').html("");
			$("<br/><div>" + "Enter Title for Song " + i + ": " + 
				"<input type='text' id='songTitle'></input><input type='button' value='Enter' onclick='nextSong()'></input></div>").appendTo('#song-input-div');
			$('#songTitle').focus();
		}		

		// $(document.body).delegate('input:text', 'keypress', function(e){
		//     if (e.keyCode == 13) 
		//     {
		//     	e.preventDefault();

		//     	if($(this).is('#input_total_songs') || $(this).is('#songTitle'))
		//     	{
		//     		nextSong();
		//     	}
		//     }
		// });

		function nextSong(){

			var songTotal = $('#input_total_songs').val();

			if(songCount <= songTotal){
				next();
			} 
			else
			{
				next();
				$('#song-input-div').empty();
				$('#input_description').focus();
				songCount--;
			}   

			function next()
			{
				var songTitle = $('#songTitle').val();
		        $("<div id='song" + songCount + "'>" + songTitle + "</div>").appendTo('#song-list-div');
		        $('#songTitle').val("").focus();
		        songCount++;
			} 
		}

		$('#input_release_date').focusout(function(){

			$('#input_total_songs').focus();

		});

		// $('#input_total_songs').focusout(function()
		// {
		// 	$('#song-input-div').html("");
		// 	for(i = 1; i <= $('#input_total_songs').val(); i++)
		// 	{
		// 		$("<div><p style='display: inline-block; width: 70px'>Song " + i + ": " + "</p><input type='text' name='song" + i + "'" + "id='song" + i + "'" + "></input></div>").appendTo('#song-input-div');
		// 	}
		// 	$('#song1').focus();
		// });