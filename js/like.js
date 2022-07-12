let like_button = document.getElementById("like_button");

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
	
}
