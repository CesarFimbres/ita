// Función para seleccionar el tipo lista disponible
function listViewer(type) {
	// Obtener todas las listas disponibles
	var listasProductos = document.getElementById('listas');

	// Obtener lista visible con class= "noCollapse" dentro del contenedor
	var lista = listasProductos.getElementsByClassName('noCollapse');

	// Ciclo dentro de los contenedores class="collpase"
	for (var i = 0; i < lista.length; i++) {
		var current = listasProductos.getElementsByClassName('noCollapse');
		current[0].className = current[0].className.replace(
			'noCollapse',
			'collapse',
		);
	}
	document.getElementById(type).className = 'noCollapse mt-5';
}
