//variables
var clientWidth = 0; //Width of the browser window
var clientHeight = 0; //Height of the browser window
var documentHeight = 0; //height of the document <body> tag
var scrollFromTop = 0; //distance that the user scrolled from the top
var scrollFromLeft = 0; //distance that the user scrolled from the left

//get measurements
function getMeasurements()
{
	clientWidth = window.innerWidth; console.log('clientWidth: ' + clientWidth);
	clientHeight = window.innerHeight; console.log('clientHeight: ' + clientHeight);
	documentHeight = document.documentElement.offsetHeight; console.log('documentHeight: ' + documentHeight);
	scrollFromTop = window.pageYOffset; console.log('scrollFromTop: ' + scrollFromTop);
	scrollFromLeft = window.pageXOffset; console.log('scrollFromLeft: ' + scrollFromLeft);
}
