/**
 * Funcion que consulta al server y pinta el resultado en el target
 * Params:  target-> div donde se inserta el resultado
 *          url   ->url donde se obtienen el html a pintar (Method="get")
 */
function loadTarget(url,target) {
    $.ajax({
        url:url,
        type:'get',
        success: function (data) {
            if(data.status=="success")
            {
                target.html(data.html);
            }else {
                alert("Error")
            }

        },
        statusCode: {
            404: function() {
                alert('Servidor no encontrado');
            }
        },
        error:function(x,xs,xt){
        }
    });
}


/**
 *
 * @param form
 * @param target
 */
function loadCardPostAjax(form,target) {
    var url =form.attr('action');
    var method=form.attr('method');
    var token =$('#token').val();

    $.ajax({
        url:url,
        headers:{'X-CSRF-TOKEN':token},
        data:form.serialize(),
        type:method,
        success: function (data) {
            if(data.status=="success")
            {
                location.reload();
             //   dtbl.DataTable().ajax.reload();
               // showMesssage('success','Transaccion completada');
            }
            if(data.status=="form_errors")
            {
                // showMesssage('notice','Se encontraron errrores en el formulario, porfavor corriga e intente nuevamente');
            }

            target.html(data.html);
        },
        statusCode: {
            404: function() {
                alert('Servidor no encontrado');
            }
        },
        error:function(x,xs,xt){
            //nos dara el error si es que hay alguno
            //
            //alert('error: ' + JSON.stringify(x) +"\n error string: "+ xs + "\n error throwed: " + xt);
        }
    });
}
