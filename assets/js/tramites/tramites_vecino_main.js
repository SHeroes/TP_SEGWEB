
 $(document).ready(function(){
   

  if($(".vecinos_filtrados").length > 0){
    $(".vecinos_filtrados").click(function() {
        var row = $(this);
        var value = row.children("th").attr("id-value");
        var seleccion = $(row.children("td"));
        var Apellido = $(seleccion.get(0));
        var Nombre = $(seleccion.get(1));

        //alert("El vecino seleccionado es:  " + Apellido.html() + ", " + Nombre.html());
        $(".buscar_vecinos").hide();
        $(".id_vecino").each(function( index , item){
          elem = $(item);
          elem.attr("value",value);
        });

        $(".name_vecino").each(function( index , item){
          elem = $(item);
          elem.attr("value", Apellido.html() + ", " + Nombre.html());
        });


        console.log("id del vecino:"+value);
        /*
        $(".buscar_vecinos").hide();
        $(".vecino_chose_tramite").show();
        */
        stringUrl = '/index.php/tramites/Main_tr_vecino/show_main?id_vecino='+value+'&name_vecino='+Apellido.html() + ", " + Nombre.html();
        console.log(stringUrl);
        window.location.replace(stringUrl);
    }); 
  };
 
  var focusedElement = false;
  var flagCalleSeleccionada = false;

    $(".calle").bind("keydown", function(event) {
      flagCalleSeleccionada = false;
      var DOM = $(this).parents("p").next();    
        if(event.which == 9 && focusedElement) {
            event.preventDefault();
            //alert("TAB dETECTED");
            //que meta el vlaor del focus como click
            var val = focusedElement.attr("value");
            hiddenElement = $(elemento.next());
            hiddenElement.attr("value", val);

            elemento.val(focusedElement.html());
            DOM.hide();
            focusedElement = false;
            flagCalleSeleccionada = true;
            //console.log(DOM.next());  
        }
    });

   $(".calle").keyup(function(ev){
    elemento = $(this);
    var resultados = elemento.parents("p").next().children('.result');
    var keyCode = ev.keyCode || ev.which; 
    console.log(keyCode);
    if (keyCode == 40) {
      ev.preventDefault(); 
//      console.log("Avanzo uno");
          if(focusedElement){
    //        console.log(focusedElement);
            focusedElement.removeClass('hover');
            focusedElement = focusedElement.next();
            focusedElement.addClass('hover');
          }
          else{ 
      //      console.log(elemento);
            focusedElement = resultados.first();
            focusedElement.addClass('hover');
          }
      return false;
    } else if (keyCode == 38) {
      ev.preventDefault(); 
          if(focusedElement){
  //          console.log(focusedElement);
            focusedElement.removeClass('hover');
            focusedElement = focusedElement.prev();
            focusedElement.addClass('hover');
          }
          else{ 
            focusedElement = resultados.last();
            focusedElement.addClass('hover');
            //console.log(focusedElement);
          }
      return false;
    }

    else {
          if(elemento.val().length>3 && !flagCalleSeleccionada){
            focusedElement = false;
            var dataToSearch = {
                searchCalle: elemento.val()
              };
          $.ajax({
           type: "post",
           url: "/index.php/tramites/Main_tr_vecino/search_calle",
           cache: false,    
           data: dataToSearch,
           success: calle_encontrada,
           error: function(){      
            alert('Error while request..');
           }
          });
          }
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
      resultDOM.hide();
    });
  };



  function domicilio_vecino_encontrado(response){
    var obj = JSON.parse(response);
    $("#calle").val(obj.calle);
    $("#altura_inicio").val(obj.altura);
    $("#altura_fin").val(obj.altura_fin);
    $("#entrecalle1").val(obj.entrecalle1);
    $("#entrecalle2").val(obj.entrecalle2);
    $("#id_barrio").val(obj.id_barrio);
    $("#columna_electrica").val(obj.columna_luminaria);
  };

  $(".tipo_reclamo_row").click(function(){
      var elementoClickeado = $($(this));
      var val = elementoClickeado.attr("value");
      hiddenElement = $('#tipo_reclamo');
      hiddenElement.attr("value", val);
      $(".reclamo-form").show();
      //alert("Se seleccionó el tipo de reclamo: " + elementoClickeado.html());
      //$(".reclamo-form").show();

      //elementoClickeado.addClass('info');

      $('html,body').animate({scrollTop: $(".reclamo-form").offset().top});
      $("#tipo_reclamo_seleccionado").html(elementoClickeado.html());
  });

});
