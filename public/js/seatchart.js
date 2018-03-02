// attribute
var precio = 0.00;

function init(eventId, sectionId) {
  console.log("Inicializado");
  // evento, seccion
  // Sets the ID to each seat from that section
  getSeatsId(eventId, sectionId);

  // add onClick to does seats availible to sell
  // allows to select seats to sell
  setTimeout(setEventSeatsSell, 3000);
}

function getSeatsId(eventId, sectionId) {
  // Create request
  var x = new XMLHttpRequest();
  // Prepare request
  x.open('GET', 'http://stadium.local.net/api/seats/section/' + sectionId, true);
  // Send request
  x.send();

  // Handle readyState change event
  x.onreadystatechange = function() {
    // check status
    //status : 200=OK, 404=Page not found, 500=server denied access
    // readyState : 4=Back with data
    if (x.status == 200 && x.readyState == 4) {
      setSeatId(eventId, x.responseText);
    }
  }

  // evento, seccion
  // consulta el precio de las butacas en la secccion
  getPrice(1, 9);
}

// sets id's to seats
function setSeatId(eventId, data) {
  var JSONdata = JSON.parse(data);
  var seats = document.getElementsByClassName("available");
  var seat = 0;

  // sets all the id's to each seat from the section
  for (var i = 0; i < 15; i++) {
    for (var j = 0; j < 20; j++) {
      seats[seat].id = JSONdata.seats[seat].id;
      seat++;
    }
  }

  // gets all seats bougth from the section
    for (var i = 0; i < seats.length; i++) {
    getSeatsBougth(eventId, seats[i].id);
  }

  // gets all seats from the list, ready to sell
  var x = new XMLHttpRequest();
  x.open('GET', 'http://stadium.local.net/api/seats/', true);
  x.send();

  x.onreadystatechange = function() {
    if (x.status == 200 && x.readyState == 4) {
      try {
        JSONdata = JSON.parse(x.responseText);
        var selected = JSONdata.Seleccionados;

        for (var i = 0; i < seats.length; i++) {
          for (var j = 0; j < selected.length; j++) {
            if (seats[i].id == selected[j].id) {

              seats[i].setAttribute("class", "selected");
              //console.log(seats[i].className());

              seats[i].onclick = function() { setAvailableAgain(this) };
              //setToList(selected[i].id, precio);
            }
          }
        }
      } catch(e) { }
    }
  }



  // toBuy()
}

function getSeatsBougth(eventId, seatId) {
  var x = new XMLHttpRequest();
  x.open('GET', 'http://stadium.local.net/api/tickets/sale/' + eventId + '/seat/' + seatId, true);
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
    getList();
  }
}

function toBuy(seat) {
  seat.setAttribute("class", "selected");
  seat.onclick = function() { setAvailableAgain(this) };
  // add to list to sell all boletos
  setToList(seat.id, precio);
}

function setAvailableAgain(seat) {
  seat.setAttribute("class", "available");
  seat.onclick = function() { toBuy(this) };
  // delete seat from the list, to make it available again
  deleteFromList(seat.id);
}

function getPrice(eventId, sectionId) {
  var x = new XMLHttpRequest();
  x.open('GET', 'http://stadium.local.net/api/prices/event/' + eventId + '/section/'+ sectionId, true);
  x.send();

  x.onreadystatechange = function() {
    // set price
    if (x.status == 200 && x.readyState == 4) {
      var JSONdata = JSON.parse(x.responseText);
      var price = JSONdata.price.price;
      precio = price;
    }
  }
}

function setToList(seatId, price) {
  var x = new XMLHttpRequest();
  x.open('POST', 'http://stadium.local.net/api/seats/list/add/id/' + seatId + '/price/' + price, true);
  x.send();

  x.onreadystatechange = function() {
    if (x.status == 200 && x.readyState == 4) {
      try {
        // sets different color to each seat bougth
        viewSeatsBougth(x.responseText);
      } catch(e) { }
    }
  }

  getList();

}


function getList() {
  // get seats
  var x = new XMLHttpRequest();
  x.open('GET', 'http://stadium.local.net/api/seats/list/get', true);
  x.send();

  x.onreadystatechange = function() {
    if (x.status == 200 && x.readyState == 4) {
      try {
        setList(x.responseText);
      } catch(e) { }
    }
  }
}
function setList(data) {
  var JSONdata = JSON.parse(data);
  var seats = JSONdata.Seleccionados;

  var aside = document.getElementById("seatsSubtotal");
  aside.innerHTML = '';

  for (var i = 0; i < seats.length; i++) {
    var div = document.createElement('div');
    div.className = 'checkbox';
    var label = document.createElement('label');
    label.innerHTML = 'Butaca: ' + seats[i].id + '. Precio: ' + seats[i].price;
    label.className = 'container';
    var br = document.createElement('br');
    var checkbox = document.createElement('input');
    checkbox.type = 'checkbox';
    checkbox.id = seats[i].id;
    checkbox.value = seats[i].price;

    div.appendChild(checkbox);
    div.appendChild(label);
    aside.appendChild(div);
    aside.appendChild(br);
  }

}

function deleteFromList(seatId) {
  var x = new XMLHttpRequest();
  x.open('DELETE', 'http://localhost/stadium/webapp/apis/butacaLista.php?delete=' + seatId, true);
  x.send();

  x.onreadystatechange = function() {
    if (x.status == 200 && x.readyState == 4) {
      try {
        getList(x.responseText);
      } catch(e) { }
    }
  }

  // get seats
  x = new XMLHttpRequest();
  x.open('GET', 'http://localhost/stadium/webapp/apis/butacaLista.php?getAll', true);
  x.send();

  x.onreadystatechange = function() {
    if (x.status == 200 && x.readyState == 4) {
      try {
        getList(x.responseText);
      } catch(e) { }
    }
  }

}
