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
                return 0;
            }
            switch (data.status)
            {
                case "reload":
                    location.reload();
                    break;
                case "aborted":
                        showMesssage('info',data.html)
                    break;
            }

        },
        error:function(x,xs,xt){
            showMesssage('danger',"El servidor no ha sido contactado")
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






// Indicamos el estilo de las notificaciones y la localizamos  la notificacion
PNotify.defaults.styling = 'bootstrap4';
window.stackBottomRight = {
    'dir1': 'up',
    'dir2': 'left',
    'firstpos1': 25,
    'firstpos2': 25
};

function showMesssage(type,msj){
    switch (type) {
        case 'info':
            PNotify.info({
                title:'Informacion',
                icon:'icon icon-info',
                text: msj,
                delay:1500,
                addClass: 'translucent',
                stack:window.stackBottomRight
            });
            break;
        case 'success':
            PNotify.success({
                title:'Completado . . .',
                text: msj,
                delay:1500,
                icon: 'icon icon-check',
                addClass: 'translucent',
                stack:window.stackBottomRight
            });
            break;
        case 'danger':
            PNotify.error({
                title:'Error . . .',
                text: msj,
                delay:1500,
                icon:'icon icon-fire',
                addClass: 'translucent',
                stack:window.stackBottomRight
            });
            break;
        case 'notice':
            PNotify.notice({
                title:'',
                text: msj,
                icon:'icon icon-info',
                delay:1500,
                addClass: 'translucent',
                stack:window.stackBottomRight
            });
            break;
    }
}

