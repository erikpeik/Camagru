let camera_button = document.querySelector("#start-camera");
let video = document.querySelector("#video");
let click_button = document.querySelector("#click-photo");
let canvas = document.querySelector("#canvas");
let ctx = canvas.getContext('2d');
let video_div = document.querySelector('#video-div');
let sticker_div = document.getElementById("add_stickers");
let sticker_bar = document.getElementById("stickers");
let final = document.querySelector("#final-image");

var stream_width;
var stream_height;

var stream;


camera_button.addEventListener('click', async function() {
	let constraints = {
		audio: false,
		video: {
			facingMode: "user"
		}
	}
	globalThis.stream = await navigator.mediaDevices.getUserMedia(constraints);
	let stream_settings = stream.getVideoTracks()[0].getSettings();

	globalThis.stream_width = stream_settings.width;
	globalThis.stream_height = stream_settings.height;
	// console.log(stream_settings.width, stream_settings.height);
	//if (window.innerHeight > window.innerWidth) {
	if (window.matchMedia("(orientation: portrait)").matches
	&& window.matchMedia("(hover: none)").matches) {
		// console.log("Portrait");
		ctx.canvas.width = stream_settings.height;
		video_div.style.width = "480px";
		ctx.canvas.height = stream_settings.width;
		ctx.translate(stream_height, 0);
		ctx.scale(-1, 1);
	} else {
		// Landscape
		// console.log("Landscape");
		ctx.canvas.width = stream_settings.width;
		video_div.style.width = "640px";
		ctx.canvas.height = stream_settings.height;
		ctx.translate(stream_width, 0);
		ctx.scale(-1, 1);
	}

	video.srcObject = stream;
	video_div.style.display = 'inline-block';

	document.querySelector('.camera-buttons').style.width = "350px";
	document.querySelector('#click-photo').style.display = "inline-block";
	sticker_bar.style.display = 'inline-block';
});

click_button.addEventListener('click', function() {
	if (window.matchMedia("(orientation: portrait)").matches
	&& window.matchMedia("(hover: none)").matches) {
		ctx.drawImage(video, 0, 0, stream_height, stream_width);
	} else {
		ctx.drawImage(video, 0, 0, stream_width, stream_height);
	}
	let image_data_url = canvas.toDataURL('image/jpeg');

	var sticker_res = "";
	var check = sticker_div.getElementsByClassName('sticker');
	for (i = 0; i < check.length; i++) {
		if (i != 0) {
			sticker_res += ",";
		}
		var char = check[i].id.charAt(check[i].id.length - 1);
		sticker_res += char;
	}

	// data url of the image
	var http = new XMLHttpRequest();
	var params = 'img=' + image_data_url + '&stickers=' + sticker_res;
	for (i = 0; i < check.length; i++) {
		var char = check[i].id.charAt(check[i].id.length - 1);
		sticker_res += char;
		params += '&sticker_' + char + '=' + check[i].style.left + ',' + check[i].style.top
		+ ',' + check[i].offsetWidth + ',' + check[i].offsetHeight;
	}
	http.open('POST', 'includes/camera-inc.php', true);
	http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	http.onload = function() {
		// console.log(this.response);
		var img = document.createElement("img");
		img.src = 'data:image/jpg;charset=utf8;base64,' + this.response;
		img.id = "final";
		video_div.append(img);
	//	final.innerHTML += '<img id="final" src="data:image/jpg;charset=utf8;base64,' + this.response + '" />';
		var input = document.createElement("input");
		input.setAttribute("type", "hidden");
		input.setAttribute("name", "image");
		input.setAttribute("value", this.response)
		document.getElementById("image-form").appendChild(input)
	}
	http.send(params);
	video.style.display = "none";
	sticker_div.style.display = "none";
	sticker_bar.style.display = 'none';
	video_div.style.marginLeft = "200px";
	document.querySelector('.camera-buttons').style.display = 'none';
	document.querySelector('#image-form').style.display = 'block';
	globalThis.stream.getTracks()[0].stop();
});

function dragElement(element, nbr) {
	let sticker = document.querySelector("#sticker_" + nbr);

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

function add_sticker(nbr) {
	var check = sticker_div.getElementsByClassName('sticker');
	for (i = 0; i < check.length; i++) {
		if (check[i].id == "sticker_" + nbr) {
			check[i].remove();
			return ;
		}
	}
	let img = document.createElement("img");
	img.src = "images/stickers/" + nbr + ".png";
	img.id = "sticker_" + nbr;
	img.className = "sticker";
	img.style.top = "0px";
	img.style.left = "0px";
	sticker_div.appendChild(img);
	dragElement(img, nbr);
}
