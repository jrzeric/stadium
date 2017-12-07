function getEvent() {
  var select = document.getElementById('eventos');
	var eventId = select.options.selectedIndex;
	console.log(eventId);
}

function getEventos() {
  getActiveEvents();
}

function getActiveEvents() {
  var x = new XMLHttpRequest();
  x.open('GET', 'http://localhost/stadium/webapp/apis/evento.php?getAllActive', true);
  x.send();

  x.onreadystatechange = function() {
    if (x.status == 200 && x.readyState == 4) {
      var JSONdata = JSON.parse(x.responseText).eventos;

      var select = document.getElementById('eventos');
      for (var i = 0; i < JSONdata.length; i++) {
        var option = document.createElement('option');
        option.value = JSONdata[i].id;
        option.innerHTML = JSONdata[i].nombre;
        select.appendChild(option);
      }
    }
  }
}
