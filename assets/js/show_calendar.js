
$( document ).ready(function() {
    $(".nav.navbar-nav li").removeClass('active');
	$('li.calendario').addClass('active');

	  $( function() {
    $( "#datepicker" ).datepicker({
      dateFormat: "yy-mm-dd",
      dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
      monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Augosto", "Setiembre", "Octubre", "Noviebre", "Diciembre" ],
      dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ]
    });
    $( "#datepicker2" ).datepicker({
      dateFormat: "yy-mm-dd",
      dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
      monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Augosto", "Setiembre", "Octubre", "Noviebre", "Diciembre" ],
      dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ]
    });
  } );

});