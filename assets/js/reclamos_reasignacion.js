
function reasignacion_reclamo(){
	//var id_reclamo = $(this).parents("tr").children("th").attr("id_reclamo");	

	var id_new_tipo_reclamo = $("#reclamoType_box_dialog option:selected").val();
	var id_reclamo = $("#id-rec-reasig").val();



	var dataToSearch = {
	  id_reclamo: id_reclamo,
	  id_new_tipo_reclamo: id_new_tipo_reclamo
	};
	$.ajax({
		type: "post",
		url: "/index.php/main_supervisor/reasignacion_reclamo",
		cache: false,    
		data: dataToSearch,
		success: reclamos_reasignado,
		error: function(){      
		alert('Error while request..');
		}
	});
}

function reclamos_reasignado(){
	alert("Reclamo REASIGNADO correctamente, actualice la pagina para ver los cambios");
	$("#reasignacion-data").dialog('close');
}

$(document).ready(function(){

	$(".reasignar.btn").on( "click", function (){
		var id_reclamo = $(this).attr("id_reclamo");
		$("#id-rec-reasig").val(id_reclamo);
		var rec_code = $(this).parents(".reclamo_row").children("th").html();
		//console.log(id_reclamo);
		$("#reasignacion-data").dialog();
		var dialogBox = $("#reasignacion-data").parents(".ui-dialog");
		var posTop = dialogBox.position().top;
		dialogBox.offset({ top: posTop, left: 100 });
		dialogBox.width(800);
		$("#reasignacion-data .box_rec_title b").html(rec_code);
	});

});