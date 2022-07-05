function like_button() {
	var xhr = new XMLHttpRequest();

	xhr.open('POST', 'includes/like-inc.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status == 200) {
			var response = xhr.responseText;
			if (response.status == 'success') {
				console.log('Result: ' + response);
			}
		}
	}
	xhr.send();
}
