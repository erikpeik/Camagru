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
			description_field.value = "";
		} else {
			alert(this.response);
			back_to_default();
		}
	}
	xhr.send(data);
});
