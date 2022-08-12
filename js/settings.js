let change_picture = document.getElementById('change_picture');
let dim_background = document.getElementById('dim-background');
let overlay_box = document.getElementById('overlay_box');
let overlay_header = document.getElementById('overlay_header');
let overlay_content = document.getElementById('overlay_content');
let cross = document.getElementById("cross");
let change_form = document.getElementById('change_form');
let password_form = document.querySelector('#password_form');
let checkbox = document.querySelector('#checkbox');
let delete_account = document.getElementById('delete_account');

change_picture.addEventListener('click', function () {
	dim_background.style.display = 'block';
	overlay_box.style.display = 'block';
	overlay_header.innerHTML = 'Change Profile Photo';
	file = document.createElement('input');
	file.type = 'file';
	file.name = 'new_image';
	file.id = 'new_image';
	file.accept = "image/png, image/jpeg"
	file.onchange = function () {
		var data = new FormData();
		data.append('file', file.files[0]);

		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'includes/change_picture.php', true);
		xhr.onload = function() {
			document.location.reload(true);
		}
		xhr.send(data);
	}
	overlay_content.appendChild(file);
});

cross.addEventListener('click', close_overlay);

function close_overlay() {
	overlay_box.style.display = "none";
	dim_background.style.display = "none";
	overlay_header.innerHTML = "";
	overlay_content.innerHTML = "";
}

change_form.addEventListener('submit', function (e) {
	e.preventDefault();
	let name_message = document.getElementById('name_message');
	let username_message = document.getElementById('username_message');
	let email_message = document.getElementById('email_message');
	let username = document.getElementById('username');

	var data = new FormData(change_form);

	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'includes/change_settings.php', true);
	xhr.onload = function() {
		var result = String(xhr.responseText);
		var splits = result.split(',');
		if (splits[0] == '1') {
			name_message.innerHTML = 'Name changed successfully';
			name_message.style.color = 'green';
		} else if (splits[0] == '2') {
			name_message.innerHTML = 'Invalid name. It must not contain numbers or special characters';
			name_message.style.color = 'red';
		} else if (splits[0] == '3') {
			name_message.innerHTML = 'Full name is too long';
			name_message.style.color = 'red';
		}
		else {
			name_message.innerHTML = '';
			name_message.style.color = '';
		}

		if (splits[1] == '1') {
			username_message.innerHTML = 'Username changed successfully';
			username.innerHTML = change_form['username'].value;
			username_message.style.color = 'green';
		} else if (splits[1] == '2') {
			username_message.innerHTML = 'Username already taken';
			change_form['username'].value = username.innerHTML;
			username_message.style.color = 'red';
		} else {
			username_message.innerHTML = '';
			username_message.style.color = ''
		}

		if (splits[2] == '1') {
			email_message.innerHTML = 'To finish changing your email, please click the link in the email.';
			email_message.style.color = 'green';
		} else if (splits[2] == '2'){
			email_message.innerHTML = 'Email is already taken';
			email_message.style.color = 'red';
		} else if (splits[2] == '3') {
			email_message.innerHTML = "Email formatting is incorrect";
			email_message.style.color = 'red';
		} else {
			email_message.innerHTML = '';
			email_message.style.color = '';
		}

	}
	xhr.send(data);
});

password_form.addEventListener('submit', function (e) {
	e.preventDefault();
	var xhr = new XMLHttpRequest();
	let password_message = document.getElementById('password_message');
	var data = new FormData(password_form);

	xhr.open('POST', 'includes/change_password.php', true);
	xhr.onload = function() {
		var data = this.responseText;
		if (data == '0') {
			password_message.innerHTML = 'Some fields are missing';
			password_message.style.color = 'red';
		}
		else if (data == '1') {
			password_message.innerHTML = 'Fields cannot be empty';
			password_message.style.color = 'red';
		}
		else if (data == '2') {
			password_message.innerHTML = 'Passwords do not match';
			password_message.style.color = 'red';
		}
		else if (data == '3') {
			password_message.innerHTML = "Invalid password format. Requirements:<br />" +
			"- Length is at least 8 character long<br />" +
			"- At least one uppercase and lowercase letter<br />" +
			"- One special character [!@#$%^&*]";
			password_message.style.color = 'red';
		}
		else if (data == '4') {
			password_message.innerHTML = 'Old password is incorrect';
			password_message.style.color = 'red';
		}
		else if (data == '5') {
			password_message.innerHTML = 'Password changed successfully';
			password_message.style.color = 'green';
		}
		else if (data == '6') {
			password_message.innerHTML = 'New password is the same as the old password';
			password_message.style.color = 'red';
		}
		else {
			password_message.innerHTML = '';
			password_message.style.color = '';
		}
	}
	xhr.send(data);
});

checkbox.addEventListener('change', function() {
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'includes/email_notifications.php', true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.send('checked=' + event.currentTarget.checked);
});

delete_account.addEventListener('click', function() {
	let check = confirm("Are you sure you want to delete your account?");
	if (check === true) {
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'includes/delete_account.php', true);
		xhr.onload = function() {
			if (xhr.response == '1') {
				alert("Account deleted successfully");
				document.location.href = "login";
			} else {
				alert("Error deleting account");
			}
		}
		xhr.send();
	}
});
