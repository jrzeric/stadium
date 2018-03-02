//show popup
var area = 0;
var eventId = 0;
function popupSections(area)
{
	var titulo = 'Seccion del area ' + area;
	var ancho = 215;
	var altura = 225;
	if (area == 9 || area == 10) altura = 100;
	var popup = new PopupWindow(titulo, ancho, altura);

	this.area = area;

	// get eventId
	var eventComboBox = document.getElementById('eventos');
  var eventId = eventComboBox.options[eventComboBox.selectedIndex].value;
  this.eventId = eventId;

	if (area == 1 || area == 2 || area == 3 || area == 5 || area == 6 || area == 7) {
		// Areas con tres secciones
		popup.addNegativeButton('Arriba', 'arriba()');
		popup.addPositiveButton('Medio', 'medio()');
		popup.addCustomButton('Abajo', 'abajo()');

	} else {
		if (area == 4 || area == 8) {
			// Areas con dos secciones
			popup.addPositiveButton('Medio', 'medio()');
			popup.addCustomButton('Abajo', 'abajo()');
		} else {
			// Palcos
			popup.addNegativeButton('Arriba', 'arriba()');
		}
	}
	popup.show();
}

function arriba()
{
	var sectionId = 0;
	switch(this.area) {
		case 1: sectionId = 1; break;
		case 2: sectionId = 4; break;
		case 3: sectionId = 7; break;
		case 5: sectionId = 12; break;
		case 6: sectionId = 15; break;
		case 7: sectionId = 18; break;
		case 9: sectionId = 23; break;
		case 10: sectionId = 24; break;
	}


	// stablish where the form go
	var form = document.getElementById('topForm');
	form.method = "get";
  form.action = "sales/create";
  //$("#topForm").attr("action", "p");

	var setEvent = document.createElement('input');
	setEvent.type = 'hidden';
	setEvent.name = 'event';
	setEvent.value = this.eventId;

	var setArea = document.createElement('input');
	setArea.type = 'hidden';
	setArea.name = 'area';
	setArea.value = this.area;


	var setSection = document.createElement('input');
	setSection.type = 'hidden';
	setSection.name = 'section';
	setSection.value = sectionId;

	form.appendChild(setEvent);
	form.appendChild(setArea);
	form.appendChild(setSection);

}

function medio()
{
	var sectionId = 0;
	switch(this.area) {
		case 1: sectionId = 2; break;
		case 2: sectionId = 5; break;
		case 3: sectionId = 8; break;
		case 4: sectionId = 10; break;
		case 5: sectionId = 13; break;
		case 6: sectionId = 16; break;
		case 7: sectionId = 19; break;
		case 8: sectionId = 21; break;
	}

	// stablish where the form go
	var form = document.getElementById('middleForm');
	form.method = "get";
  form.action = "sales/create";

	var setEvent = document.createElement('input');
	setEvent.type = 'hidden';
	setEvent.name = 'event';
	setEvent.value = this.eventId;

	var setArea = document.createElement('input');
	setArea.type = 'hidden';
	setArea.name = 'area';
	setArea.value = this.area;


	var setSection = document.createElement('input');
	setSection.type = 'hidden';
	setSection.name = 'section';
	setSection.value = sectionId;

	form.appendChild(setEvent);
	form.appendChild(setArea);
	form.appendChild(setSection);
}

function abajo()
{
	var sectionId = 0;
	switch(this.area) {
		case 1: sectionId = 3; break;
		case 2: sectionId = 6; break;
		case 3: sectionId = 9; break;
		case 4: sectionId = 11; break;
		case 5: sectionId = 14; break;
		case 6: sectionId = 17; break;
		case 7: sectionId = 20; break;
		case 8: sectionId = 22; break;
	}

	// stablish where the form go
	var form = document.getElementById('bottomForm');
	form.method = "get";
  form.action = "sales/create";

	var setEvent = document.createElement('input');
	setEvent.type = 'hidden';
	setEvent.name = 'event';
	setEvent.value = this.eventId;

	var setArea = document.createElement('input');
	setArea.type = 'hidden';
	setArea.name = 'area';
	setArea.value = this.area;


	var setSection = document.createElement('input');
	setSection.type = 'hidden';
	setSection.name = 'section';
	setSection.value = sectionId;

	form.appendChild(setEvent);
	form.appendChild(setArea);
	form.appendChild(setSection);
}
