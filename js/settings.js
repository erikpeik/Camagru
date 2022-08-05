let change_picture = document.getElementById('change_picture');
let dim_background = document.getElementById('dim-background');
let overlay_box = document.getElementById('overlay_box');
let overlay_header = document.getElementById('overlay_header');
let overlay_content = document.getElementById('overlay_content');
let cross = document.getElementById("cross");
let change_form = document.getElementById('change_form');

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
		console.log(file.files[0]);
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
		console.log(xhr.response);
		console.log(splits);
		if (splits[0] == '1') {
			name_message.innerHTML = 'Name changed successfully';
		} else {
			name_message.innerHTML = '';
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
