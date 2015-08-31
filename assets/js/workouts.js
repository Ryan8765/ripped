$(document).ready(function() {

	/*
	*	Muscle groups - hide and show muscle exercises when you click on a workout.
	*/

	$(document).on('click', '.muscle-group', function() {

		var muscleExercisesDiv = $(this).next();

		muscleExercisesDiv.slideToggle();
	});


	/*
	*	Transfer the correct workout id to the delete workout popup - so when you submit the form php knows what workout to delete.  Also puts the name of the workout in the modal so the user has clear visual of what he/she is deleting.
	*/




	$(document).on('click', '.delete-workout', function() {
		
		//get the data-workout-id value of the delete button clicked by user
		var workoutID = $(this).attr( 'data-workout-id' );
		//get the name of the workout
		var workoutName = $(this).closest('.muscle-group').find('.workout-name').text();
		//convert it to lowercase letters.
		workoutName = workoutName.toLowerCase();

		//change the value of the popup hidden input field to represent the workout ID.  
		$('#workout-id-form-input').attr('value', workoutID);
		
		//change the value of the modal text to show the workout in it.
		$('.delete-workout-modal-text').text("Delete " + workoutName + " workout?");

	});  //end on click



	/*
	*	Handles the functionality for when a user addes an exercise to a workout.
	*/

	//for the modal popup - add the workout id to the hidden input field.
	$(document).on('click', '.add-exercise', function() {
		
		//get the data-workout-id value of the delete button clicked by user
		var workoutID = $(this).attr( 'data-workout-id' );
		//get the name of the workout
		var workoutName = $(this).closest('.muscle-group').find('.workout-name').text();
		//convert it to lowercase letters.
		workoutName = workoutName.toLowerCase();

		//change the value of the popup hidden input field to represent the workout ID.  
		$('#existing-exercise-workoutID').attr('value', workoutID);
		$('#existing-exercise-workoutID-2').attr('value', workoutID);
		
		//change the value of the modal text to show the workout in it.
		$('#add-exercise-modal-popup-text').text("Add exercises to " + workoutName + " workout?");

	});  //end on click




	/*
	*	Delete Exercise from workout modal popup
	*/

	//for the modal popup - add the workout id to the hidden input field.
	$(document).on('click', '.delete-exercise-from-workout', function() {
		var clickedButton = $(this);
		//get the data-workout-id value of the delete button clicked by user
		var workoutID = clickedButton.attr( 'data-workout-id' );
		//get the data-exercise-id value of the delete button clicked by user
		var exerciseID = clickedButton.attr( 'data-workout-exercise-id' );
		//get the name of the workout
		var exerciseName = clickedButton.attr('data-exercise-name');
		var workoutName = clickedButton.attr('data-workout-name');
		
		console.log(workoutName);

		//convert it to lowercase letters.
		exerciseName = exerciseName.toLowerCase();
		workoutName = workoutName.toLowerCase();
		

		//change the value of the popup hidden input field to represent the workout ID.  
		$('#delete-exercise-exerciseID').attr('value', exerciseID);
		
		//change the value of the modal text to show the workout in it.

		$('#delete-exercise-modal-title').text("Delete exercise '" + exerciseName + "' from '" + workoutName + "' workout?");

	});  //end on click


	

});	