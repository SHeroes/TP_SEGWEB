
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

function actualizar_a_visto(id_reclamo, row_elem){

  state_str = 'Visto';
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
   success: console.log,
   error: function(){      
    alert('Error while request..');
   }
  });

  pasadoAVisto(row_elem);
}

function pasadoAVisto(row_elem){
  row_elem.children(".no-visto").each(function (index, elem){
    $(elem).removeClass("no-visto");
  });
}


$(document).ready(function(){

  $("#state .btn").click(function() {
    
    var state_str = $("#status_selector").val();

    if (state_str == ''){
      alert("No se realiza cambio de estado");
      return;
    }else {
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
    }  
  });

  $("td.state").click(function() {
    var id_reclamo = $(this).parents("tr").children("th").attr("id_reclamo");
    var str_state = $(this).children(".btn").html();
    //alert(str_state);
      $("option#estado-vacio").show();
      $("#status_selector option:eq(0)").prop('selected', true);
      $("#state").dialog();
      switch(str_state) {
        case 'Ver Info':
            $("#state").dialog('close');
            actualizar_a_visto(id_reclamo, $(this).parents("tr"));
            break;
        case 'Visto':
            $("option#solucionado").hide();
            $("option#gestionado").hide();
            $("option#resolucion").hide();
            $("option#contactado").show();
            $("#state").show();
            break;
        case 'Contactado':
            $("option#contactado").hide();
            $("option#solucionado").hide();
            $("option#gestionado").show();
            $("option#resolucion").show();
            $("#state").show();
            break;
        case 'En resolución':
            $("option#contactado").hide();
            $("option#resolucion").hide();
            $("option#solucionado").show();
            $("option#gestionado").show();
            $("#state").show();
            break;
        case 'En Reasignacion':
              $("#state").dialog('close');
             alert("El Supervisor del CAV se encargará de reasignar el reclamo al sector que corresponda");
        case 'Solucionado':
            break;
        case 'Gestionado':
            break;
        default:
            alert("Error en el estado del reclamo, el mismo no esta contemplado");
    }
    

   // $("#observacion-input").val(obs);
    $("#state").attr("id-rec",id_reclamo);
    $("#state").attr("str_state",str_state);

   // $(".ui-dialog").width(500);
  });


  function detalle_vecino(response, str_horarios){
    console.log(response);
    
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
    $(this).parents(".reclamo_row").addClass("greySelected");
    var comment = $(this).parents("td").attr("comentario");
    $("#comments-data").dialog();
    $("#comments-data").html(comment);
    $("#comments-data").show();
  });

  $(".observacion .btn-success.observar").click(function() {
    $(this).parents(".reclamo_row").addClass("greySelected");
    var id_reclamo = $(this).parents("tr").children("th").attr("id_reclamo");

    $("#obs-data").dialog();
    $("#observacion-input").val('');
    $("input#id-rec").attr("value",id_reclamo);
    $(".ui-dialog").width(500);
    $("#obs-data").show();
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
        mostrar_datos_vecino(id_vecino, str_horarios);

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