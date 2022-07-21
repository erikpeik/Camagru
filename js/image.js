

function remove_image(image_id) {
	dim_background.style.display = "block";
	overlay_box.style.display = "block";
	overlay_header.innerHTML = "Do you really want remove this image?";

	var div = document.createElement("div");
	var confirm_button = document.createElement("button");
	var cancel_button = document.createElement("button");
	confirm_button.innerHTML = "Confirm";
	cancel_button.innerHTML = "Cancel";
	div.className = "confirm_buttons";
	confirm_button.className = "confirm_button";
	cancel_button.className = "cancel_button";
	cancel_button.onclick = function() {
		close_overlay();
	}
	confirm_button.onclick = function() {
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'includes/remove_image.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.onload = function() {
			 console.log('Result: ' + xhr.response);
			// if (xhr.response == 0) {
			// 	document.getElementById("image_" + image_id).remove();
			// }
		}
		var params = 'image_id=' + image_id;
		xhr.send(params);
	}
	div.appendChild(cancel_button);
	div.appendChild(confirm_button);

	overlay_content.innerHTML = "";
	overlay_content.appendChild(div);
}
