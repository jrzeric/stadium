function init() {
  console.log("Inicializado");

  // evento, seccion
  // Le agrega el ID a cada butaca dentro de la seccion seleccionada
  getSeatsId(1, 9);

  // add onClick to does seats availible to sell
  // allows to select seats to sell
  setTimeout(setEventSeatsSell, 3000);
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
  var seats = document.getElementsByClassName("available");
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
  var x = new XMLHttpRequest();
  x.open('GET', 'http://localhost/stadium/webapp/apis/boleto.php?evento=' + eventId + '&butaca=' + seatId, true);
  x.send();

  x.onreadystatechange = function() {
    if (x.status == 200 && x.readyState == 4) {
      try {
        // sets different color to each seat bougth
        viewSeatsBougth(x.responseText);
      } catch(e) { }
    }
  }


}

// sets different color to each seat bougth
function viewSeatsBougth(data) {
  var JSONdata = JSON.parse(data);
  var seatId = JSONdata.butaca;

  // change fill color, taked from class 'selled'
  var seat = document.getElementById(seatId);
  seat.setAttribute("class", "selled");
}

function setEventSeatsSell() {
  var seats = document.getElementsByClassName("available");
  var i = 0;
  for ( i = 0; i < seats.length; i++) {
    var seat = document.getElementById(seats[i].id);
    seat.onclick = function() { toBuy(this) };
    //seat.addEventListener('click', function() { toBuy(this.id); }); -- The addEventListener() method is not supported in Internet Explorer 8 and earlier versions.
    console.log(seat.id);
  }

}

function toBuy(seat) {
  seat.setAttribute("class", "selected");
  seat.onclick = function() { setAvailableAgain(this) };
  // add to list to sell all boletos
}

function setAvailableAgain(seat) {
  seat.setAttribute("class", "available");
  seat.onclick = function() { toBuy(this) };
}
