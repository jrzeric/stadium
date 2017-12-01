function init() {
  console.log("Inicializado");

  // evento, seccion
  // Le agrega el ID a cada butaca dentro de la seccion seleccionada
  getSeatsId(1, 9);
}

function getSeatsId(eventId, sectionId) {
  // Create request
  var x = new XMLHttpRequest();
  // Prepare request
  x.open('GET', 'http://localhost/stadium/webapp/apis/butaca.php?section=' + sectionId, true);
  // Send request
  x.send();

  // Handle readyState change event
  x.onreadystatechange = function() {
    // check status
    //status : 200=OK, 404=Page not found, 500=server denied access
    // readyState : 4=Back with data
    if (x.status == 200 && x.readyState == 4) {
      //show buildings
      setSeatId(eventId, x.responseText);
    }
  }
}

// sets id's to seats
function setSeatId(eventId, data) {
  var JSONdata = JSON.parse(data);
  var seats = document.getElementsByClassName("seat");
  var seat = 0;

  // sets all the id's to each seat from the section
  for (var i = 0; i < 15; i++) {
    for (var j = 0; j < 20; j++) {
      seats[seat].id = JSONdata.butacas[seat].id;;
      seat++;
    }
  }

  // gets all seats bougth from the section
  for (var i = 0; i < seats.length; i++) {
    getSeatsBougth(eventId, seats[i].id);
  }
}

function getSeatsBougth(eventId, seatId) {
  // Create request
  var x = new XMLHttpRequest();
  // Prepare request
  x.open('GET', 'http://localhost/stadium/webapp/apis/boleto.php?evento=' + eventId + '&butaca=' + seatId, true);
  // Send request
  x.send();

  // Handle readyState change event
  x.onreadystatechange = function() {
    // check status
    //status : 200=OK, 404=Page not found, 500=server denied access
    // readyState : 4=Back with data
    if (x.status == 200 && x.readyState == 4) {
      //show buildings
      try {
        viewSeatsBougth(x.responseText);
      } catch(e) { }
    }
  }
}

// sets different color to each seat bougth
function viewSeatsBougth(data) {
  var JSONdata = JSON.parse(data);
  var seatId = JSONdata.butaca;

  // change fill color
  var seat = document.getElementById(seatId);
  seat.style.fill = "lightgray";
}
