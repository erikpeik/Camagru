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