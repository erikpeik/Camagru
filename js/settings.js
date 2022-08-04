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
	var data = new FormData(change_form);

	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'includes/change_settings.php', true);
	xhr.onload = function() {
		console.log(xhr.response);
	}
	xhr.send(data);
});
