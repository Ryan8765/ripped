$(document).ready(function () {

	//when user selects a different selection submit the form.
	$( "#selected-workout" ).change(function() {
	  $('#submit-workout').submit();
	});

});	