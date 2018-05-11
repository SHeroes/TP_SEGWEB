var currentTimer;
var lastRequest;
var currentSearchTerm;
var currentPage;
var currentValues = [];
var currentModels = [];
function refreshSearch(element){
	var toSearch = $(element).val();
	var haveToSearch = (toSearch && /\S/g.test(toSearch));
	var textToShow = (haveToSearch)? '<i class="fa fa-search"></i> Buscando '+ toSearch + '...': 'Escribi para comenzar la busqueda';
	var textToShowNotFound = 'No se encuentra la localidad';
	var results = $('.input-search-result');
	results.html('');
	while(currentValues.pop()){
		currentModels.pop();
	}
	results.show();
	results.append('<div class="no-clickeable">'+textToShow+'</div>');
	if(currentTimer){
		clearTimeout(currentTimer);
	}
	if(haveToSearch){
		currentSearchTerm = toSearch;
		currentPage = 0;
		var options = {
			type: 'POST',
			url: '/index.php/main_operator/search_calle',
			dataType: 'json',
			data: {'name': toSearch },
			success: function(data){
				$.each(data, function (i, val) {
					if(currentValues.indexOf(val.name) < 0){
						currentValues.push(val.name);
						currentModels.push(val);
						results.append('<div value="'+ val.id_calle +'" item="'+(i+1)+'">'+ val.calle + '</div>');
					}
				});
				$(".no-clickeable").hide();
				results.children().click(onItemClick);
				if (results.children().length == 1) {
					results.html(textToShowNotFound);
				}
			},
			error: function(){
				results.html('Error');
				refreshSearch(this);
			}
		};
		currentTimer = setTimeout(function() {
			if (lastRequest) {
				lastRequest.abort();
			}
			return lastRequest = $.ajax(options);
		}, 1500);
		
	}
}
function onItemClick(event){
	event.preventDefault();
	var idToSearch = parseInt($(this).attr('value'));
	var model;
	var index = 0;
		console.log(currentModels);		
	
	while(index < currentModels.length && !model){
		model = currentModels[index];	
		console.log(model);		
		if(model.id != idToSearch){
			model = undefined;
		} else {
			var current = getClimaCurrent();
			if($('#calle').val() != model.name){
				//current.html('<img src="/Css/Images/loader_molino2.gif" witdh="50" height="50">');
				$('#calle').val(model.name);
				$.ajax({
					type: 'POST',
					url: '/index.php/main_operator/search_calle',
					dataType: 'text',
					data: {'name': model.name, 'html': true },
					success: function(data){
						current.html(parseClimaData(data));
					},
					error: function(){
						current.html('Error al cargar la pagina. Por favor recarge e intente nuevamente.');
					}
				});
			}
		}
		index++;
	}
	
	$(".input-search-result").hide();
	
}

$(document).ready(function(){
	function getQueryParams(qs) {
		qs = qs.split('+').join(' ');
		
		var params = {},
			tokens,
			re = /[?&]?([^=]+)=([^&]*)/g;
		
		while (tokens = re.exec(qs)) {
			params[decodeURIComponent(tokens[1])] = decodeURIComponent(tokens[2]);
		}
		
		return params;
	}
	/*
	var query = getQueryParams(document.location.search);
	var localidad = query.loc;
	if (!localidad) {
		localidad = userData.perfilLocalidadClima;
		if(!localidad){
			localidad = "CAPITAL FEDERAL";
		}
	} else {
		localidad = localidad.toUpperCase();
	}
	*/
	
	//$('#localidad-clima.el-clima-localidad').keyup(refreshList);
	
	$('.calle').keyup(refreshList);
	//$('#calle').val(localidad);
	/*
	var current = getCalleCurrent();
	current.html('<img src="/Css/Images/loader_molino2.gif" witdh="50" height="50">');
	//$('#calle').val();
	$.ajax({
		type: 'POST',
		url: '/index.php/main_operator/search_calle',
		dataType: 'text',
		data: { searchCalle: elem.val() },
		success: function(data){
			current.html(getCalleCurrent());
			//current.html(parseClimaData(data));
		},
		error: function(){
			current.html('Error al cargar la pagina. Por favor recarge e intente nuevamente.');
		}
	});
	*/
});

function getCalleCurrent(){	
	return $('#calle');
}

function refreshList(e){
	var cantidadResultados = $(".input-search-result").children().length - 1;
	var itemActual;
	var itemSiguiente;
	switch(e.which) {
		case 13: //enter
			console.log("enter");
			e.preventDefault();
			$(".input-search-result .selected").click();
			break;
			
		case 38: // up
			console.log("UP");
			if (cantidadResultados > 0) {
				if ( $(".input-search-result .selected").html() == undefined ) { //firstpress
					$($(".input-search-result").children()[(cantidadResultados)]).addClass("selected");	
				} else{
					console.log("UPelse");
					itemActual = $(".input-search-result .selected").attr("item");	
					$($(".input-search-result").children()[itemActual]).removeClass("selected");								
					if(itemActual > 1){
						$($(".input-search-result").children()[--itemActual]).addClass("selected");
					} else {
						$($(".input-search-result").children()[(cantidadResultados)]).addClass("selected");								
					}
				}
			}
			break;
			
		case 40: // down
			console.log("DOWN");
			if (cantidadResultados > 0) {
				if ( $(".input-search-result .selected").html() == undefined ) { //firstpress
					$($(".input-search-result").children()[1]).addClass("selected");
				} else{
					console.log("DOWNelse");
					itemActual = $(".input-search-result .selected").attr("item");	
					$($(".input-search-result").children()[itemActual]).removeClass("selected");								
					if(cantidadResultados > itemActual){
						$($(".input-search-result").children()[++itemActual]).addClass("selected");
					} else {
						$($(".input-search-result").children()[1]).addClass("selected");								
					}
				}
			}
			break;
			
		default: 
			refreshSearch(this);
			break;	
			
		return; // exit this handler for other keys
	}
		
		e.preventDefault(); // prevent the default action (scroll / move caret)
	}