let pagination_number = document.getElementById("pagination_number");

pagination_number.addEventListener('change', function() {
	window.location.href='?page=' + pagination_number.value + "#pagination";
}, true);
