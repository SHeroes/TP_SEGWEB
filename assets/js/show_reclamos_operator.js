
function editar_observacion(){

  var id_reclamo = $("#id-rec").val();
  var obs_str = $("#observacion-input").val();
  if (obs_str == ''){
    alert("Los comentarios en blanco no reemplazaran al comentario existente");
  } else{
      //actualizo observaciones sin recargar la pagina
      $(".observacion").each(function (index, elem){
        var el = $(elem);
        if (el.attr("id_reclamo") == id_reclamo){
          el.attr("observacion", obs_str);
        }
      });

    var dataToSearch = {
      id_reclamo: id_reclamo,
      observacion_input: obs_str
    };
    $.ajax({
     type: "post",
     url: "/index.php/main_office/editar_observacion",
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

  $("#state .btn").click(function() {
    //var = $("#status_selector").html();
    
//<div class="btn btn-primary">En resolución</div>

    var state_str = $("#status_selector").val();
    var id_reclamo = $("#state").attr("id-rec");

    $(".state").each(function (index, elem){
      var el = $(elem);
      if (el.attr("id_reclamo") == id_reclamo){
        el.children("div").html(state_str);
      }
    });

    var dataToSearch = {
      id_reclamo: id_reclamo,
      state: state_str
    };
    $.ajax({
     type: "post",
     url: "/index.php/main_office/actualizar_estado",
     cache: false,    
     data: dataToSearch,
     success: $("#state").dialog('close'),
     error: function(){      
      alert('Error while request..');
     }
    });  
  });

  $("td.state").click(function() {
    var id_reclamo = $(this).parents("tr").children("th").attr("id_reclamo");
    var str_state = $("td.state .btn").html();

    $("option#estado-vacio").hide();
    switch($("td.state .btn").html()) {
      case 'Iniciado':
          $("#state").show();
          break;
      case 'Contactado':
          $("option#contactado").hide();
          $("#state").show();
          break;
      case 'En resolución':
          $("option#contactado").hide();
          $("option#resolucion").hide();
          $("#state").show();
          break;
      case 'Solucionado':
          break;
      case 'Gestionado':
          break;
      default:
          alert("otro");
    }
    $("#state").dialog();

   // $("#observacion-input").val(obs);
    $("#state").attr("id-rec",id_reclamo);
    $("#state").attr("str_state",str_state);

   // $(".ui-dialog").width(500);




  });


  function detalle_vecino(response){
    var htmlString = '<div class="">';
    $( "#vecino-data" ).html('');
 
    data = JSON.parse( response );

    $( "#vecino-data" ).dialog();

    $.each( data, function( key, value ) {
      //console.log( "<div>" + key + ": " + value + "</div>");
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
    
    htmlString = htmlString + '</div>';
    $( "#vecino-data" ).html(htmlString);
  }

  $(".comentario .btn-info").click(function() {
    var comment = $(this).parents("td").attr("comentario");
    $("#comments-data").dialog();
    $("#comments-data").html(comment);
    $("#comments-data").show();
    //alert(comment);
  });

  $(".observacion .btn-success.ver").click(function() {
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
    $("#ver-obs").dialog();//{ position: 'top' });
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
      el = $(this)
      if ( el.attr("dom-res") == 0 ) {
        var id_vecino = el.parents("tr.reclamo_row").children("th").attr("value");
        mostrar_datos_vecino(id_vecino);
      } else {
        alert( "La Información del Vecino se encuentra Restringida");
      }
  });

  function mostrar_datos_vecino(id_vecino){
    //console.log("aca: vecino:" + id_vecino);
    var dataToSearch = {
      id_vecino: id_vecino
    };
    $.ajax({
     type: "post",
     url: "/index.php/main_common/get_vecino_info",
     cache: false,    
     data: dataToSearch,
     success: detalle_vecino,
     error: function(){      
      alert('Error while request..');
     }
    });
  }

});