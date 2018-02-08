// handler.js - client-side form submission processing, AJAX data handling, error display, 

$(document).ready(function() {

	// process the form
	$('form').submit(function(event) {

		// clear existing errors
		$('.form-group').removeClass('has-error'); // remove error class
		$('.help-block').remove(); //remove error messages
		$('.alert.alert-success').remove(); //remove success messages

		// get the form data using jQuery
		var formData = {
			'date' : $('input[name=date]').val(), // hidden field
			'time' : $('input[name=time]').val(), // hidden field
			'salutation' : $('select[name=salutation]').val(),
			'firstName' : $('input[name=firstName]').val(),
			'lastName' : $('input[name=lastName]').val(),
			'email' : $('input[name=email]').val(),	
			'email2' : $('input[name=email2]').val(),		
			'phone' : $('input[name=phone]').val(),
			'address1' : $('input[name=address1]').val(),
			'address2' : $('input[name=address2]').val(),
			'city' : $('input[name=city]').val(),	
			'state' : $('select[name=state]').val(),
			'postalCode' : $('input[name=postalCode]').val(),
			'age' : $('select[name=age]').val(),
			'commentType' : $('select[name=commentType]').val(),		
			'comments' : $('textarea[name=comments]').val()			
		};

		// handle checkbox data separately
		if($('input:checkbox[name=agreeToTerms]').is(':checked')){
			formData.agreeToTerms = $('input:checkbox[name=agreeToTerms]').val();
		}

		// process the form data
		$.ajax({
			type 		: 'POST', // define the type of HTTP method we want to use
			url 		: 'processor.php', // the url we want to POST to
			data 		: formData, // the data object
			dataType 	: 'json', // the type of data we expect to call back from the server
			encode 		: true
		})

		// using the .done() 'promise' callback (as of jQuery 1.8+, .success() is deprecated)
		.done(function(data) {
			// log data to console so we can see it (remove for production use)
			console.log(data);
			// handle errors and validation messages
			if (!data.success) {
				// handle errors for 'salutation'
				if (data.errors.salutation) {
					$('#salutation-group').addClass('has-error'); // add error class to input
					$('#salutation-group').append('<div class="help-block">' + data.errors.salutation + '</div>'); // add the error message below the input
				}
				// handle 'firstName' errors
				if (data.errors.firstName) {
					$('#firstName-group').addClass('has-error'); // add error class to input
					$('#firstName-group').append('<div class="help-block">' + data.errors.firstName + '</div>'); // add the error message below the input
				}
				if (data.errors.lastName) {
					$('#lastName-group').addClass('has-error'); // add error class to input
					$('#lastName-group').append('<div class="help-block">' + data.errors.lastName + '</div>'); // add the error message below the input
				}
				// handle errors for 'email'
				if (data.errors.email) {
					$('#email-group').addClass('has-error'); // add error class to input
					$('#email-group').append('<div class="help-block">' + data.errors.email + '</div>'); // add the error message below the input
				}
				// handle errors for 'email2' (confirm email)
				if (data.errors.email2) {
					$('#email2-group').addClass('has-error'); // add error class to input
					$('#email2-group').append('<div class="help-block">' + data.errors.email2 + '</div>'); // add the error message below the input
				}
				// handle errors for 'phone'
				if (data.errors.phone) {
					$('#phone-group').addClass('has-error'); // add error class to input
					$('#phone-group').append('<div class="help-block">' + data.errors.phone + '</div>'); // add the error message below the input
				}
				// handle errors for 'address1'
				if (data.errors.address1) {
					$('#address1-group').addClass('has-error'); // add error class to input
					$('#address1-group').append('<div class="help-block">' + data.errors.address1 + '</div>'); // add the error message below the input
				}
				// handle errors for 'address2'
				if (data.errors.address2) {
					$('#address2-group').addClass('has-error'); // add error class to input
					$('#address2-group').append('<div class="help-block">' + data.errors.address2 + '</div>'); // add the error message below the input
				}
				// handle errors for 'city'
				if (data.errors.city) {
					$('#city-group').addClass('has-error'); // add error class to input
					$('#city-group').append('<div class="help-block">' + data.errors.city + '</div>'); // add the error message below the input
				}
				// handle errors for 'state'
				if (data.errors.state) {
					$('#state-group').addClass('has-error'); // add error class to input
					$('#state-group').append('<div class="help-block">' + data.errors.state + '</div>'); // add the error message below the input
				}
				// handle errors for 'postal code'
				if (data.errors.postalCode) {
					$('#postalCode-group').addClass('has-error'); // add error class to input
					$('#postalCode-group').append('<div class="help-block">' + data.errors.postalCode + '</div>'); // add the error message below the input
				}
				// handle errors for 'age'
				if (data.errors.age) {
					$('#age-group').addClass('has-error'); // add error class to input
					$('#age-group').append('<div class="help-block">' + data.errors.age + '</div>'); // add the error message below the input
				}
				// handle errors for 'comment type'
				if (data.errors.commentType) {
					$('#commentType-group').addClass('has-error'); // add error class to input
					$('#commentType-group').append('<div class="help-block">' + data.errors.commentType + '</div>'); // add the error message below the input
				}
				// handle errors for 'comments'
				if (data.errors.comments) {
					$('#comments-group').addClass('has-error'); // add error class to input
					$('#comments-group').append('<div class="help-block">' + data.errors.comments + '</div>');  // add the error message below the input
				}
				// handle errors for 'agree to t & c'
				if (data.errors.agreeToTerms) {
					$('#agreeToTerms-group').addClass('has-error'); // add error class to input
					$('#agreeToTerms-group').append('<div class="help-block">' + data.errors.agreeToTerms + '</div>');  // add the error message below the input
				}
			} else {
				// no errors, show a success message (default)
				$('form').append('<div class="alert alert-success">' + data.message + '</div>');

				// alert the user (remove for production use)
				alert('success'); 

				// clear the form fields
				$('form')[0].reset();

				// redirect after form submission (optional)
				//window.location = "thankyou.html"	
				
			}
		})

		// using the .fail() 'promise' callback
		.fail(function(data) {
			// show errors if they exist (remove for production use)
			console.log(data);
		});

		// stop the form from submitting normally (no page refresh)
		event.preventDefault();

	});

});