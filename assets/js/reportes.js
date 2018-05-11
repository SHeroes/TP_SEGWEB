

$(document).ready(function(){

	$(".table thead.thead-inverse").on( "click", function() {
		var encabezado = $(this);
		encabezado.parents(".table").children("tbody").fadeToggle(300);
	});

});