let camera_button = document.querySelector("#start-camera");
let video = document.querySelector("#video");
let click_button = document.querySelector("#click-photo");
let canvas = document.querySelector("#canvas");
let ctx = canvas.getContext('2d');

camera_button.addEventListener('click', async function() {
	let stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
	video.srcObject = stream;
});

click_button.addEventListener('click', function() {
	ctx.translate(canvas.width, 0);
	ctx.scale(-1, 1);
	ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
	let image_data_url = canvas.toDataURL('image/jpeg');

	// data url of the image
	console.log(image_data_url);
	var http = new XMLHttpRequest();
	var url = 'includes/camera-inc.php';
	var params = 'img=' + image_data_url;
	http.open('POST', url, true);
	http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	http.onreadystatechange = function() {
		if (http.readyState == 4 && http.status == 200) {
			alert(http.responseText);
		}
	}
	http.send(params);
});
