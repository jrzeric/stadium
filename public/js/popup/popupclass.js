//popup class
function PopupWindow(title, width, height)
{

	//All about the popup
	PopupWindow.prototype.popupVisible = false;
	PopupWindow.prototype.title = '';
	PopupWindow.prototype.width = '';
	PopupWindow.prototype.height = '';

	//All buttons
	PopupWindow.prototype.textCancel = '';
	PopupWindow.prototype.textOk = '';
	PopupWindow.prototype.functionCancel = '';
	PopupWindow.prototype.functionOk = '';
	PopupWindow.prototype.textCustom = '';
	PopupWindow.prototype.functionCustom = '';

	if (typeof title !== 'undefined' && width !== 'undefined' && height !== 'undefined')
	{
		this.title = title;
		this.width = width;
		this.height = height;
	}

	//resize popup window
	PopupWindow.prototype.resizePopup = function()
	{
		getMeasurements();//getMeasurements
		//resize glass
		document.getElementById('glass').style.height = documentHeight + 'px';
		//position popup
		var popup = document.getElementById('popup');
		var popupWidth = popup.offsetWidth; console.log(popupWidth);
		var popupHeight = popup.offsetHeight; console.log(popupHeight);
		popup.style.left = ((clientWidth - popupWidth) / 2) + 'px';
		popup.style.top = ((clientHeight - popupHeight) / 4) + 'px';
	}

	//close popup
	PopupWindow.prototype.closePopup = function()
	{
		//get glass and popup
		var glass = document.getElementById('glass');
		var popup = document.getElementById('popup');
		//get parents
		var glassParent = glass.parentElement;
		var popupParent = popup.parentElement;
		//the parents will KILL their ungrateful children
		glassParent.removeChild(glass);
		popupParent.removeChild(popup);

		popupVisible = false;
	}

	PopupWindow.prototype.show = function()
	{
		//create glass
		var glass = document.createElement('div');
		glass.id = 'glass';
		document.getElementsByTagName('body')[0].appendChild(glass);

		//create popup
		var popup = document.createElement('div');
		popup.id = 'popup';

		//width and height
		popup.style.width = this.width + 'px';
		popup.style.height = this.height + 'px';
		document.getElementsByTagName('body')[0].appendChild(popup);

		//create title
		var popuptitle = document.createElement('div');
		popuptitle.id = 'popuptitle';
		var titleText = document.createElement('h1');
		titleText.innerHTML = this.title;
		popuptitle.appendChild(titleText);//add header to title div
		popup.appendChild(popuptitle);//add title to popup

		//create close button
		var popupClose = document.createElement('div');
		popupClose.id = 'popupclose';
		popupClose.innerHTML = "<img src='images/close.png' width='30px'>";
		popupClose.setAttribute('onclick', 'closePopup()');
		popup.appendChild(popupClose);

		//create content
		var popupContent = document.createElement('div');
		popupContent.id = 'popupcontent';
		popup.appendChild(popupContent);

		//create buttons
		var popupButtons = document.createElement('div');
		popupButtons.id = 'popupbuttons';

		// add a hidden form
		var form = document.createElement('form');
		form.id = "topForm";

		if (this.functionCancel != '')
		{
			var buttonNegative = document.createElement('button');
			if (this.textCancel == '') { buttonNegative.innerHTML = 'Negative';	}
			else buttonNegative.innerHTML = this.textCancel;

			buttonNegative.className = 'popupbuttonnegative';
			buttonNegative.setAttribute('onclick', this.functionCancel);
			form.appendChild(buttonNegative);
			popupButtons.appendChild(form);
		}

		var form = document.createElement('form');
		form.id = "middleForm";

		if (this.functionOk != '')
		{
			var buttonPositive = document.createElement('button');

			if (this.textOk == '')  buttonPositive.innerHTML = 'Positive';
			else buttonPositive.innerHTML = this.textOk;

			buttonPositive.setAttribute('onclick', this.functionOk);
			buttonPositive.className = 'popupbuttonpositive';
			form.appendChild(buttonPositive);
			popupButtons.appendChild(form);
		}

		var form = document.createElement('form');
		form.id = "bottomForm";

		if(this.functionCustom != '')
		{
			var buttonNeutral = document.createElement('button');
			if (this.textCustom == '') { buttonNeutral.innerHTML = 'Neutral'; }
			else buttonNeutral.innerHTML = buttonNeutral.innerHTML = this.textCustom;

			buttonNeutral.setAttribute('onclick', this.functionCustom);
			buttonNeutral.className = 'popupbuttonneutral';
			form.appendChild(buttonNeutral);
			popupButtons.appendChild(form);
		}

		popup.appendChild(popupButtons);


	//resize popup
	resizePopup();
	}

	PopupWindow.prototype.addCustomButton = function(text, funcion)
	{
		this.textCustom = text;
		this.functionCustom = funcion;
		//console.log(this.textCancel + ', ' + this.functionCancel);
	}

	PopupWindow.prototype.addNegativeButton = function(text, funcion)
	{
		this.textCancel = text;
		this.functionCancel = funcion;
		//console.log(this.textCancel + ', ' + this.functionCancel);
	}

	PopupWindow.prototype.addPositiveButton = function(text, funcion)
	{
		this.textOk = text;
		this.functionOk = funcion;
		//console.log(this.textOk + ', ' + this.functionOk);
	}



}

//handle on resize event
window.onresize = function()
{
	popupVisible = true;
	if(popupVisible) { resizePopup(); }
}
