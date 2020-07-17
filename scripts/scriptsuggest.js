/*
* Author:      Marco Kuiper (http://www.marcofolio.net/)
*/

function lookup(inputString) {
	if(inputString.length == 0) {
		$('#suggestions').fadeOut(); // Hide the suggestions box
	} else {
		$.post("rpc.php", {queryString: ""+inputString+""}, function(data) { // Do an AJAX call
			$('#suggestions').fadeIn(); // Show the suggestions box
			$('#suggestions').html(data); // Fill the suggestions box
		});
	}
}