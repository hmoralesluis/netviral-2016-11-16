//Funcion para mostrar un elemento
function mostrarFormulario(id)
{
  var inbox=document.getElementById('inboxform');
  var compose=document.getElementById('composeform');

  if (id == 'inboxform'){
    inbox.style.display="block";
    compose.style.display="none";
  }else{
    inbox.style.display="none";
    compose.style.display="block";
  }
}

function mostrarurl(url){
  alert('prueba');
  $("#boton").click(function(event) {
    $("#htmlext").load(url);
  });

}
