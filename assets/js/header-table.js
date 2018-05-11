 
 $(document).ready(function(){
	var arrayHeaderWidths = [];
	var headerCloneShowing = false;
	var heightToTop = $(".navbar").height() + $(".title-site").height() + $(".container h1").height() + 200;

	var el = $("#header-table").clone();
	el.addClass("clone");
	$("table.table .thead-inverse").append(el);
	$("#header-table.clone").hide();

	$( window ).scroll(function() {
		//console.log($(window).scrollTop())
		if (  $(window).scrollTop() < heightToTop ){ // cerca de top
			$("#header-table.clone").removeClass("fixed");
			
			$("#header-table.clone").hide();
			headerCloneShowing = false;

		}else {
			if(!headerCloneShowing){
				// se toma los width de la tabla despues q el headear este fixed y se los coloca
				headerSize();
				$("#header-table.clone").show();
				headerCloneShowing = true;
			}
		}
	});
});

function headerSize(){
	$("#header-table.clone").addClass("fixed");
	arrayHeaderWidths = [];
	arrayHeaderWidths.push($($(".reclamo_row th")[0]).width());

	$($(".reclamo_row")[0]).children("td").each(function( index, elem ) {
		arrayHeaderWidths.push($(this).width());
	});
	$("#header-table.clone th").each(function( index, elem ) {
	    $(this).width(arrayHeaderWidths[index]);
	});	
}

/*
 $(document).ready(function(){
	var arrayHeaderWidths = [];
	var heightToTop = $(".navbar").height() + $(".title-site").height() + $(".container h1").height() + 200;
	$( window ).scroll(function() {
		//console.log($(window).scrollTop())
		if (  $(window).scrollTop() < heightToTop ){ // lejos del top
			$("#header-table").removeClass("fixed");
		}else {
			if ($("#header-table").hasClass("fixed")){

			}
			else{
				// se toma los width de la tabla despues q el headear este fixed y se los coloca
				$("#header-table").addClass("fixed");
				arrayHeaderWidths = [];
				arrayHeaderWidths.push($($(".reclamo_row th")[0]).width());

				$($(".reclamo_row")[0]).children("td").each(function( index, elem ) {
					arrayHeaderWidths.push($(this).width());
				});
				$("#header-table th").each(function( index, elem ) {
				    $(this).width(arrayHeaderWidths[index]);
				});					

			}
		}
	});

});
*/