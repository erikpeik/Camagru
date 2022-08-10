let reset_password_form = document.getElementById('reset_password_form');

if (reset_password_form != null) {
	reset_password_form.addEventListener('submit', function (e) {
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'includes/reset_password.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.onload = function () {
			let message = document.getElementById('reset_error');
			console.log(xhr.response);
			var data = xhr.response;
			if (data == '0') {
				message.innerHTML = 'Some fields are missing';
				message.style.color = 'red';
			}
			else if (data == '1') {
				message.innerHTML = 'Fields cannot be empty';
				message.style.color = 'red';
			}
			else if (data == '2') {
				message.innerHTML = 'Passwords do not match';
				message.style.color = 'red';
			}
			else if (data == '3') {
				message.innerHTML = "Invalid password format. Requirements:<br />" +
				"- Length is at least 8 character long<br />" +
				"- At least one uppercase and lowercase letter<br />" +
				"- One special character [!@#$%^&*]";
				message.style.color = 'red';
			}
			else if (data == '4') {
				location.href = "login?msg=password_changed";
			}
			else if (data == '5') {
				message.innerHTML = 'Email or code is incorrect';
				message.style.color = 'red';
			}
			else if (data == '6') {
				message.innerHTML = 'New password is the same as the old password';
				message.style.color = 'red';
			}
			else {
				message.innerHTML = '';
				message.style.color = '';
			}
		}
		var params = 'password=' + reset_password_form.password.value +
			'&confirm_password=' + reset_password_form.confirm_password.value +
			'&email=' + reset_password_form.email.value +
			'&code=' + reset_password_form.code.value +
			'&submit=' + reset_password_form.reset.value;
		xhr.send(params);
	}
	);
}
