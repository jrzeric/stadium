//variable
var popupVisible = false;

//handle on resize event
window.onresize = function() 
{	
	popupVisible = true;
	if(popupVisible) { resizePopup(); }
}

//resize popup window
function resizePopup()
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
function closePopup()
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