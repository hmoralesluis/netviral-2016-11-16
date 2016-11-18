/**
 * Created by Administrador on 30/10/2016.
 */

function Muestramodulo(){
    var xmlhttp;
    var route = "{{ path('management_user_modulo') }}";

    window.location = Routing.generate('management_user_modulo');

    xmlhttp = new XMLHttpRequest();
    document.getElementById('cliente').innerHTML = xmlhttp.responseText;
    xmlhttp.open('GET',route);
}



