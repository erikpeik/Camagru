upload_form.addEventListener('change', function(e) {
	e.preventDefault();
	var data = new FormData();
	data.append('file', upload_form['file'].files[0]);

	if (window.matchMedia("(orientation: portrait)").matches
	&& window.matchMedia("(hover: none)").matches) {
		var orientation = "portrait";
	} else {
		var orientation = "landscape";
	}
	data.append("orientation", orientation);

	let upload_image = document.querySelector('#upload');
	if (upload_image != null) {
		upload_image.remove();
	}

	if (globalThis.stream != null) {
		globalThis.stream.getTracks().forEach(function(track) {
			track.stop();
		});
	}

	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'includes/load_image.php', true);
	xhr.onload = function() {
		var data = this.response;
		if (data == "Error: No file selected."){
			back_to_default();
		} else if (data.match(/Error: /) == null) {
			var img = document.createElement("img");
			img.src = 'data:image/jpg;base64,' + this.response;
			img.id = "upload";
			video_div.append(img);
			video.style.display = "none";
			click_button.style.display = "none";
			sticker_div.innerHTML = '';
			video_div.style.display = "inline-block";
			sticker_bar.style.display = "inline-block";
			drafts.style.display = "inline-block";
			container.style.display = '';
			image_form.style.display = 'block';
			cancel_image.style.display = "none";
		} else {
			alert(this.response);
			back_to_default();
		}
	}
	xhr.send(data);
});

upload_button.addEventListener('click', function() {
	let upload_img = document.querySelector('#upload');
	let image_data_url = upload_img.src;
	var sticker_res = "";
	var check = sticker_div.getElementsByClassName('sticker');

	for (i = 0; i < check.length; i++) {
		if (i != 0) {
			sticker_res += ",";
		}
		var char = check[i].id.charAt(check[i].id.length - 1);
		sticker_res += char;
	}

	var http = new XMLHttpRequest();
	var params = 'img=' + image_data_url + '&stickers=' + sticker_res;
	for (i = 0; i < check.length; i++) {
		var char = check[i].id.charAt(check[i].id.length - 1);
		sticker_res += char;

		var multiplier = 200 / check[i].offsetWidth;

		var left = parseInt(check[i].style.left, 10) * multiplier;
		left = Math.floor(left);

		var top = parseInt(check[i].style.top, 10) * multiplier;
		top = Math.floor(top);

		var width = check[i].offsetWidth * multiplier;
		width = Math.floor(width);

		var height = check[i].offsetHeight * multiplier;
		height = Math.floor(height);

		params += '&sticker_' + char + '=' + left + ',' + top + ',' + width + ',' + height;
	}
	http.open('POST', 'includes/camera-inc.php', true);
	http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	http.onload = function() {
		var img = document.createElement("img");
		img.src = 'data:image/jpg;base64,' + this.response;
		img.id = "final";
		video_div.append(img);
		var input = document.createElement("input");
		input.setAttribute("type", "hidden");
		input.setAttribute("name", "image");
		input.setAttribute("value", this.response)
		image_form.appendChild(input)
	}
	http.send(params);

	upload_div.style.display = 'none';
	document.querySelector('#upload').style.display = "none";
	sticker_div.style.display = "none";
	sticker_bar.style.display = 'none';
	drafts.style.display = 'none';
	document.querySelector('.camera-buttons').style.display = 'none';
	image_form.style.display = 'block';
	container.style.width = '640px';
	container.style.marginTop = '57px';
});
