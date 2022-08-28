function does_users_id_match(div, comment, type) {
	var xhr = new XMLHttpRequest();
	if (type === "comment") {
		xhr.open('POST', 'includes/does_it_match.php', true);
	} else {
		xhr.open('POST', '../includes/does_it_match.php', true);
	}
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.onload = function () {
		if (this.status == 200) {

			match = this.responseText;
			if (match == 'true') {
				div.innerHTML = '<p><a href="../profile/' + comment.users_uid +
				'" id="comment_username">' + comment.users_uid + '</a>: ' +
				 comment.comment + '</p>' + '<button onclick="delete_comment(' +
				comment.comment_id + ', ' + comment.image_id + ')">' +
				'<i class="fa fa-trash-o"></i></button>';
			} else {
				div.innerHTML = '<p><a href="../profile/' + comment.users_uid +
				'" id="comment_username">' + comment.users_uid + '</a>: ' +
				 comment.comment + '</p>';
			}
		}
	}
	var params = 'users_id=' + comment.users_id + '&image_id=' + comment.image_id;
	xhr.send(params);
}

