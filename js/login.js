let login_guest = document.querySelector('.login_guest');

login_guest.addEventListener('click', function(){
	let xhr = new XMLHttpRequest();
	xhr.open('POST', 'includes/login_guest.php', true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.onload = function() {
		window.location.href = ".";
	}
	var params = 'login=guest';
	xhr.send(params);
});
