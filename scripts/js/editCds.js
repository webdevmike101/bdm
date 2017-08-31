// Mike Guillory
// Credo Web Development
// 20170225

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