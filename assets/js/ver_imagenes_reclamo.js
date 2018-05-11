

$(document).ready(function(){

	$(".sh-img").on( "click", function() {
		var id_rec = $(this).attr('id_reclamo');
	    var dataToSearch = {
	      id_reclamo: id_rec
	    };


	    $.ajax({
	     type: "post",
	     url: "/index.php/main_common/search_imagenes_por_reclamo",
	     cache: false,    
	     data: dataToSearch,
	     success: poblar_imagenes,
	     error: function(){      
	      alert('Error while request..');
	     }
	    });
		
		//console.log();

		
		

	});
});


//  meter la info en el dialog 
function poblar_imagenes(response){

	//console.log(response);

	var resultDOM = $('#img-box p');
	resultDOM.html("");   
	var obj = JSON.parse(response);
	if(obj.length>0){
	try{
	var items=[];  
	$.each(obj, function(i,val){           
	    items.push('Foto '+ (i+1) + '</br><div class="result"><img src="/uploads/'+ val.file_name +'" item="'+(i+1)+'"/></div></br></br>');
	}); 
	resultDOM.append.apply(resultDOM, items);
	resultDOM.show();
	//clickeable(resultDOM);
	}catch(e) {  
	alert('Exception while request..');
	}  
	}else{
	resultDOM.html($('<div class="result fail" />').text("No hay calles con ese nombre"));   
	} 


	$('#img-box').dialog();

	$(".ui-dialog").width('auto');


	

};