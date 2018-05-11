
function change_password(){
  $("#ch_pass").dialog();
}

$(document).ready(function(){

/*
  $("#state .btn").click(function() {
    
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
*/

/*
TODO si la clave del usuario actual es clave1234 entonces sugerir cambio de clave
*/
//  alert("La clave actual es: clave1234 , cambiela");

  var actual_pass_sha1 = $("#head_user_info").attr("pass-sha1");
  if (actual_pass_sha1 == '49b74c397ca892ae17b32f62b2e22af4070bdcd3' ){
    alert("Debe cambiar su Contraseña");
    change_password();
  }

  $("#ch_pass .btn").click( function (){
    var id_user = $("#head_user_info").attr("id-user");
    var new_pass = $("#new_pass").val();
    
    var passInfo = {
      id: id_user,
      pass: new_pass
    };
    $.ajax({
     type: "post",
     url: "/index.php/main_admin/update_pass",
     cache: false,    
     data: passInfo,
     success: changed_pass_ok,
     error: function(){      
      alert('Error while request..');
     }
    }); 
  });

  function changed_pass_ok(response){
    //console.log(response);
    $("#ch_pass").dialog('close');
    alert("Contraseña cambiada correctamente");
    alert("Reinicie la sesión con su nueva contraseña");
    window.location.replace("/index.php/login/logout_user");
    //http://cav.gob/index.php/login/logout_user
  }

});

