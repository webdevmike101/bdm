//var id = "";
var venue = "";
var address = "";
var time = "";
var am_pm = "";
var details = "";
var date = "";
var dateForDatabase = '';
var city = "";
var detailsDate = "";
var detailsCity = "";

$(document).ready(function(){

	// $('tr:first').addClass('showDetails');
	displayDetails();

	$(".listing").click(function(){
		$('.showDetails').removeClass('showDetails');
		$(this).addClass('showDetails');
		var id = $('.showDetails').attr('id');
		displayDetails(id);
	});
});

function displayDetails(id = ""){

	if(!id){
		id = $('.showDetails').attr('id');
	}

	venue = $('#venue' + id).val();
	address = $('#address'+ id).val();
	time = $('#time' + id).val();
	am_pm = $('#hidden_am_pm' + id).val();
	details = $('#details' + id).val();
	date = $('#date' + id).text();
	dateForDatabase = $('#hidden-date' + id).val();
	city = $('#city' + id).text();
	detailsDate = date.substr(0, date.indexOf(','));
	detailsCity = city.substr(0, city.indexOf(','));

	$('#city').val(city);
	$('#date').val(date);
	$('#venue').val(venue);
	$('.venue').text(venue);
	$('#address').val(address);
	//$('#time').val(time);
	$('.time').text(time + " " + am_pm);
	$('#edit_am_pm:checked').prop('checked', false);
	$('#' + am_pm).prop('checked', true);
	$('#details').val(details);
	$('.details-date').html(detailsCity + ", " + detailsDate);

};