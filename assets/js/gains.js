$(document).ready(function() {


	/*
	*	Expand and hide individual exercises in the historical workout view
	*/

	$(document).on('click', '.muscle-group', function() {
		//the next exercise log
		var elementToExpand = $(this).next();

		elementToExpand.slideToggle();
	});






	/*
	*	click on view previous workouts button - show the form to submit the workouts the user wants to see. 
	*/

	//function to hide all currently showing views.
	function hide_all_views() {
		var allViews = $('.view').fadeOut();


		// $.each( allViews, function( key, value ) {
		//   value.fadeOut();
		// });
	}
	//end hide_all_views

	$(document).on('click', '#view-previous-workouts', function() {

		//hide currenlty showing views
		hide_all_views();

		//fade in the previous workouts div.
		$('#previous-workouts').fadeIn();
	});


});