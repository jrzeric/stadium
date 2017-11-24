function mostrarButacas() 
{
	window.location = 'butacas.html';
}


function precio(val1, val2, val3)
{
	var pre1 = document.getElementById('precio1');
	var pre2 = document.getElementById('precio2');
	var pre3 = document.getElementById('precio3');

	pre1.innerHTML = val1;
	pre2.innerHTML = val2;
	pre3.innerHTML = val3;

}