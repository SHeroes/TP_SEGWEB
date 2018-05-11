
$(document).ready(function(){
	$('select#id_tipo_reclamo').change(function() {
	  	//var elem = this;
	  	$( "select#id_tipo_reclamo option:selected" ).each(function() {
	      //str += $( this ).text() + " ";
	      //console.log(this);
	      var el = $(this).attr('id-responsable');
	      console.log(el);
	    });
	});

});