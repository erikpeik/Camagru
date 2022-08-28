function dragElement(element, nbr) {
	let sticker = document.querySelector("#sticker_" + nbr);

	var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
	if (document.getElementById(element.id + "header")) {
		document.getElementById(element.id + "header").onmousedown = dragMouseDown;
	} else {
		element.onmousedown = dragMouseDown;
	}

	sticker.addEventListener("touchstart", function(e) {
		document.body.style.overflow = "hidden";
	}, { passive: true });

	sticker.addEventListener('touchmove', function(e) {
		let final_img = document.querySelector('#final');
		if (final_img == null) {
			final_img = document.querySelector("#upload");
		}
		var position = video.getBoundingClientRect();
		var touch_location = e.targetTouches[0];

		left_pos = touch_location.pageX - (sticker.offsetWidth / 2);
		top_pos = touch_location.pageY - position.top - (sticker.offsetHeight / 2);
		if (left_pos < 0) {
			left_pos = 0;
		}
		if (top_pos < 0) {
			top_pos = 0;
		}
		if (video.style.display != "none") {
			if (left_pos > video.offsetWidth - sticker.offsetWidth) {
				left_pos = video.offsetWidth - sticker.offsetWidth;
			}
			if (top_pos > video.offsetHeight - sticker.offsetHeight) {
				top_pos = video.offsetHeight - sticker.offsetHeight;
			}
		}  else if (final_img != null) {
			if (left_pos > final_img.offsetWidth - sticker.offsetWidth) {
				left_pos = final_img.offsetWidth - sticker.offsetWidth;
			}
			if (top_pos > final_img.offsetHeight - sticker.offsetHeight) {
				top_pos = final_img.offsetHeight - sticker.offsetHeight;
			}
		}

		element.style.top = top_pos + "px";
		element.style.left = left_pos + "px";
	}, { passive: true} );

	sticker.addEventListener('touchend', function(e) {
		document.body.style.overflow = "";
	})

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

		let final_img = document.querySelector('#final');
		if (final_img == null) {
			final_img = document.querySelector("#upload");
		}

		pos1 = pos3 - e.clientX;
		pos2 = pos4 - e.clientY;
		pos3 = e.clientX;
		pos4 = e.clientY;

		top_pos = element.offsetTop - pos2;
		left_pos = element.offsetLeft - pos1;

		if (left_pos < 0) {
			left_pos = 0;
		}
		if (top_pos < 0) {
			top_pos = 0;
		}
		if (video.style.display != "none") {
			if (left_pos > video.offsetWidth - sticker.offsetWidth) {
				left_pos = video.offsetWidth - sticker.offsetWidth;
			}
			if (top_pos > video.offsetHeight - sticker.offsetHeight) {
				top_pos = video.offsetHeight - sticker.offsetHeight;
			}
		} else if (final_img != null) {
			if (left_pos > final_img.offsetWidth - sticker.offsetWidth) {
				left_pos = final_img.offsetWidth - sticker.offsetWidth;
			}
			if (top_pos > final_img.offsetHeight - sticker.offsetHeight) {
				top_pos = final_img.offsetHeight - sticker.offsetHeight;
			}
		}
		element.style.top = top_pos + "px";
		element.style.left = left_pos + "px";
	}

	function closeDragElement() {
		document.onmouseup = null;
		document.onmousemove = null;
	}
}
