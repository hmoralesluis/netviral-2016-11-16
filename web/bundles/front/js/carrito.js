window.onload=function(){
    $("#lista").innerHTML="Carrito Vacio";
    $("cargando").style.visibility="hidden";
}

var cacheProductos=[];
var canasto=[];

function prueba(){

    $("#lista").html("You clicked me!");
   // window.location.href = '#wps-right';
}

function agregar(id,precio,nombre){
    var i=0;
    var encontrado=false;
    var d;

    while((i<canasto.length)&&(!encontrado))
    {
        if(canasto[i].id==id)
        {
            encontrado=true;
        }
        else
        {
            i++;
        }
    }
    if(encontrado){
        canasto[i].cantidad++;
    }
    else{
        var producto=cacheProductos[id];
        nuevoProducto={
            'id':id,
            'nombre':nombre,
            'precio':precio,
            'cantidad':1
        };
        canasto[canasto.length]=nuevoProducto;
    }
    actualizarCanasto();
}

function actualizarCanasto(){
    var contenido="";

    if(canasto.length==0){

        contenido='';
    }
    else{
        var filaCanasto=0;
        var total=0;
        for(var i=0;i<canasto.length;i++){

            //creo una fila por cada producto
            filaCanasto="<div class='filaCanasto'";
            filaCanasto+="id='canasto_"+canasto[i].id+"'>";

            //se arma cada fila con una tabla
            var tablaCanasto;
            tablaCanasto="<table width='100%'><tr>";
            tablaCanasto+="<td class='canastoNombre'>"+canasto[i].nombre+"</td>";
            tablaCanasto+="<td class='canastoCantidad'>"+canasto[i].cantidad+" <img src='images/abajo.jpg' onclick='bajar("+canasto[i].id+")'/><img src='images/arriba.jpg' onclick='subir("+canasto[i].id+")'/></td>";
            tablaCanasto+="<td class='canastoPrecio'>$"+canasto[i].cantidad*canasto[i].precio+"</td>";
            tablaCanasto+="<td><a href='javascript:quitar("+canasto[i].id+")' class='canastoQuitar'>Quitar</a></td>";
            tablaCanasto+="</tr></table>";
            filaCanasto+=tablaCanasto+"</div>";
            contenido+=filaCanasto;
            total+=canasto[i].cantidad*canasto[i].precio;


        }

        //se muestra el total
        contenido+=generarFilaTotal(total);

        //boton finalizar
        contenido+="<input type='button' id='btnFinalizar' value='Finalizar Pedido' onClick='finalizar()'/>";
    }


    $("#lista").html(contenido);
    //$("lista").innerHTML=contenido;
}

function generarFilaTotal(total){

    var filaCanasto="<div class='totalCanasto'>"
    var tablaCanasto;
    tablaCanasto="<table width='100%'><tr>";
    tablaCanasto+="<td class='canastoNombre'>TOTAL</td>";
    tablaCanasto+="<td class='canastoCantidad'></td>";
    tablaCanasto+="<td class='canastoPrecio'>$"+total+"</td>";
    tablaCanasto+="<td><a href='javascript:vaciar()' class='canastoQuitar'>Vaciar</a></td>";
    tablaCanasto+="</tr></table>";
//alert(tablaCanasto);
    filaCanasto+=tablaCanasto+"</div>";

    return filaCanasto;
}

//quita un producto del canasto
function quitar(id){
//alert('bien');
    var i=0;
    var encontrado=false;
    while((i<canasto.length)&&(!encontrado)){
//alert(i);
        if(canasto[i].id==id){
//alert('encontrado');
            encontrado=true;
//lo eliminamos de la lista con prototype
            canasto=canasto.without(canasto[i]);
        }
        else{
            i++;
        }
    }
    actualizarCanasto();
}

//aumenta la cantidad de un producto seleccionado
function subir(id){
    var i=0;
    var encontrado=false;
    while((i<canasto.length)&&(!encontrado)){
        if(canasto[i].id==id){
            encontrado=true;
//aumentamos la cantidad
            canasto[i].cantidad++;
        }
        else{
            i++
        }
    }
    actualizarCanasto();
}

//disminuye la cantidad de un producto seleccionado
function bajar(id){
    var i=0;
    var encontrado=false;
    while((i<canasto.length)&&(!encontrado)){
        if(canasto[i].id==id){
            encontrado=true;
//aumentamos la cantidad
            canasto[i].cantidad--;

//si cantidad==0 eliminamos el producto de la lista
            if(canasto[i].cantidad==0){
                quitar(id);
            }
        }
        else{
            i++
        }
    }
    actualizarCanasto();
}

//borra todos los productos que hay en el carrito
function vaciar(){
    canasto=[];
    actualizarCanasto();
}

//se ejecuta cuando se suelta un producto en el canasto
function sueltaProducto(drag,drop,event){
    var array=drag.id.toString().split(",");
    agregar(array[0],array[1],array[2]);
}

//quita el producto al arrastrarlo al bote de basura
function tiraProducto(drag,drop,evento){
    var id=drag.id.substring(8,drag.id.lenght);
//alert(id);
    quitar(id);
}

//formulario de finalizar pedido
function finalizar(){
//alert('q');
    if(canasto.length==0){
        alert('Su pedido no contiene elementos por procesar');
    }
    else{
//var contiene="Descripción--Cantidad--Precio</br>";
//for(var i=0;i<canasto.length;i++){
//contiene+=canasto[i].nombre+"--"+canasto[i].cantidad+"--"+canasto[i].precio+"<br/>";
//}
        $("ventanaModal").style.visibility="visible";
//$("listadoprod").innerHTML=contiene;
    }
}

function cancelar(){
    $("ventanaModal").style.visibility="hidden";
}

function enviar(){
    $("ventanaModal").style.visibility="hidden";
//$("txtNombre").focus;
    $("cargando").style.visibility="visible";


    alert("Y AQUI REALIZARIA LA COMPRA...");
    $("cargando").style.visibility="hidden";
//alert(parametros);
    vaciar();
}
