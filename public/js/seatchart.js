// attribute
var precio = 0.00;
var eventId = 0;
var sectionId = 0;
var dataSeats;
var dataPrices;

function init(eventId, sectionId) {
  console.log(sessionStorage.section);
  console.log(sessionStorage.area);
  console.log("Inicializado");
  this.eventId = eventId;
  this.sectionId = sectionId;
  // evento, seccion
  // Sets the ID to each seat from that section
  getSeatsId(eventId, sectionId);

  // add onClick to does seats availible to sell
  // allows to select seats to sell
  setTimeout(setEventSeatsSell, 1000);
}

function getSeatsId(eventId, sectionId) {
  // Create request
  var x = new XMLHttpRequest();
  // Prepare request
  x.open('GET', 'http://stadium.local.net/api/seats/section/' + sessionStorage.section + '/area/' + sessionStorage.area, true);
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
  getPrice(eventId, sectionId);
}

// sets id's to seats
function setSeatId(eventId, data) {
  var JSONdata = JSON.parse(data);
  var seats = document.getElementsByClassName("available");
  var seat = 0;
  var seatsJSON = JSONdata.seats;
  console.log(seatsJSON[1].id);

  console.log(seatsJSON.length);

  var elements = document.getElementsByClassName("available");

  // sets all the id's to each seat from the section
  for (var i = 0; i < seatsJSON.length; i++)
  {
    //var id = "XMLID_" + (i + 1) + "_";
    //console.log("Id del asiento" + id);
    //console.log("Id de la BD" + seatsJSON[i].id);
    elements[i].setAttribute("id", seatsJSON[i].id);
  }

  console.log("Evento: " + sessionStorage.event);

  // gets all seats bougth from the section

    // Create request
    var x = new XMLHttpRequest();
    // Prepare request
    x.open('GET', 'http://stadium.local.net/api/tickets/event/' + sessionStorage.event + '/section/' + sessionStorage.section + '/area/' + sessionStorage.area, true);
    // Send request
    x.send();

    // Handle readyState change event
    x.onreadystatechange = function() {
      // check status
      //status : 200=OK, 404=Page not found, 500=server denied access
      // readyState : 4=Back with data
      if (x.status == 200 && x.readyState == 4)
      {
        var JSONdata1 = JSON.parse(x.responseText);
        if (JSONdata1.status == 0)
        {
          var selledSeats = JSONdata1.tickets;
          for (var i = 0; i < selledSeats.length; i++)
          {
            console.log(selledSeats[i].seat.id);
            document.getElementById(selledSeats[i].seat.id).setAttribute("class", "selled");
          }
        }
      }
    }
}

function getSeatsBougth()
{
}

// sets different color to each seat bougth
function viewSeatsBougth(dataSeats, dataPrices) {
  var JSONdataSeats = JSON.parse(dataSeats);
  console.log(JSONdataSeats.seat);
  var seatId = JSONdataSeats.seat.id;
  console.log(seatId);

  // change fill color, taked from class 'selled'

}

function setEventSeatsSell() {
  var seats = document.getElementsByClassName("available");
  var i = 0;
  for ( i = 0; i < seats.length; i++) {
    var seat = document.getElementById(seats[i].id);
    seat.onclick = function() { toBuy(this) };
    //seat.addEventListener('click', function() { toBuy(this.id); }); -- The addEventListener() method is not supported in Internet Explorer 8 and earlier versions.
  }

  viewChartSelectedSeats();
  printTicketPreview();
}

