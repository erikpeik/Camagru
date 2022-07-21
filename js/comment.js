function focus_comment(image_id) {
	var textarea = document.getElementById('comment_' + image_id);
	textarea.focus();
}

function add_comment(form, image_id) {
	var comment = form['comment'].value;
	var comment_box = document.getElementById('comment_box_' + image_id);

	form['comment'].value = "";
	var xhr = new XMLHttpRequest();

	xhr.open('POST', 'includes/add_comment.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.onload = function() {
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'includes/get_comment_amount.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.onload = function() {
			var comment_amount = parseInt(xhr.responseText);
			console.log("Amount: " + comment_amount);
			comment_box.style.removeProperty("display");
			if (comment_amount == 1) {
				comment_box.innerHTML = "View " + comment_amount + " comment";
			}
			else if (comment_amount > 1) {
				comment_box.innerHTML = "View all " + comment_amount + " comments";
			}
			else {
				comment_box.innerHTML = "";
			}
		}
		var params = 'image_id=' + image_id;
		xhr.send(params);

	}
	var params = 'image_id=' + image_id + '&comment=' + comment;
	xhr.send(params);
}

function get_comments(image_id, user_id) {
	var xhr = new XMLHttpRequest();

	xhr.open('POST', 'includes/get_comments.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.onload = function() {
		var data = JSON.parse(xhr.response);
		var comments = document.getElementById('comments_' + image_id);
		comments.innerHTML = "";
		if (data.length > 0) {
			for (var i = 0; i < data.length; i++) {
				var comment = data[i];
				var div = document.createElement("div");
				div.className = "comment";
				div.innerHTML = "<p>" + comment.users_name + ": " + comment.comment + "</p>";
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
