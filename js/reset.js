let reset_form = document.getElementById('reset_form');
let reset_error = document.getElementById('reset_error');
let reset_h3 = document.getElementById('reset_h3');
let reset_text = document.getElementById('reset_text');

if (reset_form != null) {
	reset_form.addEventListener('submit', function(e) {
		if (reset_form.submit.value != null) {
			xhr = new XMLHttpRequest();
			xhr.open('POST', 'includes/password_reset_mail.php', true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.onload = function() {
				console.log(xhr.response);
				var data = xhr.response;
				var res = data.match(/Error: /);
				if (res != null) {
					var message = data.replace(/Error: /, '');
					reset_error.innerHTML = message;
				} else {
					reset_error.innerHTML = ''
					document.getElementById("lock").style.display = "none";
					reset_h3.style.marginTop= "30px";
					reset_h3.innerHTML = 'Email Sent'
					document.title = "Email Sent • Camagru";
					reset_text.innerHTML = 'An email has been sent to your email address. Please check your inbox and click on the link to reset your password.';
					document.querySelector(".signup-form").style.display = "none";
					document.getElementById("back_to_login").style.display = "none";
					document.querySelector('.box').style.height = "170px";
					let button = document.getElementById("ok_button");
					button.addEventListener('click', function(e) {
						window.location.reload();
					});
					button.style.display = 'block';
					document.querySelector('.box').appendChild(button);
				}
			}
			var params = 'name=' + reset_form.name.value + '&submit=' + reset_form.submit.value;
			xhr.send(params);
		}
	});
}
