var urlHtml = 'http://localhost:8080/SeatOrganizer/admin/';

function logout(){
	window.location = '../index.html';
}
function confirmar() {
	alert('Confirmar Venta?');
}
function nuevoEvento()
{
	console.log(urlHtml + 'nuevoEvento.html');
	document.getElementById('charger').src = urlHtml + 'nuevoEvento.html';
}
function evento()
{
	document.getElementById('charger').src = urlHtml + 'modificarEvento.html';
}
function realizarVenta()
{
	console.log(urlHtml + 'realizarVenta.html');
	document.getElementById('charger').src = urlHtml + 'realizarVenta.html';
}
function modificarVenta()
{
	document.getElementById('charger').src = urlHtml + 'modificarVenta.html';
}
function nuevoUsuario()
{
	console.log(urlHtml + 'agregarUsuario.html');
	document.getElementById('charger').src = urlHtml + 'agregarUsuario.html';
}
function modificarUsuario()
{
	document.getElementById('charger').src = urlHtml + 'modificarUsuario.html';
}
function alerta()
{	
	alert("Desea Recargar?");
}