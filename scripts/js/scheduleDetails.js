// Mike Guillory
// Credo Web Development
// 20160403

var venue = "";
var address = "";
var time = "";
var am_pm = "";
var clicked_am_pm ="";
var details = "";
var date = "";
var dateForDatabase = '';
var city = "";
var detailsDate = "";
var detailsCity = "";

$(document).ready(function(){

	displayDetails();

	$("#date, #datepicker, #input_release_date").datepicker({
		dateFormat: 'yy/mm/dd',
		minDate: 0,
		onClose: function(e){
			if($(this).attr("id") == "datepicker"){
				$('input[name="performance_city"]').focus();
			}
		}
	});

	$(".listing").click(function(){
		$('#updated').css('color', '#fff');
		$('.showDetails').removeClass('showDetails');
		$(this).addClass('showDetails');
		var id = $('.showDetails').attr('id');
		displayDetails(id);
	});

	$('input[type="radio"]').click(function(){

		clicked_am_pm = $(this).val();
	});
});

function displayDetails(id){

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
	// $('.venue').text(venue);
	$('#address').val(address);
	$('.address').text(address);
	$('#time').val(time);
	if(time){
		$('.time').text(time + " " + am_pm);		
	}
	$('#edit_am_pm:checked').prop('checked', false);
	$('#' + am_pm).prop('checked', true);
	$('#details').val(details);
	$('.details').text(details);
	// if(detailsCity){
	// 	$('.details-date').html(detailsCity + ", " + detailsDate);	
	// }
		if(venue){
		$('.details-date').html(venue);	
	}
	$('#hiddenId').val(id);

};

function updateSchedule(e){

	if (confirm("Are you sure you want to edit this performance?")) {
        var userDate = $('#date').val();
		var newDate = new Date(userDate);
		var day = newDate.getDate();
		var month = newDate.getMonth() + 1;
		var year = newDate.getFullYear();

		databaseDate = year + '/' + month + '/' + day;

		var performanceData = {
			post_id: $('.showDetails').attr('id'),
			post_date: databaseDate,
			post_time: $('#time').val(),
			post_am_pm: clicked_am_pm,
			post_details: $('#details').val(),
			post_venue: $('#venue').val(), 
			post_address: $('#address').val(),
			post_city_province: $('#city').val()
		};

		$.ajax({
			url: 		'edit_schedule/update_performance',
			type: 		'POST',
			data: 		performanceData,
			dataType: 	'json',
			context: 	'',
			success: 	function(data){

							var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

							var day = data.date.substr(8);
							day = day.replace(/^0+/, '');
							var month = monthNames[data.date.substr(5, 2) - 1];
							var year = data.date.substr(0, 4);

							var displayDate = month + ' ' + day + ', ' + year;
		         				
		     				$('#date' + data.id).text(displayDate);
		     				$('#date').val(displayDate);
		     				$('#hidden-date' + data.id).val(data.date);
		     				$('#city' + data.id).text(data.city_province);
		     				$('#city').val(data.city_province);
		     				$('#venue' + data.id).val(data.venue);
		     				$('#venue').val(data.venue);
		     				$('#address' + data.id).val(data.street_address);
		     				$('#address').val(data.street_address);
		     				$('#time' + data.id).val(data.time);
		     				$('#time').val(data.time);
		     				$('#hidden_am_pm' + data.id).val(data.am_pm);
		     				$('#' + data.am_pm).prop('checked', true);
		     				$('#details' + data.id).val(data.details);
		     				$('#details').val(data.details);
		     				$('#updated').css('color', '#0f0');

		     				 //console.log(data);
	            		},
			            error: function(){
			                //console.log('something went wrong');
			            }			
		});
    }
    else
    {
	    displayDetails();
	    return false;
    }

};

function deletePerformance(){

	if (confirm("Are you sure you want to delete this performance?")) {

		var id = $('#hiddenId').val();

		$.ajax({
		url: 		'edit_schedule/delete_performance',
		type: 		'POST',
		data: 		'id=' + id,
		context: 	'',
		success: 	function(data){

						location.reload();
						//$('#up-div').load('edit_schedule #up-div');
						if(id == $('table tr:nth-child(1)').attr('id')){
							id = $('table tr:nth-child(2)').attr('id');
						}
						else
						{
							id = $('table tr:nth-child(1)').attr('id')
						}

						displayDetails(id);

	     				//console.log(data);
            		},
		            error: function(){
		                //console.log('something went wrong');
		            }			
		});
	}
	return false;
};

function reloadStylesheets() { // http://stackoverflow.com/questions/2024486/is-there-an-easy-way-to-reload-css-without-reloading-the-page
    var queryString = '?reload=' + new Date().getTime();
    $('link[rel="stylesheet"]').each(function () {
        this.href = this.href.replace(/\?.*|$/, queryString);
    });
}