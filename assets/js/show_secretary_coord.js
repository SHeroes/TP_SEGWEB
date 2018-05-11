
$(document).ready(function(){

  function detalle_vecino(response, str_horarios){
    var htmlString = '<div class="">';
    $( "#vecino-data" ).html('');
 
    data = JSON.parse( response );

    $( "#vecino-data" ).dialog();

    $.each( data, function( key, value ) {
      if ( key == 'id_vecino'){
        $( "#ui-id-1" ).attr(key,value);
      } else if ( key == 'tel_fijo'){
        htmlString = htmlString + "<div><p>Tel. Fijo: " + value + "</p></div>";
      }
      else if ( key == 'tel_movil'){
        htmlString = htmlString + "<div><p>Tel. Movil: " + value + "</p></div>";
      }
      else {
        htmlString = htmlString + "<div><p>" + key + ": " + value + "</p></div>";        
      }
    });
    htmlString = htmlString + "<div><p> Horarios para Comunicarse : " + str_horarios + "</p></div>";   
    htmlString = htmlString + '</div>';
    $( "#vecino-data" ).html(htmlString);
  }

  $(".comentario .btn-info").click(function() {
    var comment = $(this).parents("td").attr("comentario");
    $("#comments-data").dialog();
    $("#comments-data").html(comment);
    $("#comments-data").show();
    $(this).parents(".reclamo_row").addClass("greySelected");
  });


  $(".observacion .btn-success.ver").click(function() {
      $(this).parents(".reclamo_row").addClass("greySelected");
      var id_reclamo = $(this).parents("tr").children("th").attr("id_reclamo");
      var dataToSearch = {
        id_reclamo: id_reclamo
      };
      $.ajax({
       type: "post",
       url: "/index.php/main_office/ver_observaciones",
       cache: false,    
       data: dataToSearch,
       success: mostrar_observaciones,
       error: function(){      
        alert('Error while request..');
       }
      });  
  });

  function mostrar_observaciones(response){
    var data = JSON.parse(response);
    var inicio = '';  var titulo = ''; var cuerpo = ''; var fin = ''; var fecha = ''; var autor = ''; 
    $("#ver-obs").dialog();
       var htmlString = '<div class="">';
       $.each( data, function( key1, elem ) {
          inicio = '<div class="observacion-item"><div class=obs-title>Observacion</div>';
          cuerpo = '<p>'+ elem.body +'</p>';
          autor = '<p>' + elem.apellido +', '+ elem.nombre + '  --  '; 
          fecha =  elem.createdDate +'</p>';
          fin = '</div></br>';
          htmlString = htmlString + inicio + cuerpo + autor + fecha + fin ;
        });
    htmlString = htmlString + '</div>';

    $(".ui-dialog").width(500);
    $( "#ver-obs" ).html(htmlString);          
  }

  $(".info-vecino").click(function() {
    $(this).parents(".reclamo_row").addClass("greySelected");
      el = $(this)
      if ( el.attr("dom-res") == 0 ) {
        var id_vecino = el.parents("tr.reclamo_row").children("th").attr("value");
        var str_horarios = el.parents("tr.reclamo_row").children("th").attr("horario");
        console.log(str_horarios);
        mostrar_datos_vecino(id_vecino,str_horarios);
      } else {
        alert( "La Información del Vecino se encuentra Restringida");
      }
  });

  function mostrar_datos_vecino(id_vecino,str_horarios){
    var dataToSearch = {
      id_vecino: id_vecino
    };
    $.ajax({
     type: "post",
     url: "/index.php/main_common/get_vecino_info",
     cache: false,    
     data: dataToSearch,
     success: function(response){  
      detalle_vecino(response,str_horarios)   
     },
     error: function(){      
      alert('Error while request..');
     }
    });

  }

});