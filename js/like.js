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

	xhr.open('POST', 'includes/like-inc.php', true);
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
	var APP_URL;
	var http = new XMLHttpRequest();
	http.open('POST', 'includes/get_app_url.php', true);
	http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	http.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	http.onload = function() {
		APP_URL = http.responseText;
	}
	http.send();

	var xhr = new XMLHttpRequest();

	xhr.open('POST', 'includes/get_like_names.php', true);
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
				li.innerHTML = "<a href='"+APP_URL+"/profile/"+data[i].users_uid+"'>"
				+ data[i].users_uid + "</a>";
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
