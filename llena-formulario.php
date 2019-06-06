<?php
/*
 *
 * FUNCION PARA RECUPERAR LOS CAMPOS DE UN FORMULARIO SI YA FUERON LLENADOS
 *
 */
/*
$numeroDeusuario = 0;
if(is_user_logged_in()){
	$user = wp_get_current_user();
	//echo "<h1>".$user->Camisa."</h1>";

	$idUsuario = $user->ID;

	//$all_meta_for_user = get_user_meta($idUsuario);

	$all_meta_for_user = $wpdb->get_results("SELECT met.* FROM {$wpdb->prefix}metrics_users AS met WHERE met.user_id = {$idUsuario} ");

	//RECORREMOS TODO
	function recorrerForm($parametro){
		$parametroE = $parametro->meta_value;



		//echo "<h1>".$parametro->meta_key."</h1>";
		
		$parametroMinuscula1 = str_replace(" ", "_", $parametro->meta_key);
		//$parametroMinuscula = strtolower($parametro->meta_key);
		$parametroMinuscula = "nombre";

		add_filter( 'gform_field_value_'.$parametroMinuscula, function( $content ) use($parametroE) {
			global $post;
		    global $user;
		    $queQuiero = "amigo";

		    $parametro1 = str_replace(" ", "_", $parametro->meta_key);

		    //$author_email = get_the_author_meta( $parametro1, $post->post_author );
		    $author_email = get_the_author_meta( $parametro1, $parametro->meta_value );

		    return $parametroE;
		});
	}
	$idSubuser = 0;
	//NOS QUEDAMOS CON ESTE
	foreach ($all_meta_for_user as $atributoss) {
		recorrerForm($atributoss);

		//$idSubuser = $atributoss->sub_user_id;
	}

	//AGREGANDO EL ID AL USUARIO
	/*
	add_filter( 'gform_field_value_sub_user_id', 'my_custom_population_function' );
	function my_custom_population_function( $value ) {
	    return "que paso ";
	}
	*/
	/*
	add_filter('gform_field_value_sub_user_id', function($content) use($idSubuser){
		return $idSubuser;
	});
	*/
/*
}
*/