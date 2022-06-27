let camera_button = document.querySelector("#start-camera");
let video = document.querySelector("#video");
let click_button = document.querySelector("#click-photo");
let canvas = document.querySelector("#canvas");
let ctx = canvas.getContext('2d');
let video_div = document.querySelector('#video-div');
let sticker = document.querySelector("#sticker");

var stream_width;
var stream_height;

camera_button.addEventListener('click', async function() {
	let constraints = {
		audio: false,
		video: {
			facingMode: "user"
		}
	}
	let stream = await navigator.mediaDevices.getUserMedia(constraints);
	let stream_settings = stream.getVideoTracks()[0].getSettings();

	globalThis.stream_width = stream_settings.width;
	globalThis.stream_height = stream_settings.height;
	console.log(stream_settings);
	// if (window.innerHeight > window.innerWidth) {
	// 	// Vertical
	// 	console.log("Vertical");
	// 	ctx.canvas.width = stream_settings.height;
	// 	ctx.canvas.height = stream_settings.width;
	// 	ctx.translate(stream_height, 0);
	// 	ctx.scale(-1, 1);
	// } else {
		// Horizontal
		console.log("Horizontal");
		ctx.canvas.width = stream_settings.width;
		ctx.canvas.height = stream_settings.height;
		ctx.translate(stream_width, 0);
		ctx.scale(-1, 1);
	// }

	video.srcObject = stream;
	video_div.style.display = 'block';
});

click_button.addEventListener('click', function() {
	// if (window.innerHeight > window.innerWidth) {
		ctx.drawImage(video, 0, 0, stream_height, stream_width);
	// } else {
		ctx.drawImage(video, 0, 0, stream_width, stream_height);
	// }
	let image_data_url = canvas.toDataURL('image/jpeg');

	// data url of the image
	var http = new XMLHttpRequest();
	var url = 'includes/camera-inc.php';
//	console.log(sticker.style.top);
	console.log(sticker.style.left);
	var params = 'img=' + image_data_url + '&sticker=' + sticker.src
	+ '&left=' + sticker.style.left + '&top=' + sticker.style.top
	+ '&width=' + sticker.offsetWidth + '&height=' + sticker.offsetHeight;
	http.open('POST', url, true);
	http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	http.onload = function() {
		console.log(this.response);
	}
	http.send(params);

});

dragElement(document.getElementById("sticker"));

function dragElement(element) {
	var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
	if (document.getElementById(element.id + "header")) {
		document.getElementById(element.id + "header").onmousedown = dragMouseDown;
	} else {
		element.onmousedown = dragMouseDown;
	}

	function dragMouseDown(e) {
		e = e || window.event;
		e.preventDefault();
		// get the mouse cursor position at startup:
		pos3 = e.clientX;
		pos4 = e.clientY;
		document.onmouseup = closeDragElement;
		document.onmousemove = elementDrag;
	}

	function elementDrag(e) {
		e = e || window.event;
		e.preventDefault();

		pos1 = pos3 - e.clientX;
		pos2 = pos4 - e.clientY;
		pos3 = e.clientX;
		pos4 = e.clientY;

		top_pos = element.offsetTop - pos2;
		left_pos = element.offsetLeft - pos1;

		if (left_pos < 0) {
			left_pos = 0;
		}
		if (left_pos > video_div.offsetWidth - sticker.offsetWidth) {
			left_pos = video_div.offsetWidth - sticker.offsetWidth;
		}
		if (top_pos < 0) {
			top_pos = 0;
		}
		if (top_pos > video_div.offsetHeight - sticker.offsetHeight) {
			top_pos = video_div.offsetHeight - sticker.offsetHeight;
		}
		element.style.top = top_pos + "px";
		element.style.left = left_pos + "px";
	}

	function closeDragElement() {
		document.onmouseup = null;
		document.onmousemove = null;
	}
}
