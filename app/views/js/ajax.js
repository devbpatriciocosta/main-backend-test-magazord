const formularios_ajax=document.querySelectorAll(".FormularioAjax");

formularios_ajax.forEach(formularios => {

    formularios.addEventListener("submit",function(e){
        
        e.preventDefault();

        Swal.fire({
            title: 'Tem certeza?',
            text: "Você quer mesmo fazer?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, fazer',
            cancelButtonText: 'Não, cancelar'
        }).then((result) => {
            if (result.isConfirmed){

                let data = new FormData(this);
                let method=this.getAttribute("method");
                let action=this.getAttribute("action");

                let encabezados= new Headers();

                let config={
                    method: method,
                    headers: encabezados,
                    mode: 'cors',
                    cache: 'no-cache',
                    body: data
                };

                fetch(action,config)
                .then(respuesta => respuesta.json())
                .then(respuesta =>{ 
                    return alertas_ajax(respuesta);
                });
            }
        });

    });

});

function alertas_ajax(alerta){
    if(alerta.tipo=="simple"){

        Swal.fire({
            icon: alerta.icon,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: 'Aceitar'
        });

    } else if (alerta.tipo=="recargar"){

        Swal.fire({
            icon: alerta.icon,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: 'Aceitar'
        }).then((result) => {
            if(result.isConfirmed){
                location.reload();
            }
        });

    } else if (alerta.tipo=="limpiar"){

        Swal.fire({
            icon: alerta.icon,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: 'Aceitar'
        }).then((result) => {
            if(result.isConfirmed){
                document.querySelector(".FormularioAjax").reset();
            }
        });

    }else if(alerta.tipo=="redireccionar"){
        window.location.href=alerta.url;
    }
}

let btn_exit=document.getElementById("btn_exit");

btn_exit.addEventListener("click", function(e){

    e.preventDefault();
    
    Swal.fire({
        title: 'Você quer mesmo sair do sistema?',
        text: "A sessão será encerrada!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, sair',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            let url=this.getAttribute("href");
            window.location.href=url;
        }
    });
});