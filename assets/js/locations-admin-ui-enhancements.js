var head = document.querySelector('head'),
script = document.createElement('script');
// script.async = true;
// script.defer = true;
script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAZAyl5l3CYwD1L6J-8QCfrF_s7I4dm_No';
head.appendChild(script);



	window.addEventListener('load', function() {
		var metaBox = document.querySelector('#location-meta'),
			lat = metaBox.querySelector('input#location-meta-lat'),
			lng = metaBox.querySelector('input#location-meta-lng'),
			zoom = metaBox.querySelector('input#location-meta-zoom'),
			location,
			map,
			mapDiv,
			marker;

		mapDiv = document.createElement('div');
		mapDiv.id = 'map';
		mapDiv.style = 'height: 400px; width: 100%;';
		metaBox.appendChild(mapDiv);

		location = {lat: parseFloat(lat.value), lng: parseFloat(lng.value)};
		// The map, centered at location
		map = new google.maps.Map(document.getElementById('map'), {zoom: parseFloat(zoom.value), center: location});
		// The marker, positioned at location
		marker = new google.maps.Marker({position: location, map: map});
	});