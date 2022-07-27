let camera_button = document.querySelector("#start-camera");
let video = document.querySelector("#video");
let click_button = document.querySelector("#click-photo");
let canvas = document.querySelector("#canvas");
let ctx = canvas.getContext('2d');
let video_div = document.querySelector('#video-div');
let sticker_div = document.getElementById("add_stickers");
let sticker_bar = document.getElementById("stickers");
let drafts = document.querySelector("#drafts");
let image_form = document.querySelector('#image-form');
let cancel_image = document.querySelector("#cancel-image");
let container = document.querySelector('.container');

var stream_width;
var stream_height;

var stream;

// Start Camera
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

	if (window.matchMedia("(orientation: portrait)").matches
	&& window.matchMedia("(hover: none)").matches) {
		// Portrait
		ctx.canvas.width = stream_settings.height;
		video_div.setAttribute("width", "480px");
		ctx.canvas.height = stream_settings.width;
		ctx.translate(stream_height, 0);
		ctx.scale(-1, 1);
	} else {
		// Landscape
		ctx.canvas.width = stream_settings.width;
		video_div.setAttribute("width", "640px");
		ctx.canvas.height = stream_settings.height;
		ctx.translate(stream_width, 0);
		ctx.scale(-1, 1);
	}

	video.srcObject = stream;
	video_div.style.display = 'inline-block';

	document.querySelector('.camera-buttons').style.width = "350px";
	document.querySelector('#click-photo').style.display = "inline-block";
	sticker_bar.style.display = 'inline-block';
	drafts.style.display = 'inline-block';
});

// Take Picture
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
	if (check.length < 1) {
		alert("Before taking picture please add a sticker");
		return ;
	}
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
		var input = document.createElement("input");
		input.setAttribute("type", "hidden");
		input.setAttribute("name", "image");
		input.setAttribute("value", this.response)
		image_form.appendChild(input)
	}
	http.send(params);
	video.style.display = "none";
	sticker_div.style.display = "none";
	sticker_bar.style.display = 'none';
	drafts.style.display = 'none';
	// video_div.style.marginLeft = "200px";
	document.querySelector('.camera-buttons').style.display = 'none';
	image_form.style.display = 'block';
	container.style.width = '640px';
	container.style.marginTop = '57px';
});



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

function back_to_camera() {
	video.style.display = "inline-block";
	sticker_div.style.display = "inline-block";
	sticker_bar.style.display = 'inline-block';
	drafts.style.display = 'inline-block';
	document.querySelector('.camera-buttons').style.display = 'block';
	image_form.style.display = 'none';
	// video_div.style.marginLeft = "0px";
	container.style.width = '';
	container.style.marginTop = '0px';
}

cancel_image.addEventListener("click", function(e) {
	var data = this;
	console.log(data);
	if (document.querySelector("#final") != null) {
		document.querySelector("#final").remove();
	}
	if (image_form['image'] != null) {
		image_form.removeChild(image_form['image']);
	}
	back_to_camera();
});

image_form.addEventListener('submit', function(e) {
	var data = this;
	// console.log(data);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'includes/store-image.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.onload = function() {
		var img = document.createElement("img");
		img.src = 'data:image/jpg;charset=utf8;base64,' + data['image'].value;
		drafts.append(img);
		if (document.querySelector("#final") != null) {
			document.querySelector("#final").remove();
		}
		data.removeChild(data['image']);
		back_to_camera();
	}
	console.log(data['image'].value);
	var params = 'image=' + String(data['image'].value) +
	'&caption=' + data['caption'].value +
	'&submit=' + data['submit'].value;
	xhr.send(params);
	e.preventDefault();
});

if (document.querySelector("#cross") != null) {
	document.querySelector("#cross").addEventListener("click", function() {
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'includes/cookie_usage.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xhr.onload = function() {
			document.querySelector(".information").style.display = "none";
		}
		xhr.send();
	});
}
