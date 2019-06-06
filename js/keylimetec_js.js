/*
**
	ARRAY CON LOS DOS ID
**
*/
modificaJugador = {
	jugador: "",
	usuarios: ""
}
//ACTIVA DESACTIVA BOTON RELACIONAR
function activaDesactivaR(){
	if(jQuery(".botonSeleccionar[data-tipo='usuarios'].active").length > 0 && jQuery(".botonSeleccionar[data-tipo='jugador'].active").length > 0){
		jQuery(".botonRelacionar").removeAttr("disabled");
		jQuery(".botonRelacionar").addClass("btn-success");

		//ASIGNAMOS EL JUGADOR Y EL USUARIO AL OBJETO
		modificaJugador.jugador = jQuery(".botonSeleccionar[data-tipo='jugador'].active").attr("data-id");
		modificaJugador.usuarios = jQuery(".botonSeleccionar[data-tipo='usuarios'].active").attr("data-id");

		//alert("-----------> "+modificaJugador.usuarios);
	}else{
		jQuery(".botonRelacionar").attr("disabled", "disabled");
		jQuery(".botonRelacionar").removeClass("btn-success");

		modificaJugador.jugador = "";
		modificaJugador.usuarios = "";
	}
}
//REVISION EN EL CLICK
function accionClickBotonS(id, tipo){
	if(jQuery("."+tipo+" .botonSeleccionar.active[data-id='"+id+"']").length > 0){//SI YA EL QUE ESTAMOS CLIKEANDO ES EL ACTIVO LO DESACTIVAMOS
		//console.log("aqui si llega");
		jQuery("."+tipo+" .botonSeleccionar").removeClass("active");
		activaDesactivaR();
	}else{
		jQuery("."+tipo+" .botonSeleccionar").removeClass("active");

		jQuery("."+tipo+" .botonSeleccionar[data-id='"+id+"']").addClass("active");

		activaDesactivaR();
	}
	
}

jQuery(function(){
	//alert("Hola bebe");
	/*
	 *
	 * CLICK EN BOTON PARA ACTIVAR USUARIO
	 *
	*/
	
});

function botonSeleccionar(){
	jQuery(".botonSeleccionar").click(function(){
		var id = jQuery(this).attr("data-id");
		var tipo = jQuery(this).attr("data-tipo");

		accionClickBotonS(id, tipo);
	});
}



/**/
function botonRelacionar(){
	jQuery(".botonRelacionar").click(function(){
		//var post_id = jQuery(this).data('id');
		jQuery.ajax({
			url : postlove.ajax_url,
			type : 'post',
			data : {
				action : 'postj_relaciona_jugador',
				post_id: modificaJugador.jugador,
				user_id: modificaJugador.usuarios
			},
			success : function( response ) {
				//jQuery('#love-count').html( response );
				//alert(response);

				jQuery(".contenedorInformacionRela").html(response);

				llamaFunciones();
			}
		});

		return false;
	});
}

function buscarUsuario(){
	jQuery(".busquedaUsuarios").keyup(function(){
		//var post_id = jQuery(this).data('id');

		var nombre = jQuery(this).val();

		console.log(nombre);

		jQuery.ajax({
			url : postlove.ajax_url,
			type : 'post',
			data : {
				action : 'caja_usuarios_rela',
				nombre: nombre
			},
			success : function( response ) {
				//jQuery('#love-count').html( response );
				//alert(response);

				jQuery(".cajaUsuariosRela").html(response);

				llamaFunciones();
			}
		});

		return false;
	});
}


function llamaFunciones(){
	//BOTON PARA RELACIONAR
	botonRelacionar();
	//
	botonSeleccionar();

	//
	buscarUsuario();
}


//LLAMA A TODAS LAS FUNCIONES
llamaFunciones();