var modoNocturno = false;
function logout(){
	window.location = '../index.html';
}
function confirmar() {
	alert('Confirmar Venta?');
}

function modoN()
{
	if(!modoNocturno)
	{	
		modoNocturno = true;
		document.getElementById('us').style.backgroundColor = '#BB0000';
		document.getElementById('sidemenu').style.backgroundColor = '#BB0000';
	}
	else
	{	
		modoNocturno = false;
		document.getElementById('us').style.backgroundColor = '#424242';
		document.getElementById('sidemenu').style.backgroundColor = '#424242'
	}
}
