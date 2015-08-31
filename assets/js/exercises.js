$(document).ready(function() {


	/*
	*	Deal with delete exercise modal popup 
	*/

	//when delete button is clicked on - update the modal popup hidden field with the exercise ID and modify the title to reflect the exercise.
	$(document).on('click', '.delete-exercise-btn', function() {
		//get the current exercise ID 
		var exerciseID = $(this).attr('data-exercise-id');

		//get the name of the exercise
		var exerciseName = $(this).attr('data-exercise-name');

		//change hidden input value
		$('#delete-exercise-id').val( exerciseID );

		//modify the modal title
		$('#delete-exercise-modal-title').text("Are you sure you want to delete the exercise '" + exerciseName + "'?");

	}); //end on click

	// var base_url = $('#base_url').val();

	// $("#add-exercise form").submit(function(e) {
	//     e.preventDefault();
	// });

	// /*
	// *	Add a new exercise to the database
	// */

	// $('#add-exercise-submit').on('click', function() {
	// 	var form = $(this).closest('form');
		

	// 	$.post(base_url + "ajax/add_exercise", form.serialize() )
	// 		.done(function(data){
	// 			console.log(data);
	// 			// form.find('textarea').val('');
	// 			// item_added(form);
	// 			// //build the html and output it
	// 			// build_list_html(data, timeFrame);

	// 		}).
	// 		fail(function(data){
	// 			console.log("data " + data);
	// 		});
	// 	//end post
	// });

});