let camera_button = document.querySelector("#start-camera");
let video = document.querySelector("#video");
let click_button = document.querySelector("#click-photo");
let canvas = document.querySelector("#canvas");
let ctx = canvas.getContext('2d');


var stream_width;
var stream_height;

camera_button.addEventListener('click', async function() {
	let constraints = {
		audio: false,
		video: {
			width: { ideal: 640 },
			height: { ideal: 480}
		}
	}
	let stream = await navigator.mediaDevices.getUserMedia(constraints);

	let stream_settings = stream.getVideoTracks()[0].getSettings();

	globalThis.stream_width = stream_settings.width;
	globalThis.stream_height = stream_settings.height;
	ctx.canvas.width = stream_settings.width;
	ctx.canvas.height = stream_settings.height;

	console.log('Width: ' + stream_width + 'px');
	console.log('Height: ' + stream_height + 'px');

	video.srcObject = stream;
});

click_button.addEventListener('click', function() {
	console.log('Width: ' + stream_width + 'px');
	console.log('Height: ' + stream_height + 'px');

	ctx.translate(canvas.width, 0);
	ctx.scale(-1, 1)
	ctx.drawImage(video, 0, 0, stream_width, stream_height);
	let image_data_url = canvas.toDataURL('image/jpeg');

	// data url of the image
	var http = new XMLHttpRequest();
	var url = 'includes/camera-inc.php';
	var params = 'img=' + image_data_url;
	http.open('POST', url, true);
	http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	http.send(params);
});
