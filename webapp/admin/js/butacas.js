//values
var days = ['A', 'B', 'C', 'D', 'E']; 
var time = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10','11', '12','13', '14', '15', '16', '17', '18', '19', '20'];

//init
function init() {
    drawEmptySchedule();
    getGroups();
}

//draw empty schedule
function drawEmptySchedule() {
    //Create table
    var table = document.createElement('table');
    table.id = 'tableschedule';
    //headers
    var rowHeader = document.createElement('tr');
    //hour header
    var hourHeader = document.createElement('th');
    hourHeader.innerHTML = 'Select a Seat';
    hourHeader.style.width = '10%';
    rowHeader.appendChild(hourHeader);
    for(var i = 0; i < days.length; i++) {
        var cellHeader = document.createElement('th');
        cellHeader.innerHTML = days[i];
        cellHeader.style.width = '10%';
        rowHeader.appendChild(cellHeader);
    }
    //Add header row to table
    table.appendChild(rowHeader);
    
    //empty cells
    for(var i = 0; i < time.length; i++) {
        var row = document.createElement('tr');
        var cellHour = document.createElement('td');
        cellHour.innerHTML = time[i];
        cellHour.className = 'hour';
        row.appendChild(cellHour);
        table.appendChild(row);
        for( var d = 0; d < days.length; d++) {
            var cell = document.createElement('td');
            cell.className = 'empty';
            cell.id = '0' + (i+1) + '0' + (d+1);
            cell.innerHTML = days[d] + time[i];
            row.appendChild(cell);
        }
    }
    //Add table to content
    document.getElementById('content').appendChild(table);
    
}
//Get groups
function getGroups() {
    //Create request
    var x = new XMLHttpRequest();
	//prepare request
	x.open('GET', 'http://cisatj.com/exam/groups.php', true);
	//send request
	x.send();
	//handle readyState change event
	x.onreadystatechange = function() {
		// check status
		// status : 200=OK, 404=Page not found, 500=server denied access
		// readyState : 4=Back with data
		if (x.status == 200 && x.readyState == 4) {
			
			populateSelectGroup(x.responseText);
		}
	}   
}
    
function populateSelectGroup(data) {
    var select = document.getElementById("selgroup");
    var JSONdata = JSON.parse(data);
    var groups = JSONdata.groups
    for (var i=0; i < groups.length; i++)
    {
      var option = document.createElement("option");
      option.id = groups[i].id;
      option.value = groups[i].id;
      option.innerHTML = groups[i].description;
      select.appendChild(option);
    }   
}

//Get schedule
function getSchedule(groupId) {
    if(groupId != null) {
        //create request
        var x = new XMLHttpRequest();
        //prepare request
        x.open('GET', 'http://cisatj.com/exam/schedule.php?groupid=' + groupId, true);
        //send request
        x.send();
        //handle readyState change event
        x.onreadystatechange = function() {
            // check status
            // status : 200=OK, 404=Page not found, 500=server denied access
            // readyState : 4=Back with data
            if (x.status == 200 && x.readyState == 4) {
                var JSONdata = JSON.parse(x.responseText); console.log(JSONdata);
                for(var i = 0; i < JSONdata.schedule.length; i++) {
                    var hourId = JSONdata.schedule[i].hour.id;
                    var dayId = JSONdata.schedule[i].day.id;
                    var cellId = hourId + dayId;
                    document.getElementById(cellId).innerHTML = JSONdata.schedule[i].subject.description + ' ' + JSONdata.schedule[i].professor.name;
                    document.getElementById(cellId).style.background = JSONdata.schedule[i].subject.color;
                }
            }
	   }
    }
}   

function mensaje(){
	alert("Lugares asignados Correctamente :)");
	window.location = 'realizarVenta.html';
}