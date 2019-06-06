<?php
/*
 *
 * TENDREMOS LAS ACCIONES DE VERIFICACION DE USUARIOS
 *
*/
function revisarUsuarios($datosGenerales){
	global $wpdb;
	//echo "<h3>datos usuarios</h3>";
	foreach ($datosGenerales as $datos) {

		//AQUI YA TENEMOS TODOS LOS DATOS DEL USUARIO INSCRITO
		$queValor = devuelveLabel($datos->meta_key);
		if($queValor == "Nombre"){//SOLO QUEREMOS MOSTRAR EL NOMBRE
			echo "<tr>";
			echo "<td>";
			//echo "<p> ".devuelveLabel($datos->meta_key).": ".$datos->meta_value." </p>";
			echo "<p> ".$datos->meta_value." </p>";
			echo "</td>";

			echo "<td>";

			//CONSULTAMOS SI ESTE USUARIO YA TIENE UN JUGADOR ASIGNADO
			$consultaJugador = $wpdb->get_results("SELECT pos.* FROM {$wpdb->prefix}posts AS pos WHERE pos.post_author = ".$datos->user_id." AND post_type = 'sp_player'");
			if(count($consultaJugador) > 0){
				echo "<p>EXISTE UN JUGADOR</p>";
			}else{
				echo "<p>NO EXISTE UN JUGADOR</p>";
			}
			echo "</td>";
			echo "<td><button class='btn botonSeleccionar' data-id='".$datos->user_id."' data-tipo='usuarios'>seleccionar</button></td>";
			echo "</tr>";
		}
    }
}


/*
 *
 *	RETORNA LA CAJA DE RESULTADOS
 *
*/

function moduloUsuarios($nombre){
	global $wpdb;
?>
	<table class="usuarios">
      <tr>
        <td>Nombre</td>
        <td>Relacion</td>
        <td>Accion</td>
      </tr>
      <?php
        $datosUsuario = $wpdb->get_results("SELECT met.* FROM {$wpdb->prefix}metrics_users AS met WHERE met.meta_value LIKE '%".$nombre."%' GROUP BY met.user_id ");
        foreach ($datosUsuario as $key) {
          $datosGenerales = $wpdb->get_results("SELECT met.* FROM {$wpdb->prefix}metrics_users AS met WHERE met.user_id = ".$key->user_id);

          //LLAMAMOS A LA FUNCTION QUE REVISARA LOS USUARIOS
          revisarUsuarios($datosGenerales);
        }
      ?>
    </table>
<?php
}

add_action( 'wp_ajax_nopriv_caja_usuarios_rela', 'caja_usuarios_rela' );//USUARIOS INVITADOS
add_action( 'wp_ajax_caja_usuarios_rela', 'caja_usuarios_rela' );//USUARIOS QUE INICIAN SESION
function caja_usuarios_rela(){
	global $wpdb;

	$nombre = $_REQUEST['nombre'];

	echo moduloUsuarios($nombre);
	die();
}

//FUNCTION QUE DEVUELVE LABEL DE FORMULARIO
function devuelveLabel($label){
	global $wpdb;
	global $user;

	global $formularioSub;

	$idUsuario = $user->ID;


	//FORMULARIOS QUE QUEREMOS RELACIONAR 
	$formulariosR = $formularioSub;

	//ARREGLO QUE RECORREREMOS SEGUN EL FORMULARIO
	$datosForm = [];


	//AQUI SACAMOS LA CONSULTA PARA TRAERNOS TODOS LOS CAMPOS 
	$parametrosForm = [];

	//return 'Esto es el contenido';

	//EN ESTE VAMOS A TRAER LOS DATOS DEL FORMULARIO
	//SACAMOS EL NOMBRE DEL USUARIO
	$nombreSuser = $wpdb->get_results("SELECT display_meta FROM {$wpdb->prefix}rg_form_meta WHERE form_id = ".$formulariosR." ");

	//echo "SELECT value FROM wp_2_rg_lead_detail WHERE lead_id = ".$_GET['id']." AND form_id = 12 AND field_number = $formulariosR ";

	$cualNombre = "";
	foreach ($nombreSuser as $atributoss) {
		//ARREGLO MOMENTANEO
		$momentaneo = [];
		//relacionMetas($con3['display_meta']);
		//echo "<br>/<br>";

		//echo "<h1>DISPLAY META -> ".$atributoss->display_meta."</h1>";

		array_push($momentaneo, $formulariosR);
		array_push($momentaneo, relacionMetas($atributoss->display_meta));

		//GUARDANDO LA DATA EN EL ARREGLO DE FORMULARIO
		array_push($datosForm, $momentaneo);

		//VACIANDO ARREGLO MOMENTANEO
		$momentaneo = [];
	}


	//CONSULTAMOS EL ULTIMO PARAMETRO INSERTADO EN EL FORMULARIO
	for ($i=0; $i < count($datosForm); $i++) { 
		//
		for ($u=0; $u < count($datosForm[$i][1]); $u++) { 
			//echo $datosForm[$i][0]." ".$datosForm[$i][1][$u][0]." ".$datosForm[$i][1][$u][1]."<br>";
			if($label == $datosForm[$i][1][$u][0]){
				return $datosForm[$i][1][$u][1];//AQUI DEVOLVEMOS EL LABEL NECESITADO
			}
		}
	}
}


/*
 *
 *	RELACIONAR USUARIO CON JUGADOR
 *
*/


add_action( 'wp_ajax_nopriv_postj_relaciona_jugador', 'postj_relaciona_jugador' );//USUARIOS INVITADOS
add_action( 'wp_ajax_postj_relaciona_jugador', 'postj_relaciona_jugador' );//USUARIOS QUE INICIAN SESION

function postj_relaciona_jugador() {
	//RECUPERAMOS LAS VARIABLES NECESITADAS
	$user_id = $_REQUEST['user_id'];
	$post_id = $_REQUEST['post_id'];

	// Update post 37
	$my_post = array(
	  'ID'           => $post_id,
	  'post_author'   => $user_id
	);

	// Update the post into the database
	wp_update_post( $my_post );

	echo usuariosReglistrados();
	die();

	/*
	$love = get_post_meta( $_REQUEST['post_id'], 'post_love', true );
	$love++;
	update_post_meta( $_REQUEST['post_id'], 'post_love', $love );
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) { 
		echo $love;
		die();
	}
	else {
		wp_redirect( get_permalink( $_REQUEST['post_id'] ) );
		exit();
	}

	*/
}