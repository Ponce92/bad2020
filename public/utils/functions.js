/**
 * Funcion que consulta al server y pinta el resultado en el target
 * Params:  target-> div donde se inserta el resultado
 *          url   ->url donde se obtienen el html a pintar (Method="get")
 */
function htmLoadUrl(target,url) {
    console.log("==> Peticion enviada");
    $.ajax({
        url:url,
        type:'get',
        success: function (data) {
            console.log(data);
            switch (data.status) {
                case"success":
                    $(target).html(data.html);
                break;
            }
            $(target).html(data.html);
        },
        statusCode: {
            404: function() {
                console.log('Seridor no encontrado');
            }
        },
    });
}
