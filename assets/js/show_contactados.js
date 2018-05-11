function verficacion(valor_verificacion, id_reclamo ){
 
  var dataToInsert = {
    id_reclamo_asociado: id_reclamo,
    correctitud: valor_verificacion
  };

  $.ajax({
   type: "post",
   url: "/index.php/main_supervisor/verificacion_reclamo",
   cache: false,    
   data: dataToInsert,
   success: alert('Se ha establecido la verificacion en el reclamo'),
   error: function(){      
    alert('Error while request..');
   }
  }); 

}

function editar_observacion(){
	
  var id_reclamo = $("#id-rec").val();
  var obs_str = $("#observacion-input").val();
  if (obs_str == ''){
    alert("Los comentarios en blanco no se agregaran al historial");
  } else{
    var dataToSearch = {
      id_reclamo: id_reclamo,
      observacion_input: obs_str
    };
    $.ajax({
     type: "post",
     url: "/index.php/main_supervisor/correctitud",
     cache: false,    
     data: dataToSearch,
     success: comentario_editado,
     error: function(){      
      alert('Error while request..');
     }
    }); 
  }
}


function comentario_editado(response){
  $("#obs-data").dialog('close');
}

$(document).ready(function(){

  $(".observacion .btn-info.observar").click(function() {
    var id_reclamo = $(this).parents("tr").children("th").attr("id_reclamo");

    $("#obs-data").dialog();
    $("#observacion-input").val('');
    $("input#id-rec").attr("value",id_reclamo);
    $(".ui-dialog").width(500);
    $("#obs-data").show();
  });

  $(".verficacion.correcta").click(function() {
  	el = $(this);
  	id_rec_asociado = el.parents("tr").children("th").attr("id_reclamo");
		//console.log(id_rec_asociado);
		verficacion(true,id_rec_asociado);
  });

	$(".verficacion.incorrecta").click(function() {
  	el = $(this);
  	id_rec_asociado = el.parents("tr").children("th").attr("id_reclamo");
  	//console.log(id_rec_asociado);
		verficacion(false,id_rec_asociado);
  });

});