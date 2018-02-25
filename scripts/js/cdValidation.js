function validate_cd_input()
{
	$return = true;
	// // var cdTitle = document.forms['cd-form']['title'].value;
	// $('#cd-form input[type="text"], textarea, input[type="file"], input[type="number"]').each(function(){
		
	// 	var inputObject = $(this);
	// 	var inputField = inputObject[0];

	// 	if(!inputField.checkValidity())
	// 	{
	// 		if(inputField.type == 'file')
	// 		{

	// 			inputObject.addClass('red-text-file');
	// 			inputObject.on('change', function()
	// 			{
	// 				inputObject.css('color', '#000');
	// 			});
	// 		}
	// 		else
	// 		{
	// 			inputObject.addClass('red-text');
	// 			inputObject.attr('placeholder', inputField.validationMessage);
	// 		}

	// 		$return = false;
	// 	}
	// });

	return $return;
}

function check_audio_file_extension(e)
{
	var ext = e.target.value.match(/\.([^\.]+)$/)[1];
	switch(ext)
	{
		case 'mp3':
			break;
		default:
			alert('The selected music clip is not the proper file type.');
			e.target.value = '';
			$(e.target).attr('class', 'red-text-file');
			$(e.target).on('change', function()
			{
				$(e.target).css('color', '#000');
			});
	};
}

function check_image_file_extension()
{
	var inputObj = $('#input_cd_image');
	var inputField = inputObj[0];

	var ext = inputField.value.match(/\.([^\.]+)$/)[1];
	switch(ext)
	{
		case 'gif':
		case 'jpg':
		case 'jpeg':
		case 'png':
		case 'tif':
			break;
		default:
			alert('The selected CD image file is not the proper file type.');
			inputField.value = '';
			inputObj.attr('class', 'red-text-file');
			inputObj.on('change', function()
			{
				inputObj.css('color', '#000');
			});
	}
}