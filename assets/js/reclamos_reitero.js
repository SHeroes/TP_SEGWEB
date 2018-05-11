
function editar_comentario_por_reitero(){
	//var id_reclamo = $(this).parents("tr").children("th").attr("id_reclamo");	
	var reitero_num = $("#id-rei-num").val();
	var id_reclamo = $("#id-rei").val();
	var comment_str = $("#reitero-input").val();
	if (comment_str == ''){
		alert("Los comentarios en blanco no reemplazaran al comentario existente");
	} else{
		var dataToSearch = {
		  num_reitero: reitero_num,
		  id_reclamo: id_reclamo,
		  str_comentario: comment_str
		};
		$.ajax({
			type: "post",
			url: "/index.php/main_operator/update_reitero_reclamo",
			cache: false,    
			data: dataToSearch,
			success: comentario_editado,
			error: function(){      
			alert('Error while request..');
			}
		});
	}
}

function comentario_editado(){
	alert("Reclamo Reiterado correctamente, actualice la pagina para ver los cambios en el contador");
	$("#reitero-data").dialog('close');
}

$(document).ready(function(){

	$(".reitero-num").on( "click", function() {
		var comment = $(this).parents(".reclamo_row").children(".comentario").attr("comentario");
		$("#id-rei").val($(this).parents("tr").children("th").attr("id_reclamo"));
		$("#id-rei-num").val($(this).html());
		//PONER EL COMENTARIO QUE CORRESPONDE Y actualizarlo
		$("#reitero-data").dialog();
		$("#reitero-data textarea").html(comment);
	    $("#reitero-data").show();

	});
});