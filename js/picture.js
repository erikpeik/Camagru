let like_button = document.getElementById("like_button");
let close_likes = document.getElementById("cross");
let overlay_box = document.getElementById("overlay_box");
let overlay_content = document.getElementById("overlay_content");
let overlay_header = document.getElementById("overlay_header")
let dim_background = document.getElementById("dim-background");

function add_like(image_id) {
	let like_count = document.getElementById("like_count_" + image_id);
	let like_count_value = parseInt(like_count.innerHTML);
	let like_button = document.getElementById("like_button_" + image_id);

	var xhr = new XMLHttpRequest();

	xhr.open('POST', '../includes/like-inc.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.onload = function() {
		if (xhr.response == '2') {
			alert("You can like only if you are logged in");
		}
		else if (xhr.response == '0') {
			like_count.innerHTML = like_count_value + 1;
			like_button.style.color = "#ED4956";
			like_button.className = "fa-solid fa-heart";
		} else if (xhr.response == '1') {
			like_count.innerHTML = like_count_value - 1;
			like_button.style.color = "black";
			like_button.className = "fa-regular fa-heart";
		}

	}
	var params = 'image_id=' + image_id;
	xhr.send(params);
}

function show_likes(image_id) {
	var xhr = new XMLHttpRequest();

	xhr.open('POST', '../includes/get_like_names.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.onload = function() {
		var data = JSON.parse(xhr.response);
		if (data.length > 0) {
			var ul = document.createElement("ul");
			if (data.length > 6) {
				ul.style.height = "180px";
				ul.style.marginBottom = "10px";
				ul.style.overflowY = "scroll";
			}
			for (var i = 0; i < data.length; i++) {
				var li = document.createElement("li");
				li.innerHTML = data[i].users_name;
				ul.appendChild(li);
			}
			overlay_content.appendChild(ul);
			overlay_header.innerHTML = "Likes";
			overlay_box.style.display = "block";
			dim_background.style.display = "block";
		}
	}
	var params = 'image_id=' + image_id;
	xhr.send(params);
}

function close_overlay() {
	overlay_box.style.display = "none";
	dim_background.style.display = "none";
	overlay_header.innerHTML = "";
	overlay_content.innerHTML = "";
}

close_likes.onclick = function() {
	close_overlay();
}

function focus_comment(image_id) {
	var textarea = document.getElementById('comment_' + image_id);
	if (textarea != null) {
		textarea.focus();
	}
}

function update_comment_count(image_id) {
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '../includes/get_comment_amount.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.onload = function() {
		var comment_amount = parseInt(xhr.responseText);
		update_comment_amount(comment_amount, image_id);
	}
	var params = 'image_id=' + image_id;
	xhr.send(params);
}

function delete_comment(comment_id, image_id) {
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '../includes/delete_comment.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.onload = function() {
		get_comments(image_id);
		update_comment_count(image_id);
	}
	var params = 'comment_id=' + comment_id + '&image_id=' + image_id;
	xhr.send(params);
}

function update_comment_amount(comment_amount, image_id) {
	var comment_box = document.getElementById('comment_box_' + image_id);

	comment_box.style.removeProperty("display");
	if (comment_amount == 1) {
		comment_box.innerHTML = "View " + comment_amount + " comment";
	}
	else if (comment_amount > 1) {
		comment_box.innerHTML = "View all " + comment_amount + " comments";
	}
	else {
		comment_box.style.display = "none";
		comment_box.innerHTML = "";
	}
}

function add_comment(form, image_id) {
	var comment = form['comment'].value;
	form['comment'].value = "";
	var xhr = new XMLHttpRequest();

	xhr.open('POST', '../includes/add_comment.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.onload = function() {
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '../includes/get_comment_amount.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.onload = function() {
			var comment_amount = parseInt(xhr.responseText);
			update_comment_amount(comment_amount, image_id);
			get_comments(image_id);
		}
		var params = 'image_id=' + image_id;
		xhr.send(params);

	}
	var params = 'image_id=' + image_id + '&comment=' + comment;
	xhr.send(params);
}

function get_comments(image_id) {
	var comments = document.getElementById('comments_' + image_id);
	var xhr = new XMLHttpRequest();

	xhr.open('POST', '../includes/get_comments.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.onload = function() {
		var data = JSON.parse(xhr.response);
		comments.innerHTML = "";
		if (data.length > 0) {
			for (var i = 0; i < data.length; i++) {
				var comment = data[i];
				var div = document.createElement("div");
				var match = does_users_id_match(comment.users_id);
				if (match == true) {
					div.innerHTML = '<p><b style="font-weight: 500">' + comment.users_uid + '</b>: ' +
				 	comment.comment + '</p>' + '<button onclick="delete_comment(' +
					comment.comment_id + ', ' + comment.image_id + ')">' +
					'<i class="fa fa-trash-o"></i></button>';
				} else {
					div.innerHTML = '<p><b style="font-weight: 500">' + comment.users_uid + '</b>: ' +
				 	comment.comment + '</p>';
				}
				div.className = "comment";
				comments.appendChild(div);
			}
		}
	}
	var params = 'image_id=' + image_id;
	xhr.send(params);
}

function auto_grow(form) {
	var container = document.querySelector('.input-container');
	var element = form['comment'];

	element.style.height = "5px";
	var margin_amount = 289 / element.scrollHeight;
	if (margin_amount < 5) {
		margin_amount = 5;
	}

	container.style.marginTop = margin_amount + "px";
	container.style.marginBottom = margin_amount + "px";

	if (element.scrollHeight > 80) {
		element.style.overflowY = "scroll";
	} else {
		element.style.overflowY = "hidden";
	}
	element.style.height = element.scrollHeight +"px";
}

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
		xhr.open('POST', '../includes/remove_image.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.onload = function() {
			location.href = '..';
		}
		var params = 'image_id=' + image_id;
		xhr.send(params);
	}
	div.appendChild(cancel_button);
	div.appendChild(confirm_button);

	overlay_content.innerHTML = "";
	overlay_content.appendChild(div);
}

function share_picture($image_id) {
	dim_background.style.display = "block";
	overlay_box.style.display = "block";
	overlay_header.innerHTML = "Share this picture with your friends!";
	var input = document.createElement("input");
	var button = document.createElement("button");
	button.id = "share_picture";
	button.innerHTML = "Copy link to clipboard";
	button.onclick = function() {
		input.select();
		input.setSelectionRange(0, 99999);
		navigator.clipboard.writeText(input.value);
	};
	input.type = "text";
	// set input to readonly
	input.readOnly = true;

	var xhr = new XMLHttpRequest();
	xhr.open('POST', '../includes/get_app_url.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.onload = function() {
		var app_url = xhr.responseText;
		input.value = app_url + "/picture/" + $image_id;
	}
	xhr.send();
	overlay_content.appendChild(input);
	overlay_content.appendChild(button);
}