function toBuy(seat) {
  seat.setAttribute("class", "selected");
  seat.onclick = function() { setAvailableAgain(this) };
  // add to list to sell all boletos
  setToList(seat.id);
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

function setToList(seatId) {
    // Get information about the seat like Row, Column, Section, Area and Number of seat.
    var seats = new XMLHttpRequest();
    seats.open('GET', 'http://stadium.local.net/api/seats/' + seatId, true);
    seats.send();

    // Get information about price of the section, where is the seat selected.
    var prices = new XMLHttpRequest();
    prices.open('GET', 'http://stadium.local.net/api/prices/event/' + eventId + '/section/' + sectionId, true);
    prices.send();

    seats.onreadystatechange = function() {
      if (seats.status == 200 && seats.readyState == 4) {
        try {
          dataSeats = seats.responseText
          console.log();
        } catch(e) { }
      }
    }

    prices.onreadystatechange = function() {
      if (prices.status == 200 && prices.readyState == 4) {
        try {
          dataPrices = prices.responseText
          console.log();
        } catch(e) { }
      }
    }

    var JSONdataSeats = JSON.parse(dataSeats);
    var seat = JSONdataSeats.seat;
    console.log(seat);

    var JSONdataPrices = JSON.parse(dataPrices);
    var price = JSONdataPrices.price;
    console.log(price);

    //delete sessionStorage.tickets;
    // New data
    var data = [];
    data.push({
      'title': price.event.name,
      'section': seat.section.name + ' ' + seat.section.area.name,
      'price1': parseFloat(price.price),
      'price2': parseFloat(0),
      'row': seat.row,
      'seat': seat.id,
      'total': parseFloat(price.price)
    });

    // Retrieve data from session if exists
    var sessionData = [];
    if (sessionStorage.getItem('tickets') !== null) {
        session = JSON.parse(sessionStorage.getItem('tickets'));

        for (var i = 0; i < session.length; i++) {
            sessionData.push({
                'title': session[i].title,
                'section': session[i].section,
                'price1': session[i].price1,
                'price2': session[i].price2,
                'row': session[i].row,
                'seat': session[i].seat,
                'total': session[i].total
            });
        }
    }

    // Set new data ready to save in session
    sessionData.push(data[0]);

    // Saves all data to session
    data = JSON.stringify(sessionData);
    sessionStorage.setItem("tickets", data);

    console.log(JSON.parse(sessionStorage.getItem('tickets')));
    printTicketPreview();
}

function printTicketPreview() {
    if (sessionStorage.getItem('tickets') !== null) {
        var session = JSON.parse(sessionStorage.getItem('tickets'));

        var tickets = document.getElementById('tickets');
        tickets.innerHTML = '';

        var total = 0.00;

        for (var i = 0; i < session.length; i++) {
            var ticket = document.createElement('div');
            ticket.className = 'ticket';
            var title = document.createElement('div');
            title.className = 'ticket__title';
            title.innerHTML = session[i].title;

            var sectionDiv = document.createElement('div');
            sectionDiv.className = 'ticket__columns--two';
            var sectionSubtitle = document.createElement('div');
            sectionSubtitle.className = 'ticket__subtitle';
            sectionSubtitle.innerHTML = 'Section';
            var sectionInfo = document.createElement('div');
            sectionInfo.className = 'ticket__info';
            sectionInfo.className += ' ticket__color--gray';
            sectionInfo.innerHTML = session[i].section;

            sectionDiv.appendChild(sectionSubtitle);
            sectionDiv.appendChild(sectionInfo);

            var ticketDiv = document.createElement('div');
            ticketDiv.className = 'ticket__columns--four';
            var ticketSubtitle = document.createElement('div');
            ticketSubtitle.className = 'ticket__subtitle--sma';
            ticketSubtitle.innerHTML = 'Ticket';
            var ticketInfo = document.createElement('div');
            ticketInfo.className = 'ticket__info--sma';
            ticketInfo.className += ' ticket__color--gray';
            ticketInfo.innerHTML = session[i].price1;

            ticketDiv.appendChild(ticketSubtitle);
            ticketDiv.appendChild(ticketInfo);

            var servicesDiv = document.createElement('div');
            servicesDiv.className = 'ticket__columns--four';
            var servicesSubtitle = document.createElement('div');
            servicesSubtitle.className = 'ticket__subtitle--sma';
            servicesSubtitle.innerHTML = 'Services';
            var servicesInfo = document.createElement('div');
            servicesInfo.className = 'ticket__info--sma';
            servicesInfo.className += ' ticket__color--gray';
            servicesInfo.innerHTML = session[i].price2;

            servicesDiv.appendChild(servicesSubtitle);
            servicesDiv.appendChild(servicesInfo);

            var rowDiv = document.createElement('div');
            rowDiv.className = 'ticket__columns--four';
            var rowSubtitle = document.createElement('div');
            rowSubtitle.className = 'ticket__subtitle';
            rowSubtitle.innerHTML = 'Row';
            var rowInfo = document.createElement('div');
            rowInfo.className = 'ticket__info';
            rowInfo.className += ' ticket__color--gray';
            rowInfo.innerHTML = session[i].row;

            rowDiv.appendChild(rowSubtitle);
            rowDiv.appendChild(rowInfo);

            var seatDiv = document.createElement('div');
            seatDiv.className = 'ticket__columns--four';
            var seatSubtitle = document.createElement('div');
            seatSubtitle.className = 'ticket__subtitle';
            seatSubtitle.innerHTML = 'Seat';
            var seatInfo = document.createElement('div');
            seatInfo.className = 'ticket__info';
            seatInfo.className += ' ticket__color--gray';
            seatInfo.innerHTML = session[i].seat;

            seatDiv.appendChild(seatSubtitle);
            seatDiv.appendChild(seatInfo);

            var totalDiv = document.createElement('div');
            totalDiv.className = 'ticket__columns--two';
            var totalSubtitle = document.createElement('div');
            totalSubtitle.className = 'ticket__subtitle';
            totalSubtitle.innerHTML = 'Total';
            var totalInfo = document.createElement('div');
            totalInfo.className = 'ticket__info';
            totalInfo.className += ' ticket__color--gray';
            totalInfo.innerHTML = session[i].total;

            totalDiv.appendChild(totalSubtitle);
            totalDiv.appendChild(totalInfo);

            ticket.appendChild(title);
            ticket.appendChild(sectionDiv);
            ticket.appendChild(ticketDiv);
            ticket.appendChild(servicesDiv);
            ticket.appendChild(rowDiv);
            ticket.appendChild(seatDiv);
            ticket.appendChild(totalDiv);

            tickets.appendChild(ticket);

            total = parseFloat(total) + parseFloat(session[i].total);
        }

        var title = document.getElementById('title');
        if (session.length == 1) {
            title.innerHTML = 'Seat';
        } else {
            title.innerHTML = 'Seats';
        }

        // Print number of tickets
        var count = document.getElementById('countTickets');
        count.innerHTML = session.length + ' ';

        // Print total
        var totalTitle = document.createElement('label');
        totalTitle.innerHTML = 'Total: ';

        var totalInfo = document.createElement('label');
        totalInfo.innerHTML = total;

        var totalDiv = document.getElementById('total');
        totalDiv.innerHTML = '';
        var h2 = document.createElement('h2');
        h2.appendChild(totalTitle);
        h2.appendChild(totalInfo);
        totalDiv.appendChild(h2);

/*
        var js = document.getElementById('js');
        js.innerHTML = JSON.stringify(session);
*/
    }

    //viewChartSelectedSeats();
}

function viewChartSelectedSeats() {
    if (sessionStorage.getItem('tickets') !== null) {
        var session = JSON.parse(sessionStorage.getItem('tickets'));
        var polygon = document.getElementsByTagName('polygon');

        for (var i = 0; i < polygon.length; i++) {
            for (var j = 0; j < session.length; j++) {
                if (polygon[i].id == session[j].seat) {
                    polygon[i].setAttribute("class", "selected");
                    polygon[i].onclick = function() { setAvailableAgain(this) };
                }
            }
        }
    }
}

function deleteFromList(seatId) {
    if (sessionStorage.getItem('tickets') !== null) {
        var session = JSON.parse(sessionStorage.getItem('tickets'));

        var indexOf = [];
        for (var i = 0; i < session.length; i++) {
            if (session[i].seat == seatId) {
                indexOf.push(i);
            }
        }

        if (indexOf.length != 0) {
            for (var i = 0; i < indexOf.length; i++) {
                session.splice(indexOf[i], 1);
            }
        }

        console.log(session);
        session = JSON.stringify(session);
        sessionStorage.setItem("tickets", session);

        viewChartSelectedSeats();
        printTicketPreview();
    }
}

function salesSelect() {
    if (sessionStorage.getItem('tickets') !== null) {
        var sale = document.getElementById('sale');
        var saleTicket = document.getElementById('saleTicket');

        sale.style.display = 'none';
        saleTicket.style.display = 'block';

        printTicketPreview();
    }
}
