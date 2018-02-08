$(document).ready(function(){
	// hide the textarea limit error div by default
	$('#taLimitDiv').hide();

	// GET DATE AND TIME FUNCTION
	function getDT(){
		// empty the fields
		$('#date').val('');
		$('#time').val('');

		// date/time hidden field handlers
		var d = new Date();

		// Get today's date
		var day = d.getDate();
		var month = d.getMonth() + 1; // months are 0-based
		var year = d.getFullYear();

		// date formatting: prepend day and month with 0 (comment out/remove this to use day and month as-is)
		//if (day < 10) {day = '0' + day;}
		//if (month < 10) {month = '0' + month;}

		// set the date field to the current date
		//$('#date').val(day + '/' + month + '/' + year); // CA date format d/m/y
		$('#date').val(month + '/' + day + '/' + year); // US date format m/d/y

		// Get the current time
		var hours = d.getHours();
		var minutes = d.getMinutes();
		var seconds = d.getSeconds();

		// time formatting: prepend hours and minutes with 0 (comment out/remove this to use hours, minutes and seconds as-is)
		//if (hours < 10) {hours = '0' + hours;}
		if (minutes < 10) {minutes = '0' + minutes;}
		if (seconds < 10) {seconds = '0' + seconds;}

		// set the time field to the current time
		$('#time').val(hours + ':' + minutes + ':' + seconds);
	}
	// callback get date/time on document.ready
	getDT();

	// TEXTAREA CHARACTER COUNTER
	// set textarea max character limit variable
	var taMax = 512;
	// add message and counter html to .taCharCounter object
	$('.taCharCounter').html(taMax + ' remaining');
	// textarea .keyup() event function
	$('#comments').keyup(function() {
		// set char length of #comments textarea as a variable
		var taLen = $('#comments').val().length;
		// set remaining char count vasriable as textarea limit minus char length of #comments textarea
		var taRem = taMax - taLen;
		// add remaining char count to .taCharCounter object
		if(taRem < 0){
			$('.taCharCounter').css('color', '#ff0000');
			$('.taCharCounter').html(taRem + ' over the limit');
		}else{
			$('.taCharCounter').css('color', '#33cc00');
			$('.taCharCounter').html(taRem + ' remaining');
		}
	});
});

// TEXTAREA CHARACTER LIMITER: onblur="taLimit(this,512);"
// validates the textarea limit when user blurs away from the textarea (allows entire message to remain in the textarea so the user can edit it down to default 512 char limit)
function taLimit(_object,textlength){
	if (_object.value.length>textlength) {
		//alert('You have exceeded the '+textlength+' character limit for a the Comments field. Please delete some of the text.');
		$('#taLimitDiv').slideDown();          
		_object.focus();
		return false;
	}
	$('#taLimitDiv').slideUp();   
	return true;
}