function grabaTodoTabla(TABLAID)
{
    //tenemos 2 variables, la primera será el Array principal donde estarán nuestros datos y la segunda es el objeto tabla
    var DATA 	= [];
    var TABLA 	= $("#"+TABLAID+" tbody > tr");

    //entonces declaramos un array para guardar estos datos, lo declaramos dentro del each para así reemplazarlo y cada vez
    item = {};
    //si miramos el HTML vamos a ver un par de TR vacios y otros con el titulo de la tabla, por lo que le decimos a la función que solo se ejecute y guarde estos datos cuando exista la variable ID, si no la tiene entonces que no anexe esos datos.

    item ["nombre"] 	= ID;
    item ["precio"] 	= DESC;
    item ['cantidad'] 	= CLAS;
    //una vez agregados los datos al array "item" declarado anteriormente hacemos un .push() para agregarlos a nuestro array principal "DATA".
    DATA.push(item);

    console.log(DATA);

    //eventualmente se lo vamos a enviar por PHP por ajax de una forma bastante simple y además convertiremos el array en json para evitar cualquier incidente con compativilidades.
    INFO 	= new FormData();
    aInfo 	= JSON.stringify(DATA);

    INFO.append('data', aInfo);

    $.ajax({
        data: INFO,
        type: 'POST',
        url: './funciones_upload.php',
        processData: false,
        contentType: false,
        success: function (r) {
            //Una vez que se haya ejecutado de forma exitosa hacer el código para que muestre esto mismo.
        }
    });
}



