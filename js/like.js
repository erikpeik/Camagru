let like_button = document.getElementById("like_button");
let like_names = document.getElementById("like-names");
let close_likes = document.getElementById("cross");
let like_users = document.getElementById("like-users");
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
		console.log('Result: ' + xhr.response);
		if (xhr.response == 0) {
			like_count.innerHTML = like_count_value + 1;
			like_button.style.color = "#ED4956";
			like_button.className = "fa-solid fa-heart";
		} else {
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

	xhr.open('POST', 'includes/get_like_names.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.onload = function() {
		// console.log(xhr.response);
		var data = JSON.parse(xhr.response);
		console.log(data);
		like_users.innerHTML = "";
		var ul = document.createElement("ul");
		for (var i = 0; i < data.length; i++) {
			var li = document.createElement("li");
			li.innerHTML = data[i].users_name;
			ul.appendChild(li);
		}
		like_users.appendChild(ul);
		// like_users.innerHTML = xhr.response;
		like_names.style.display = "block";
		dim_background.style.display = "block";
	}
	var params = 'image_id=' + image_id;
	xhr.send(params);
}


close_likes.onclick = function() {
	like_names.style.display = "none";
	dim_background.style.display = "none";
}
