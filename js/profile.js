let settings_button = document.getElementById('settings_button');

if (settings_button) {
	settings_button.addEventListener('click', function() {
		window.location.href = '../settings';
	});
}
