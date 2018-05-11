
var elemento;

 $(document).ready(function(){
    
   $(".calle").keyup(function(){
    elemento = $(this);
    if(elemento.val().length>3){
      var dataToSearch = {
          searchCalle: elemento.val()
        };
    $.ajax({
     type: "post",
     url: "/index.php/main_operator/search_calle",
     cache: false,    
     data: dataToSearch,
     success: calle_encontrada,
     error: function(){      
      alert('Error while request..');
     }
    });
    }
    return false;
  });

  function calle_encontrada(response){
      var resultDOM = elemento.parents("p").next();
      resultDOM.html("");   
      var obj = JSON.parse(response);
      if(obj.length>0){
       try{
        var items=[];  
        $.each(obj, function(i,val){           
            items.push('<div class="result" value="'+ val.id_calle +'" item="'+(i+1)+'">'+ val.calle + '</div>');
        }); 
        resultDOM.append.apply(resultDOM, items);
        resultDOM.show();
        clickeable(resultDOM);
       }catch(e) {  
        alert('Exception while request..');
       }  
      }else{
       resultDOM.html($('<div class="result fail" />').text("No hay calles con ese nombre"));   
      } 
  };

  function clickeable(resultDOM){
    $('div.result').click(function(){
      var elementoClickeado = $($(this));
      var val = elementoClickeado.attr("value");
      // USO EL elemento QUE ES GLOBAL, AL QUE LE DI EL CLICK
      hiddenElement = $(elemento.next());
      hiddenElement.attr("value", val);

      elemento.val(elementoClickeado.html());
      //alert(elemento.val());
      resultDOM.hide();
    });
  };

  var DOM_elem_Required = $("#id_domicilio").parents("div.domicilio-data").children("p").children(".required");
  $("#id_domicilio").change(function(){
    if($("#id_domicilio").val() != ""){
      DOM_elem_Required.each(function( index ) {
        $(this).prop('required',false);
      });
    } else{
      DOM_elem_Required.each(function( index ) {
        $(this).prop('required',true);
      });
    }
  });

 });
