
$(".btnAgregarProducto").click(function(){
	
	// console.log("clicke");
	$(".nuevoProducto").append(
		'<div class="row" style="padding:5px 15px">' +
	 	'<div class="col-xs-2" style="padding-right: 0px;">' +
	                              
	    	'<div class="input-group">' +
	                              
	    		'<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto"><i class="fa fa-times"></i></button></span>'  +
	      		'<input type="number" name="nuevaCantidadProducto" class="form-control nuevaCantidadProducto" id="nuevaCantidadProducto" value="1" min="1" placeholder="0" required>'+
             
	     	'</div>' +
	     '</div>' +
	      '<div class="col-xs-1">' +
	      		'<input type="text" name="unidad" class="form-control unidad" id="unidad">' +
	      '</div>' +
	    '<div class="col-xs-3">' +
	                              
	    '<input type="text" name="agregarProducto" class="form-control agregarProducto" id="agregarProducto" placeholder="Descripción de producto" required>' +
	                
	    ' </div>' +
	    '<div class="col-xs-2">' +
	                              
	      '<input type="text" name="entrega" class="form-control entrega" id="entrega" >'+
	    ' </div>' +
	    '<div class="col-xs-2">' +
	                              
	      '<input type="text" name="nuevaPrecioU" class="form-control nuevaPrecioU" id="nuevaPrecioU" value="1" placeholder="0" required>'+
	    ' </div>' +
	    '<div class="col-xs-2" style="padding-left: 0px;">' +
	        '<div class="input-group">' +
	        	'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' +
	        	'<input type="text" name="nuevoPrecioProducto" class="form-control nuevoPrecioProducto" id="nuevoPrecioProducto" value="1" placeholder="000000" required readonly>' +
	      	'</div>' +
	                              
	     '</div>'+
	  
	  '</div>');
sumarTotalPrecios();
cantidadProductosProPrecio();
agregarImpuesto();
/*=============================================
=            AGREGAR PRODUCTOS JSON           =
=============================================*/
listarProductos();
$('#nuevoTotalCotizacion').number(true,2);
$('.nuevoPrecioProducto').number(true,2);
});
$(".formularioCotizacion").on("click","button.quitarProducto", function(){
	$(this).parent().parent().parent().parent().remove();
	if($(".nuevoProducto").children().length == 0){
		$("#nuevoTotalCotizacion").val(0);
		$("#totalCotizacion").val(0);
		$("#nuevoImpuestoCotizacion").val(0);
		$("#nuevoTotalCotizacion").attr("total",0)
	}else{
		sumarTotalPrecios();
		agregarImpuesto();
		/*=============================================
		=            AGREGAR PRODUCTOS JSON           =
		=============================================*/
		listarProductos();
	}
	
})
$(".formularioCotizacion").on("click","input.nuevoPrecioProducto", function(){
	cantidadProductosProPrecio();
	sumarTotalPrecios();
	agregarImpuesto();
})
// MODIFICAR LA CANTIDAD
$(".formularioCotizacion").on("change","input.nuevaCantidadProducto", function(){
	
cantidadProductosProPrecio();
sumarTotalPrecios();
agregarImpuesto();
/*=============================================
=            AGREGAR PRODUCTOS JSON           =
=============================================*/
listarProductos();
})
$(".formularioCotizacion").on("change","input.nuevaPrecioU", function(){
	
cantidadProductosProPrecio();
/*=============================================
=            AGREGAR PRODUCTOS JSON           =
=============================================*/
listarProductos();
})
function sumarTotalPrecios(){
	var precioItem = $(".nuevoPrecioProducto");
	var arraySumaPrecio = [];
	for(var i=0; i < precioItem.length;i++){
		
		arraySumaPrecio.push(Number($(precioItem[i]).val()));
	}
	//console.log("arraySumaPrecio", arraySumaPrecio);
	function sumaArrayPrecios(total, numero){
		
		return total + numero;
	}
	var sumaTotalPrecio = arraySumaPrecio.reduce(sumaArrayPrecios);
	// console.log("suma", sumaTotalPrecio);
	// 
	$("#nuevoTotalCotizacion").val(sumaTotalPrecio);
	$("#totalCotizacion").val(sumaTotalPrecio);
	$("#nuevoTotalCotizacion").attr("total",sumaTotalPrecio);
/*=============================================
=            AGREGAR PRODUCTOS JSON           =
=============================================*/
	
	listarProductos();
}
function cantidadProductosProPrecio(){
	if($(".nuevoProducto").children().length  == 0){
		$("#nuevoTotalCotizacion").val(0);
		$("#totalCotizacion").val(0);
		$("#nuevoImpuestoCotizacion").val(0);
		$("#nuevoTotalCotizacion").attr("total",0)
	}else{
			var preciUnitario = $(".nuevaPrecioU");
			var cantidad =  $(".nuevaCantidadProducto");
			var arrayPrecioUnitario = [];
			var arrayCantidad = [];
			for(var j=0;j<cantidad.length;j++){
				arrayCantidad.push(Number($(cantidad[j]).val()));
			}
			console.log("ArrayCantidad",arrayCantidad);
			for(var i=0;i < preciUnitario.length;i++){
					arrayPrecioUnitario.push(Number($(preciUnitario[i]).val()));
					
					
					var subtotal = $(".nuevoPrecioProducto");
					var multi=[];
					for(x=0;x<subtotal.length;x++){
							multi.push($(subtotal[x]).val(arrayCantidad[x] * arrayPrecioUnitario[x]));
						
					}
					console.log("Multi",multi);
			}
			console.log("ArrayPrecioUnitario",arrayPrecioUnitario);
		}
	
/*=============================================
=            AGREGAR PRODUCTOS JSON           =
=============================================*/
		listarProductos();
}
/*=============================================
=          LISTAR PRODUCTOS          =
=============================================*/
function  listarProductos(){
	if($(".nuevoProducto").children().length  == 0){
		$("#nuevoTotalCotizacion").val(0);
		$("#totalCotizacion").val(0);
		$("#nuevoImpuestoCotizacion").val(0);
		$("#nuevoTotalCotizacion").attr("total",0)
	}else{
		var listaProductos = [];
		
		var descripcion = $(".agregarProducto");
		var cantidad = $(".nuevaCantidadProducto");
		var precioUnitario = $(".nuevaPrecioU");
		var precio = $(".nuevoPrecioProducto");
		var entrega = $(".entrega");
		var unidad = $(".unidad");
		for(var i = 0; i < descripcion.length; i++){
			listaProductos.push({
									//"id" : $(descripcion[i]).attr(".agregarProducto"),
									"descripcion" : $(descripcion[i]).val(),
									"cantidad" : $(cantidad[i]).val(),
									"precio" : $(precioUnitario[i]).val(),
									"total" : $(precio[i]).val(),
									"entrega" : $(entrega[i]).val(),
									"unidad" : $(unidad[i]).val() 
								})
			}
			// console.log("ListarProductos", JSON.stringify(listaProductos));
			$("#listaProductos").val(JSON.stringify(listaProductos))
			
	  	}
}
/*=============================================
=            CAPTURAR IMPUESTO          =
=============================================*/
function agregarImpuesto(){
	
	var impuesto = $("#nuevoImpuestoCotizacion").val();
	var precioTotal = $("#nuevoTotalCotizacion").attr("total");
	var precioImpuesto = Number(precioTotal*impuesto/100).toFixed(2);
	var totalConImpuesto = Number(precioImpuesto) + Number(precioTotal);
	$("#nuevoTotalCotizacion").val(totalConImpuesto);
	$("#totalCotizacion").val(totalConImpuesto);
	$("#nuevoPrecioImpuesto").val(precioImpuesto);
	$("#nuevoPrecioNeto").val(precioTotal);
}
/*=============================================
=            cambie IMPUESTO          =
=============================================*/
$("#nuevoImpuestoCotizacion").change(function(){
	agregarImpuesto();
})
$("#nuevoTotalCotizacion").number(true,2);
$('.nuevoPrecioProducto').number(true,2);
// $(".nuevaPrecioU").number(true,2);
/*=============================================
=           BOTON EDITAR COTIZACION      =
=============================================*/
$(".tablasCotizaciones tbody").on("click",".btnEditarCotizacion", function(){
	var idCotizacion = $(this).attr("idCotizacion");
	// console.log(idCotizacion);
	window.location = "index.php?ruta=editar-cotizacion&idCotizacion="+idCotizacion;
	
})
/*=============================================
=            CREAR PDF          =
=============================================*/
$(".tablasCotizaciones tbody").on("click", ".btnImprimirFactura", function(){

	var codigoCotizacion = $(this).attr("codigoCotizacion");
	console.log("codigoCotizacion", codigoCotizacion);
	
	window.open("extensiones/tcpdf8/examples/cotizacion.php?codigo="+codigoCotizacion,"_blank");
})
/*=============================================
=            BORRAR COTIZACION                =
=============================================*/
// $(".btnEliminarCotizacion").click(function(){
$(".tablasCotizaciones  tbody").on('click','.btnEliminarCotizacion', function(){
	var idCotizacion = $(this).attr("idCotizacion");
	swal({
		title: '¿Esta seguro de borrar la cotización?',
		text: '¡Si no lo está puede cancelar la acción!',
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancel',
		confirmButtonText: 'Si, borrar cotización!'
	}).then((result)=>{
	
		if(result.value) {
			window.location= "index.php?ruta=cotizaciones&idCotizacion="+idCotizacion;
	
		}
	})
})
$(".btnTotalProducto").click(function(){
sumarTotalPrecios();
cantidadProductosProPrecio();
agregarImpuesto();
listarProductos();
})
init_contadorTa("taComentario","contadorTaComentario", 250);
function init_contadorTa(idtextarea, idcontador,max)
{
    $("#"+idtextarea).keyup(function()
            {
                updateContadorTa(idtextarea, idcontador,max);
            });
    
    $("#"+idtextarea).change(function()
    {
            updateContadorTa(idtextarea, idcontador,max);
    });
    
}
function updateContadorTa(idtextarea, idcontador,max)
{
    var contador = $("#"+idcontador);
    var ta =     $("#"+idtextarea);
    contador.html("0/"+max);
    
    contador.html(ta.val().length+"/"+max);
    if(parseInt(ta.val().length)>max)
    {
        ta.val(ta.val().substring(0,max-1));
        contador.html(max+"/"+max);
    }
}