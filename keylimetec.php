<?php
   /*
   Plugin Name: Keylimetec
   Plugin URI: http://www.keylimetec.com/
   description: Primer Plugin de Keylimetec
   Version: 1.3
   Author: Joser
   Author URI: http://www.keylimetec.com/
   License: GPL2
   */
/*
 *
 *  CUAL FORMULARIO RELACIONAREMOS
 *
*/

//$miFormulario = 1;
//$formularioSub = 1;

$miFormulario = 13;
$miFormulario2 = 15;
$miFormulario3 = 10;
$miFormulario4 = 12;

//FORMULARIO DE INSCRIPCION PAGO
$formularioSub = 18;

//FORMULARIO DE INSCRIPCION SUBCIDIADO
$formularioSub2 = 20;


//COMENZAMOS A APLICAR LOS FORMULARIOS DE INSCRIPCIONES DE LA LIGA PRO
$formularioPro1 = 23;
$formularioPro2 = 24;//ESTA ES PARA EL FORMULARIO PRO SUB

//FORMULARIOS DE PAGO RECURRENTE
$formularioRecurrente1 = 26;
$formularioRecurrente2 = 28;//SUBCIDIADO
/*
**
  INCLUDE DE CREAR JUGADORES
**
*/
include("crear-jugadores.php"); 
/*
**
  IMPORTAMOS ESTILOS
**
*/
add_action('wp_enqueue_scripts', 'callback_for_setting_up_scripts');
function callback_for_setting_up_scripts() {
  /*
    wp_register_style( 'namespace', '/wp-content/plugins/keylimetec/css/keylimetec_css.css' );
    wp_enqueue_style( 'namespace' );
    wp_enqueue_script( 'namespaceformyscript', '/wp-content/plugins/keylimetec/js/keylimetec_js.js', array( 'jquery' ) );
  */

    //echo "<h1>".plugins_url( '/css/keylimetec_css.css', __FILE__ )."</h1>";

  //if( is_single() ) {
    wp_enqueue_style( 'keylimetec', plugins_url( '/css/keylimetec_css.css', __FILE__ ) );
  //}

  wp_enqueue_style( 'keylimetec' );

  wp_enqueue_script( 'keylimetec', plugins_url( '/js/keylimetec_js.js', __FILE__ ), array('jquery'), '1.0', true );

  wp_localize_script( 'keylimetec', 'postlove', array(
    'ajax_url' => admin_url( 'admin-ajax.php' )
  ));
}
/**
 *
 *
 *  FUNCION PARA SANEAR EL STRING O ELIMINAR DATOS IMNECESARIOS
 *
*/
//lIMPIANDO EL TEXTO
function sanear_string($string){
 
    $string = trim($string);
 
    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );
 
    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );
 
    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );
 
    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );
 
    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );
 
    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );
 
    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", '"',
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "<code>", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             ".", " "),
        '',
        $string
    );
 
 
    return $string;
}

/*
 *
 *  AGREGAREMOS ACCION CUANDO ENVIEMOS EL FORMULARIO
 *
 */



/**
   *
   *
   *
   *
   *

*/

if(!function_exists('wp_get_current_user')) {
    include(ABSPATH . "wp-includes/pluggable.php"); 
}

add_action('init','do_stuff');
function do_stuff(){
  $current_user = wp_get_current_user();
  return $current_user;
}

//$user = wp_get_current_user();
$user = do_stuff();
$idUsuario = $user->ID;

//echo "<h1>ID usuario: ".$user->ID."</h1>";


/*
 *
 *  AQUI LLAMAMOS A TODOS LOS USUARIOS REQUISTRADOS
 *
*/
include("administrar-usuarios.php"); 

function usuariosReglistrados(){
  global $wpdb;
  //return "Shortcode";
?>
  <div class="contenedorInformacionRela">
    <div class="contenedorRelacionar">
      <button class='btn botonRelacionar' disabled="disabled">Relacionar</button>
    </div>
    <table>
      <!-- SECCION DE BUSQUEDA -->
      <tr>
        <td>
          <table>
            <tr>
              <td>
                <input type="text" class="busquedaUsuarios" placeholder="Buscar usuario" />
              </td>
            </tr>
          </table>
          <div class="cajaRelacion cajaUsuariosRela">
            <table class="usuarios">
              <tr>
                <td>Nombre</td>
                <td>Relacion</td>
                <td>Accion</td>
              </tr>
              <?php
                $datosUsuario = $wpdb->get_results("SELECT met.* FROM {$wpdb->prefix}metrics_users AS met GROUP BY met.user_id ");
                foreach ($datosUsuario as $key) {
                  $datosGenerales = $wpdb->get_results("SELECT met.* FROM {$wpdb->prefix}metrics_users AS met WHERE met.user_id = ".$key->user_id);

                  //LLAMAMOS A LA FUNCTION QUE REVISARA LOS USUARIOS
                  revisarUsuarios($datosGenerales);
                  /*
                  foreach ($datosGenerales as $datos) {
                    echo "<h1>".$datos->meta_value."</h1>";
                  }
                  */
                }
              ?>
            </table>
          </div>
        </td>
        <td>
          <table>
            <tr>
              <td>
                <input type="text" placeholder="Buscar jugador" />
              </td>
            </tr>
          </table>
          <div class="cajaRelacion">
            <table class="jugador">
              <tr>
                <td>Nombre</td>
                <td>Accion</td>
              </tr>
              <?php
                $consultaJugador = $wpdb->get_results("SELECT pos.* FROM {$wpdb->prefix}posts AS pos WHERE pos.post_type = 'sp_player'");
                foreach ($consultaJugador as $key) {
                  echo "<tr>";
                  echo "<td>";
                  echo $key->post_title;
                  echo "</td>";
                  echo "<td>";
                  echo "<button class='btn botonSeleccionar' data-id='".$key->ID."' data-tipo='jugador'>seleccionar</button>";
                  echo "</td>";
                  echo "</tr>";
                }
              ?>
            </table>
          </div>
        </td>
      </tr>
    </table>
  </div>
<?php
}
add_shortcode('codigo', 'usuariosReglistrados'); 

/*
 *
 *  FUNCTION PARA BUSCAR RELACION ENTRE ID Y META KEY
 *
 *
*/
function relacionMetas($cualVariable){
  $obj = json_decode($cualVariable);//AQUI CREAMOS EL OBJETO JSON


  //CREAMOS ARREGLO MOMENTANEO
  $momentaneo = [];

  for($i = 0; $i < count($obj->{'fields'});$i++){//AQUI LO RECORREMOS
    //echo $obj->fields[$i]->{'label'}." ".$obj->fields[$i]->{'id'}."<br>";

    //GUARDAMOS LA INFO EN ARREGLO MOMENTANEO
    //array_push($momentaneo, $obj->fields[$i]->{'id'});

    //uub3

    //echo "<br><br><br><br><br> --->  ".$obj->fields[$i]->{'id'}."  <---- <br><br><br><br><br>";

    //echo "<h1>ID DE METRICS-> ".$obj->fields[$i]->{'id'}."</h1>";

    $uub3 = [];
    array_push($uub3, $obj->fields[$i]->{'id'});
    array_push($uub3, $obj->fields[$i]->{'label'});

    array_push($momentaneo, $uub3);

    $uub3 = [];

    
  }
  return $momentaneo;//DEVOLVEMOS EL ARREGLO QUE ACABAMOS DE CREAR
  //CERRAMOS ARREGLO MOMENTANEO
  $momentaneo = [];
}

/**
   *
   *
   * Recorrer FORMULARIO
   *
   *

*/
//ANCLA QUE SE EJECUTA CUANDO SE ENVIA EXITOSAMENTE EL FORMULARIO
//add_action( 'gform_after_submission_'.$formularioSub, 'inscripcion_realizada', 10, 2 );
//add_action( 'gform_after_submission_'.$formularioSub2, 'inscripcion_realizada', 10, 2 );

//AQUI PONEMOS EL FORMULARIO RECURRENTE
//add_action( 'gform_after_submission_'.$formularioRecurrente1, 'inscripcion_realizada', 10, 2 );
//add_action( 'gform_after_submission_'.$formularioRecurrente2, 'inscripcion_realizada', 10, 2 );

function inscripcion_realizada($entry, $form){
  global $wpdb;
  $user = wp_get_current_user();
  $datosEnviados = [];

  $nombreCompleto = "";
  $cuentaN = 0;

  //DATOS DEL EQUIPO
  $equipoJ = 0;

  //DORSAS
  $dorsalJ = 0;

  //NACIONALIDAD
  $nacionalidadJ = 0;

  //COMPETICION
  $competicionJ = 0;

  //TEMPORADA
  $temporadaJ = 0;

  //echo "<h1>Usuario ".$user->ID." </h1><br><br>";
   foreach ( $form['fields'] as $field ) {
        $inputs = $field->get_entry_inputs();
        if ( is_array( $inputs ) ) {
            foreach ( $inputs as $input ) {
                $value = rgar( $entry, (string) $input['id'] );
                // do something with the value
                if($value != ""){

                  $inputId = "";
                  $cual = ".";

                  $pos = strpos($input['id'], $cual);
                  $inputId = substr($input['id'], 0, $pos);

                  //MOMENTANEO
                  $momentaneo = [];
                  array_push($momentaneo, $user->ID);
                  array_push($momentaneo, $inputId);
                  array_push($momentaneo, $value);

                  //AGREGAMOS AL ARREGLO GENERAL
                  array_push($datosEnviados, $momentaneo);
                  $momentaneo = [];

                  //CREAREMOS EL NOMBRE DEL USUARIO REGISTRADO
                  if(devuelveLabel($input['id']) == "Nombre" || devuelveLabel($input['id']) == "Apellido" || devuelveLabel($input['id']) == "Apellido materno"){
                    //echo "<h1>Este es el nombre -> ".$value."</h1>";
                    if($cuentaN == 0){
                      $nombreCompleto .= $value;
                    }else{
                      $nombreCompleto .= " ".$value;
                    }

                    $cuentaN++;
                  }

                  //GUARDAMOS EL ID DEL USUARIO PARA PODER RELACIONARLO DE NO EXISTIR
                  if(devuelveLabel($input['id']) == "Elige tu equipo"){
                    $equipoJ = $value;
                  }

                  //DORSAL
                  if(devuelveLabel($input['id']) == "Número que desea en camiseta"){
                    $dorsalJ = $value;
                  }

                  //NACIONALIDAD
                  if(devuelveLabel($input['id']) == "País"){
                    $nacionalidadJ = $value;
                  }

                  //COMPETICION
                  if(devuelveLabel($input['id']) == "Competiciones"){
                    $competicionJ = $value;
                    //echo "<h1>llega a los ID</h1>";
                  }

                  //TEMPORADA
                  if(devuelveLabel($input['id']) == "Temporada"){
                    $temporadaJ = $value;
                  }

                  //echo "<h1> ".$input['id'] ." - ".$value."</h1>";
                }
            }
        } else {
            $value = rgar( $entry, (string) $field->id );

            //MOMENTANEO
            $momentaneo = [];
            array_push($momentaneo, $user->ID);
            array_push($momentaneo, $field->id);
            array_push($momentaneo, $value);

            //AGREGAMOS AL ARREGLO GENERAL
            array_push($datosEnviados, $momentaneo);
            $momentaneo = [];

            //CREAREMOS EL NOMBRE DEL USUARIO REGISTRADO
            if(devuelveLabel($field->id) == "Nombre" || devuelveLabel($field->id) == "Apellido" || devuelveLabel($field->id) == "Apellido materno"){
              //echo "<h1>Este es el nombre -> ".$value."</h1>";
              if($cuentaN == 0){
                $nombreCompleto .= $value;
              }else{
                $nombreCompleto .= " ".$value;
              }

              $cuentaN++;
            }

            //GUARDAMOS EL ID DEL USUARIO PARA PODER RELACIONARLO DE NO EXISTIR
            if(devuelveLabel($field->id) == "Elige tu equipo"){
              $equipoJ = $value;
            }

            //DORSAL
            if(devuelveLabel($field->id) == "Número que desea en camiseta"){
              $dorsalJ = $value;
            }

            //NACIONALIDAD
            if(devuelveLabel($field->id) == "País"){
              $nacionalidadJ = $value;
            }

            //COMPETICION
            if(devuelveLabel($field->id) == "Competiciones"){
              $competicionJ = $value;
              //echo "<h1>llega a los Field</h1>";
            }

            //TEMPORADA
            if(devuelveLabel($field->id) == "Temporada"){
              $temporadaJ = $value;
            }

            // do something with the value

            //echo "<h1> ".$field->id." - ".$value."</h1>";
            //echo "<h1>".$valorCompleto."</h1>";

            //LO OCULTAMOS PORQUE YA NO LO NECESITAMOS
            //funcionInsert($value, $valorCompleto);
        }
    }

    //IMPRIMIMOS EL NOMBRE COMPLETO DEL CLIENTE
    //echo "<h1>Nombre ---> ".$nombreCompleto."</h1>";

    //DATOS DEL JUGADOR
    $datosJugador = [];
    array_push($datosJugador, $nombreCompleto);
    array_push($datosJugador, $equipoJ);
    array_push($datosJugador, $dorsalJ);
    array_push($datosJugador, $nacionalidadJ);
    array_push($datosJugador, $competicionJ);
    array_push($datosJugador, $temporadaJ);

    $idFormulario = $form['id'];
    $idRed = "";

    //CONSULTAMOS LA RELACION DEL FORMULARIO CON LA RED
    $idForm = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}df_red WHERE form = '{$idFormulario}' ");

    foreach ($idForm as $keyf) {
      $idRed = $keyf->red;

      $_SESSION['id-red'] = $idRed;
    }

    if($idRed == ""){
      $idRed = 7;

      $_SESSION['id-red'] = $idRed;
    }
    //ENVIAMOS EL ARREGLO DE TODA LA INFORMACION ENVIADA A UNA NUEVA FUNCTION QUE CONSULTE O INSERTE TODO
    if($idFormulario == 28){
      relacionEnviado($datosEnviados, $datosJugador, $idRed);//ESTO SE HACE EN EL PAGO
    }
}


/*
**
    AQUI TENEMOS LOS FORMULARIOS PRO
**
*/
//ANCLA QUE SE EJECUTA CUANDO SE ENVIA EXITOSAMENTE EL FORMULARIO
////add_action( 'gform_after_submission_'.$formularioPro1, 'inscripcion_realizadaPro', 10, 2 );
////add_action( 'gform_after_submission_'.$formularioPro2, 'inscripcion_realizadaPro', 10, 2 );

function inscripcion_realizadaPro($entry, $form){
  global $wpdb;
  $user = wp_get_current_user();
  $datosEnviados = [];

  $nombreCompleto = "";
  $cuentaN = 0;

  //DATOS DEL EQUIPO
  $equipoJ = 0;

  //DORSAS
  $dorsalJ = 0;

  //NACIONALIDAD
  $nacionalidadJ = 0;

  //COMPETICION
  $competicionJ = 0;

  //TEMPORADA
  $temporadaJ = 0;

  //echo "<h1>Usuario ".$user->ID." </h1><br><br>";
   foreach ( $form['fields'] as $field ) {
        $inputs = $field->get_entry_inputs();
        if ( is_array( $inputs ) ) {
            foreach ( $inputs as $input ) {
                $value = rgar( $entry, (string) $input['id'] );
                // do something with the value
                if($value != ""){

                  $inputId = "";
                  $cual = ".";

                  $pos = strpos($input['id'], $cual);
                  $inputId = substr($input['id'], 0, $pos);

                  //MOMENTANEO
                  $momentaneo = [];
                  array_push($momentaneo, $user->ID);
                  array_push($momentaneo, $inputId);
                  array_push($momentaneo, $value);

                  //AGREGAMOS AL ARREGLO GENERAL
                  array_push($datosEnviados, $momentaneo);
                  $momentaneo = [];

                  //CREAREMOS EL NOMBRE DEL USUARIO REGISTRADO
                  if(devuelveLabel($input['id']) == "Nombre" || devuelveLabel($input['id']) == "Apellido" || devuelveLabel($input['id']) == "Apellido materno"){
                    //echo "<h1>Este es el nombre -> ".$value."</h1>";
                    if($cuentaN == 0){
                      $nombreCompleto .= $value;
                    }else{
                      $nombreCompleto .= " ".$value;
                    }

                    $cuentaN++;
                  }

                  //GUARDAMOS EL ID DEL USUARIO PARA PODER RELACIONARLO DE NO EXISTIR
                  if(devuelveLabel($input['id']) == "Elige tu equipo"){
                    $equipoJ = $value;
                  }

                  //DORSAL
                  if(devuelveLabel($input['id']) == "Número que desea en camiseta"){
                    $dorsalJ = $value;
                  }

                  //NACIONALIDAD
                  if(devuelveLabel($input['id']) == "País"){
                    $nacionalidadJ = $value;
                  }

                  //COMPETICION
                  if(devuelveLabel($input['id']) == "Competiciones"){
                    $competicionJ = $value;
                    //echo "<h1>llega a los ID</h1>";
                  }

                  //TEMPORADA
                  if(devuelveLabel($input['id']) == "Temporada"){
                    $temporadaJ = $value;
                  }

                  //echo "<h1> ".$input['id'] ." - ".$value."</h1>";
                }
            }
        } else {
            $value = rgar( $entry, (string) $field->id );

            //MOMENTANEO
            $momentaneo = [];
            array_push($momentaneo, $user->ID);
            array_push($momentaneo, $field->id);
            array_push($momentaneo, $value);

            //AGREGAMOS AL ARREGLO GENERAL
            array_push($datosEnviados, $momentaneo);
            $momentaneo = [];

            //CREAREMOS EL NOMBRE DEL USUARIO REGISTRADO
            if(devuelveLabel($field->id) == "Nombre" || devuelveLabel($field->id) == "Apellido" || devuelveLabel($field->id) == "Apellido materno"){
              //echo "<h1>Este es el nombre -> ".$value."</h1>";
              if($cuentaN == 0){
                $nombreCompleto .= $value;
              }else{
                $nombreCompleto .= " ".$value;
              }

              $cuentaN++;
            }

            //GUARDAMOS EL ID DEL USUARIO PARA PODER RELACIONARLO DE NO EXISTIR
            if(devuelveLabel($field->id) == "Elige tu equipo"){
              $equipoJ = $value;
            }

            //DORSAL
            if(devuelveLabel($field->id) == "Número que desea en camiseta"){
              $dorsalJ = $value;
            }

            //NACIONALIDAD
            if(devuelveLabel($field->id) == "País"){
              $nacionalidadJ = $value;
            }

            //COMPETICION
            if(devuelveLabel($field->id) == "Competiciones"){
              $competicionJ = $value;
              //echo "<h1>llega a los Field</h1>";
            }

            //TEMPORADA
            if(devuelveLabel($field->id) == "Temporada"){
              $temporadaJ = $value;
            }

            // do something with the value

            //echo "<h1> ".$field->id." - ".$value."</h1>";
            //echo "<h1>".$valorCompleto."</h1>";

            //LO OCULTAMOS PORQUE YA NO LO NECESITAMOS
            //funcionInsert($value, $valorCompleto);
        }
    }

    //IMPRIMIMOS EL NOMBRE COMPLETO DEL CLIENTE
    //echo "<h1>Nombre ---> ".$nombreCompleto."</h1>";

    //DATOS DEL JUGADOR
    $datosJugador = [];
    array_push($datosJugador, $nombreCompleto);
    array_push($datosJugador, $equipoJ);
    array_push($datosJugador, $dorsalJ);
    array_push($datosJugador, $nacionalidadJ);
    array_push($datosJugador, $competicionJ);
    array_push($datosJugador, $temporadaJ);

    $idFormulario = $form['id'];
    $idRed = "";

    //CONSULTAMOS LA RELACION DEL FORMULARIO CON LA RED
    $idForm = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}df_red WHERE form = '{$idFormulario}' ");

    foreach ($idForm as $keyf) {
      $idRed = $keyf->red;

      $_SESSION['id-red'] = $idRed;
    }

    if($idRed == ""){
      $idRed = 8;

      $_SESSION['id-red'] = $idRed;
    }

    //$idRed = 8;//ESTE ES EL ID DE LA SECCION DE INSCRIPCIONES PRO
    //ENVIAMOS EL ARREGLO DE TODA LA INFORMACION ENVIADA A UNA NUEVA FUNCTION QUE CONSULTE O INSERTE TODO
    if($idFormulario == 24){
      relacionEnviado($datosEnviados, $datosJugador, $idRed);//ESTO SE HACE EN EL PAGO
    }
}


/*
**
  RELACION DE TODOS LOS FORMULARIOS CUANDO SE ENVIAN
**
*/

add_action( 'gform_after_submission', 'incripcion_all_form', 10, 2 );
function incripcion_all_form($entry, $form){
  global $wpdb;

  global $miFormulario;
  global $miFormulario2;
  global $miFormulario3;
  global $miFormulario4;
  global $formularioSub;
  global $formularioSub2;
  global $formularioPro1;
  global $formularioPro2;
  global $formularioRecurrente1;
  global $formularioRecurrente2;

  //VALIDAMOS QUE EL FORM ACTUAL NO SEA NINGUNO DE LOS ANTERIORES
  //if($form['id'] != $miFormulario && $form['id'] != $miFormulario2 && $form['id'] != $miFormulario3 && $form['id'] != $miFormulario4 && $form['id'] != $formularioSub && $form['id'] != $formularioSub2 && $form['id'] != $formularioPro1 && $form['id'] != $formularioPro2 && $form['id'] != $formularioRecurrente1 && $form['id'] != $formularioRecurrente2){
    //--------------------->

    $user = wp_get_current_user();
    $datosEnviados = [];

    $nombreCompleto = "";
    $cuentaN = 0;

    //DATOS DEL EQUIPO
    $equipoJ = 0;

    //DORSAS
    $dorsalJ = 0;

    //NACIONALIDAD
    $nacionalidadJ = 0;

    //COMPETICION
    $competicionJ = 0;

    //TEMPORADA
    $temporadaJ = 0;

    //echo "<h1>Usuario ".$user->ID." </h1><br><br>";
     foreach ( $form['fields'] as $field ) {
          $inputs = $field->get_entry_inputs();
          if ( is_array( $inputs ) ) {
              foreach ( $inputs as $input ) {
                  $value = rgar( $entry, (string) $input['id'] );
                  // do something with the value
                  if($value != ""){

                    $inputId = "";
                    $cual = ".";

                    $pos = strpos($input['id'], $cual);
                    $inputId = substr($input['id'], 0, $pos);

                    //MOMENTANEO
                    $momentaneo = [];
                    array_push($momentaneo, $user->ID);
                    array_push($momentaneo, $inputId);
                    array_push($momentaneo, $value);

                    //AGREGAMOS AL ARREGLO GENERAL
                    array_push($datosEnviados, $momentaneo);
                    $momentaneo = [];

                    //CREAREMOS EL NOMBRE DEL USUARIO REGISTRADO
                    if(devuelveLabel($input['id']) == "Nombre" || devuelveLabel($input['id']) == "Apellido" || devuelveLabel($input['id']) == "Apellido materno"){
                      //echo "<h1>Este es el nombre -> ".$value."</h1>";
                      if($cuentaN == 0){
                        $nombreCompleto .= $value;
                      }else{
                        $nombreCompleto .= " ".$value;
                      }

                      $cuentaN++;
                    }

                    //GUARDAMOS EL ID DEL USUARIO PARA PODER RELACIONARLO DE NO EXISTIR
                    if(devuelveLabel($input['id']) == "Elige tu equipo"){
                      $equipoJ = $value;
                    }

                    //DORSAL
                    if(devuelveLabel($input['id']) == "Número que desea en camiseta"){
                      $dorsalJ = $value;
                    }

                    //NACIONALIDAD
                    if(devuelveLabel($input['id']) == "País"){
                      $nacionalidadJ = $value;
                    }

                    //COMPETICION
                    if(devuelveLabel($input['id']) == "Competiciones"){
                      $competicionJ = $value;
                      //echo "<h1>llega a los ID</h1>";
                    }

                    //TEMPORADA
                    if(devuelveLabel($input['id']) == "Temporada"){
                      $temporadaJ = $value;
                    }

                    //echo "<h1> ".$input['id'] ." - ".$value."</h1>";
                  }
              }
          } else {
              $value = rgar( $entry, (string) $field->id );

              //MOMENTANEO
              $momentaneo = [];
              array_push($momentaneo, $user->ID);
              array_push($momentaneo, $field->id);
              array_push($momentaneo, $value);

              //AGREGAMOS AL ARREGLO GENERAL
              array_push($datosEnviados, $momentaneo);
              $momentaneo = [];

              //CREAREMOS EL NOMBRE DEL USUARIO REGISTRADO
              if(devuelveLabel($field->id) == "Nombre" || devuelveLabel($field->id) == "Apellido" || devuelveLabel($field->id) == "Apellido materno"){
                //echo "<h1>Este es el nombre -> ".$value."</h1>";
                if($cuentaN == 0){
                  $nombreCompleto .= $value;
                }else{
                  $nombreCompleto .= " ".$value;
                }

                $cuentaN++;
              }

              //GUARDAMOS EL ID DEL USUARIO PARA PODER RELACIONARLO DE NO EXISTIR
              if(devuelveLabel($field->id) == "Elige tu equipo"){
                $equipoJ = $value;
              }

              //DORSAL
              if(devuelveLabel($field->id) == "Número que desea en camiseta"){
                $dorsalJ = $value;
              }

              //NACIONALIDAD
              if(devuelveLabel($field->id) == "País"){
                $nacionalidadJ = $value;
              }

              //COMPETICION
              if(devuelveLabel($field->id) == "Competiciones"){
                $competicionJ = $value;
                //echo "<h1>llega a los Field</h1>";
              }

              //TEMPORADA
              if(devuelveLabel($field->id) == "Temporada"){
                $temporadaJ = $value;
              }

              // do something with the value

              //echo "<h1> ".$field->id." - ".$value."</h1>";
              //echo "<h1>".$valorCompleto."</h1>";

              //LO OCULTAMOS PORQUE YA NO LO NECESITAMOS
              //funcionInsert($value, $valorCompleto);
          }
      }

      //IMPRIMIMOS EL NOMBRE COMPLETO DEL CLIENTE
      //echo "<h1>Nombre ---> ".$nombreCompleto."</h1>";

      //DATOS DEL JUGADOR
      $datosJugador = [];
      array_push($datosJugador, $nombreCompleto);
      array_push($datosJugador, $equipoJ);
      array_push($datosJugador, $dorsalJ);
      array_push($datosJugador, $nacionalidadJ);
      array_push($datosJugador, $competicionJ);
      array_push($datosJugador, $temporadaJ);

      $idFormulario = $form['id'];
      $idRed = "";

      //CONSULTAMOS LA RELACION DEL FORMULARIO CON LA RED
      $idForm = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}df_red WHERE form = '{$idFormulario}' ");

      foreach ($idForm as $keyf) {
        $idRed = $keyf->red;

        $_SESSION['id-red'] = $idRed;
      }

      if($idRed == ""){
        $idRed = 8;

        $_SESSION['id-red'] = $idRed;
      }

      //$idRed = 8;//ESTE ES EL ID DE LA SECCION DE INSCRIPCIONES PRO
      //PRIMERO REVISAMOS QUE ESTE FORMULARIO TENGA UN PRODUCTO ASIGNADO, SI NO ES ASI PROCEDEMOS A GUARDAR COMO SUB
      $revP = $wpdb->get_results("SELECT f.*, d.product AS product, d.product_hijo AS product_hijo, d.value AS value FROM wp_df_tags AS d, wp_rg_form AS f WHERE d.form = {$idFormulario} AND d.form = f.id AND f.is_active = '1' AND f.is_trash = '0' ");
      $saberSihay = 0;
      foreach ($revP as $keysz) {
        $saberSihay++;
      }

      //ENVIAMOS EL ARREGLO DE TODA LA INFORMACION ENVIADA A UNA NUEVA FUNCTION QUE CONSULTE O INSERTE TODO
      if($saberSihay <= 0){
        relacionEnviado($datosEnviados, $datosJugador, $idRed);//ESTO SE HACE EN EL PAGO
      }

    //--------------------->
  //}

  
}

/*
 *
 *  RELACIONAR SEGUN EL FORMULARIO ENVIADO
 *
 *
*/
function relacionEnviado($datosEnviados, $datosJugador, $idRed){
  global $wpdb;
  $user = wp_get_current_user();
  //PRIMERO CONSULTAREMOS SI LO QUE NOS ENVIAN EXISTE
  for ($i=0; $i < count($datosEnviados); $i++) { 
    $idUsuario = $datosEnviados[$i][0];
    $idVariable = $datosEnviados[$i][1];
    $valor = $datosEnviados[$i][2];
    
    //

    $datosUsuario = $wpdb->get_results("SELECT met.* FROM {$wpdb->prefix}metrics_users AS met WHERE met.user_id = ".$user->ID." AND met.meta_key = '".$idVariable."'");
    if(count($datosUsuario) > 0){//AQUI PROCEDEMOS A ACTUALIZAR LA PAGINA
      //echo "<h1>Pasa por el update ".$idUsuario." ".$idVariable." ".$valor." </h1>";
      $wpdb->update( 
                  "{$wpdb->prefix}metrics_users", 
                  array( 
                    'meta_value' => $valor 
                  ), 
                  array( 
                    'user_id' => $user->ID,
                    'meta_key' => $idVariable 
                    ) 
                );
    }else{//AQUI PROCEDEMOS A INSERTAR EL NUEVO ATRIBUTO DEL USUARIO
      //echo "<h1>Pasa por el insert ".$idUsuario." ".$idVariable." ".$valor." </h1>";
      $wpdb->insert(
                "{$wpdb->prefix}metrics_users",
                array(
                    'user_id' => $user->ID,
                    'meta_key' => $idVariable,
                    'meta_value' => $valor
                  )
                );
    }
  }

  //EN ESTE MODULO REVISAREMOS SI EL USUARIO TIENE ALGUN JUGADOR CREADO, SI NO LO TIENE CREADO PROCEDEMOS A CREARLO
  //$consultaJugador = $wpdb->get_results("SELECT pos.* FROM {$wpdb->prefix}posts AS pos WHERE pos.post_type = 'sp_player' AND pos.post_author = '".$user->ID."'");
  $consultaJugador = $wpdb->get_results("SELECT pos.* FROM wp_{$idRed}_posts AS pos WHERE pos.post_type = 'sp_player' AND pos.post_author = '".$user->ID."'");
  if(count($consultaJugador) > 0){
    foreach ($consultaJugador as $datos) {
      //echo "<h1>".$datos->ID."</h1>"; ESTOS SON LOS ID DE TODOS LOS JUGADORES QUE TIENE ESTE USUARIO
    }
  }else{
    //echo "<h1>No existe el jugador</h1>";//SI EL JUGADOR NO EXISTE PROCEDEMOS A CREARLO
    //CREAMOS AL JUGADOR NUEVO
    crearJugadorJ($user->ID, $datosJugador, $idRed);


    //RELACIONAMOS EL JUGADOR CON SU EQUIPO
    //$equipoJ;
  }
}

/*
 *
 *  LLAMAMOS A FUNCTION QUE RELLENA LOS FORMULARIOS
 *
*/
//include("llena-formulario.php"); 

/*
 *
 *  ACCION DE RECORRER INSERTAR Y CREAR LOS DATOS DEL
 *  USUARIO EN DB, UPLOAD, INSERT, SELECT
 *
 *
*/
/*
add_filter( 'gform_review_page_'.$formularioSub, 'agregaModificaMetrics' );
add_filter( 'gform_review_page_'.$formularioSub2, 'agregaModificaMetrics' );

//FORMULARIOS PRO
add_filter( 'gform_review_page_'.$formularioPro1, 'agregaModificaMetrics' );
add_filter( 'gform_review_page_'.$formularioPro2, 'agregaModificaMetrics' );

//AQUI AGREGAMOS EL RECURRENTE
add_filter( 'gform_review_page_'.$formularioRecurrente1, 'agregaModificaMetrics' );
add_filter( 'gform_review_page_'.$formularioRecurrente2, 'agregaModificaMetrics' );
*/

//agregaModificaMetrics();// ESTE COMENTADO PORQUE NO LO ESTAMOS UTILIZANDO
function agregaModificaMetrics($arregloMetrics = ""){
  global $wpdb;
  global $user;

  //FORMULARIO
  global $miFormulario;

  //LO CAMBIAMOS A EL FORMULARIO NUEVO
  $miFormulario = 18;

  $seImporto = 0;

  //echo "<h1>{$miFormulario} {$wpdb->prefix}</h1>";

  $idUsuario = $user->ID;


  //FORMULARIOS QUE QUEREMOS RELACIONAR 
  $formulariosR = [];
  //array_push($formulariosR, 4);
  array_push($formulariosR, $miFormulario);
  //array_push($formulariosR, 8);

  //ARREGLO QUE RECORREREMOS SEGUN EL FORMULARIO
  $datosForm = [];


  //AQUI SACAMOS LA CONSULTA PARA TRAERNOS TODOS LOS CAMPOS 
  $parametrosForm = [];

  //return 'Esto es el contenido';

  //EN ESTE VAMOS A TRAER LOS DATOS DEL FORMULARIO
  //SACAMOS EL NOMBRE DEL USUARIO
  $nombreSuser = $wpdb->get_results("SELECT display_meta FROM {$wpdb->prefix}rg_form_meta WHERE form_id = {$miFormulario} ");

  if(count($nombreSuser) > 0){

  }else{
    //FORMULARIO APERTURA 2018 SUB
    $nombreSuser = $wpdb->get_results("SELECT display_meta FROM {$wpdb->prefix}rg_form_meta WHERE form_id = {$miFormulario2} ");
    /*
    if (count($nombreSuser) > 0) {}else{
      //FORMULARIO CLAUSURA 2017
      $nombreSuser = $wpdb->get_results("SELECT display_meta FROM {$wpdb->prefix}rg_form_meta WHERE form_id = {$miFormulario3} ");

      if (count($nombreSuser) > 0) {}else{
        //FORMULARIO CLAUSURA 2017 SUB
        $nombreSuser = $wpdb->get_results("SELECT display_meta FROM {$wpdb->prefix}rg_form_meta WHERE form_id = {$miFormulario4} ");
      }
    }
    */
  }

  //echo "SELECT value FROM wp_2_rg_lead_detail WHERE lead_id = ".$_GET['id']." AND form_id = 12 AND field_number = 1 ";

  $cualNombre = "";
  foreach ($nombreSuser as $atributoss) {
    //ARREGLO MOMENTANEO
    $momentaneo = [];
    //relacionMetas($con3['display_meta']);
    //echo "<br>/<br>";

    //echo "<h1>DISPLAY META -> ".$atributoss->display_meta."</h1>";

    array_push($momentaneo, $miFormulario);
    array_push($momentaneo, relacionMetas($atributoss->display_meta));

    //echo "<h1>".relacionMetas($atributoss->display_meta)."</h1>";

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

        //REALIZAMOS LA CONSULTA
        $cual = ".";

        $pos = strpos($datosForm[$i][1][$u][0], $cual);
        $busqueda = "";

        if($pos > 0){
          

          $busqueda = substr($datosForm[$i][1][$u][0], 0, $pos);//ESTO ERA SOLO PARA ELIMINAR EL . (REVISAR)

          //$busqueda = $datosForm[$i][1][$u][0];

          //echo "<h1>".$pos." ".$busqueda."</h1>";
        }else{
          $busqueda = $datosForm[$i][1][$u][0];

          //echo "<h3>".$busqueda."</h3>";
        }

        //echo "<h1>{$busqueda}</h1>";

        //echo "<h1>".$user->user_email."</h1>";

        $ultimaInscripcion = $wpdb->get_results("SELECT f.lead_id AS lead_id FROM {$wpdb->prefix}rg_lead_detail AS f WHERE f.form_id = ".$datosForm[$i][0]." AND value = '".$user->user_email."' ORDER BY f.id DESC LIMIT 1");

        //echo "<h1>SELECT f.lead_id AS lead_id FROM {$wpdb->prefix}rg_lead_detail AS f WHERE f.form_id = ".$datosForm[$i][0]." AND f.field_number = ".$busqueda." AND value = '".$user->user_email."' ORDER BY f.id DESC LIMIT 1</h1>";
        $idInscripcion = 0;
        foreach ($ultimaInscripcion as $keys) {
          //echo "jajajjaa";
          $idInscripcion = $keys->lead_id;
        }

        //echo "<h1>{$idInscripcion}</h1>";

        //$datosHijos = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}rg_lead_detail AS f WHERE f.form_id = ".$datosForm[$i][0]." AND f.field_number = ".$busqueda." ORDER BY f.id DESC LIMIT 1");
        //$datosHijos = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}rg_lead_detail AS f WHERE f.form_id = ".$datosForm[$i][0]." AND f.field_number = ".$busqueda." AND f.lead_id = ".$idInscripcion." ORDER BY f.id DESC LIMIT 1");
        $datosHijos = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}rg_lead_detail AS f WHERE f.form_id = ".$datosForm[$i][0]." AND f.lead_id = ".$idInscripcion." ");

        //echo "<h1> SELECT * FROM {$wpdb->prefix}rg_lead_detail AS f WHERE f.form_id = ".$datosForm[$i][0]." AND f.field_number = ".$busqueda." AND f.lead_id = ".$idInscripcion." ORDER BY f.id DESC LIMIT 1 </h1>";

        $queAtributo = "";
        foreach ($datosHijos as $atributoss) {
          //echo "<h1>SELECT * FROM wp_2_rg_lead_detail AS f WHERE f.form_id = ".$datosForm[$i][0]." AND f.field_number = ".$datosForm[$i][1][$u][0]." ORDER BY f.id DESC LIMIT 1  --> ".$atributoss->value."</h1>";
          $queAtributo = $atributoss->value;
          //echo "<h1> ".$queValor = devuelveLabel($atributoss->field_number)." ".$queAtributo."</h1>";



          $parametroE = $queAtributo;

          //echo "<h1>{$atributoss->field_number} {$parametroE}</h1>";

          //echo "<h1>".$atributoss->field_number."</h1>";

          //AQUI DEBEMOS LIMPIAR EL ID DEL PARAMETRO 17.6

          $cual = ".";
          $posst = strpos($atributoss->field_number, $cual);
          if($posst > 0){
            $field_numberA = "";
            $field_numberA = substr($atributoss->field_number, 0, $posst);
          }else{
            $field_numberA = $atributoss->field_number;
          }

          
          $parametroMinuscula1 = str_replace(" ", "_", devuelveLabel($field_numberA));
          $parametroMinuscula = strtolower(sanear_string($parametroMinuscula1));

          //echo "<h1>".$parametroMinuscula."</h1>";
          //$parametroMinuscula = "nombre";

          add_filter( 'gform_field_value_'.$parametroMinuscula, function( $content ) use($parametroE) {
            global $post;
              global $user;
              $queQuiero = "amigo";

              $seImporto++;

              //$parametro1 = str_replace(" ", "_", $atributoss->field_number);

              //$author_email = get_the_author_meta( $parametro1, $post->post_author );
              //$author_email = get_the_author_meta( $parametro1, $atributoss->meta_value );

              return $parametroE;
          });
        }


        // ----------  //



        

        //
        //CONSULTAMOS SI EL USUARIO TIENE ESTE DATO
        //$queHijo = $wpdb->get_results("SELECT sub.* FROM {$wpdb->prefix}metrics_users AS sub WHERE sub.user_id = ".$user->ID." AND sub.meta_key = '".$datosForm[$i][1][$u][1]."'");



        //PASANDO LA VARIABLE DE RESULTADO
        //$metas = str_replace(" ", "", $datosForm[$i][1][$u][1]);

        //$resultadoBusqueda = sanear_string($metas);

        /*
        if(count($queHijo) > 0){//AQUI PROCEDEMOS A ACTUALIZAR LA PAGINA
          $wpdb->update( 
                  'wp_metrics_users', 
                  array( 
                    'meta_value' => $queAtributo 
                  ), 
                  array( 
                    'user_id' => $user->ID,
                    'meta_key' => $resultadoBusqueda 
                    ) 
                );
        }else{//AQUI PROCEDEMOS A INSERTAR
          $wpdb->insert(
                'wp_metrics_users',
                array(
                    'user_id' => $user->ID,
                    'meta_key' => $resultadoBusqueda,
                    'meta_value' => $queAtributo
                  )
                );
        }
        */
      }
    }
  //}


    if($seImporto == 0){
      $seImporto = 2;
      //echo "<h1>----------------------------------------------> ".$seImporto."</h1>";
      formularioSub($seImporto);
    }
}

/*
**
  ESTE ES PARA TODOS LOS FORMULARIOS DE GRAVITY FORMS ANTES DE MOSTRARCE
**
*/

add_filter( 'gform_review_page', 'agregaModificaMetrics_final' );
function agregaModificaMetrics_final($arregloMetrics = ""){
  global $wpdb;
  global $user;

  //FORMULARIO
  global $miFormulario;

  //LO CAMBIAMOS A EL FORMULARIO NUEVO
  $miFormulario = 18;
  //CONSULTEMOS CUAL FUE EL ULTIMO FORMULARIO QUE ESTE USUARIO RELLENO
  $user = wp_get_current_user();

  $foRelleno = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}rg_lead_detail WHERE value = '".$user->user_email."' ORDER BY id DESC LIMIT 1 ");

  //echo "<h1>SELECT * FROM {$wpdb->prefix}rg_lead_detail WHERE value = {$user->user_email} ORDER BY id DESC LIMIT 1 </h1>";

  foreach ($foRelleno as $keyt) {
    $miFormulario = $keyt->form_id;
  }

  if($miFormulario == ""){
    $miFormulario = 18;
  }

  $seImporto = 0;

  //echo "<h1>{$miFormulario} {$wpdb->prefix}</h1>";

  $idUsuario = $user->ID;


  //FORMULARIOS QUE QUEREMOS RELACIONAR 
  $formulariosR = [];
  //array_push($formulariosR, 4);
  array_push($formulariosR, $miFormulario);
  //array_push($formulariosR, 8);

  //ARREGLO QUE RECORREREMOS SEGUN EL FORMULARIO
  $datosForm = [];


  //AQUI SACAMOS LA CONSULTA PARA TRAERNOS TODOS LOS CAMPOS 
  $parametrosForm = [];

  //return 'Esto es el contenido';

  //EN ESTE VAMOS A TRAER LOS DATOS DEL FORMULARIO
  //SACAMOS EL NOMBRE DEL USUARIO
  $nombreSuser = $wpdb->get_results("SELECT display_meta FROM {$wpdb->prefix}rg_form_meta WHERE form_id = {$miFormulario} ");

  if(count($nombreSuser) > 0){

  }else{
    //FORMULARIO APERTURA 2018 SUB
    $nombreSuser = $wpdb->get_results("SELECT display_meta FROM {$wpdb->prefix}rg_form_meta WHERE form_id = {$miFormulario2} ");
    /*
    if (count($nombreSuser) > 0) {}else{
      //FORMULARIO CLAUSURA 2017
      $nombreSuser = $wpdb->get_results("SELECT display_meta FROM {$wpdb->prefix}rg_form_meta WHERE form_id = {$miFormulario3} ");

      if (count($nombreSuser) > 0) {}else{
        //FORMULARIO CLAUSURA 2017 SUB
        $nombreSuser = $wpdb->get_results("SELECT display_meta FROM {$wpdb->prefix}rg_form_meta WHERE form_id = {$miFormulario4} ");
      }
    }
    */
  }

  //echo "SELECT value FROM wp_2_rg_lead_detail WHERE lead_id = ".$_GET['id']." AND form_id = 12 AND field_number = 1 ";

  $cualNombre = "";
  foreach ($nombreSuser as $atributoss) {
    //ARREGLO MOMENTANEO
    $momentaneo = [];
    //relacionMetas($con3['display_meta']);
    //echo "<br>/<br>";

    //echo "<h1>DISPLAY META -> ".$atributoss->display_meta."</h1>";

    array_push($momentaneo, $miFormulario);
    array_push($momentaneo, relacionMetas($atributoss->display_meta));

    //echo "<h1>".relacionMetas($atributoss->display_meta)."</h1>";

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

        //REALIZAMOS LA CONSULTA
        $cual = ".";

        $pos = strpos($datosForm[$i][1][$u][0], $cual);
        $busqueda = "";

        if($pos > 0){
          

          $busqueda = substr($datosForm[$i][1][$u][0], 0, $pos);//ESTO ERA SOLO PARA ELIMINAR EL . (REVISAR)

          //$busqueda = $datosForm[$i][1][$u][0];

          //echo "<h1>".$pos." ".$busqueda."</h1>";
        }else{
          $busqueda = $datosForm[$i][1][$u][0];

          //echo "<h3>".$busqueda."</h3>";
        }

        //echo "<h1>{$busqueda}</h1>";

        //echo "<h1>".$user->user_email."</h1>";

        $ultimaInscripcion = $wpdb->get_results("SELECT f.lead_id AS lead_id FROM {$wpdb->prefix}rg_lead_detail AS f WHERE f.form_id = ".$datosForm[$i][0]." AND value = '".$user->user_email."' ORDER BY f.id DESC LIMIT 1");

        //echo "<h1>SELECT f.lead_id AS lead_id FROM {$wpdb->prefix}rg_lead_detail AS f WHERE f.form_id = ".$datosForm[$i][0]." AND f.field_number = ".$busqueda." AND value = '".$user->user_email."' ORDER BY f.id DESC LIMIT 1</h1>";
        $idInscripcion = 0;
        foreach ($ultimaInscripcion as $keys) {
          //echo "jajajjaa";
          $idInscripcion = $keys->lead_id;
        }

        //echo "<h1>{$idInscripcion}</h1>";

        //$datosHijos = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}rg_lead_detail AS f WHERE f.form_id = ".$datosForm[$i][0]." AND f.field_number = ".$busqueda." ORDER BY f.id DESC LIMIT 1");
        //$datosHijos = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}rg_lead_detail AS f WHERE f.form_id = ".$datosForm[$i][0]." AND f.field_number = ".$busqueda." AND f.lead_id = ".$idInscripcion." ORDER BY f.id DESC LIMIT 1");
        $datosHijos = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}rg_lead_detail AS f WHERE f.form_id = ".$datosForm[$i][0]." AND f.lead_id = ".$idInscripcion." ");

        //echo "<h1> SELECT * FROM {$wpdb->prefix}rg_lead_detail AS f WHERE f.form_id = ".$datosForm[$i][0]." AND f.field_number = ".$busqueda." AND f.lead_id = ".$idInscripcion." ORDER BY f.id DESC LIMIT 1 </h1>";

        $queAtributo = "";
        foreach ($datosHijos as $atributoss) {
          //echo "<h1>SELECT * FROM wp_2_rg_lead_detail AS f WHERE f.form_id = ".$datosForm[$i][0]." AND f.field_number = ".$datosForm[$i][1][$u][0]." ORDER BY f.id DESC LIMIT 1  --> ".$atributoss->value."</h1>";
          $queAtributo = $atributoss->value;
          //echo "<h1> ".$queValor = devuelveLabel($atributoss->field_number)." ".$queAtributo."</h1>";



          $parametroE = $queAtributo;

          //echo "<h1>{$atributoss->field_number} {$parametroE}</h1>";

          //echo "<h1>".$atributoss->field_number."</h1>";

          //AQUI DEBEMOS LIMPIAR EL ID DEL PARAMETRO 17.6

          $cual = ".";
          $posst = strpos($atributoss->field_number, $cual);
          if($posst > 0){
            $field_numberA = "";
            $field_numberA = substr($atributoss->field_number, 0, $posst);
          }else{
            $field_numberA = $atributoss->field_number;
          }

          
          $parametroMinuscula1 = str_replace(" ", "_", devuelveLabel($field_numberA));
          $parametroMinuscula = strtolower(sanear_string($parametroMinuscula1));

          //echo "<h1>".$parametroMinuscula."</h1>";
          //$parametroMinuscula = "nombre";

          add_filter( 'gform_field_value_'.$parametroMinuscula, function( $content ) use($parametroE) {
            global $post;
              global $user;
              $queQuiero = "amigo";

              $seImporto++;

              //$parametro1 = str_replace(" ", "_", $atributoss->field_number);

              //$author_email = get_the_author_meta( $parametro1, $post->post_author );
              //$author_email = get_the_author_meta( $parametro1, $atributoss->meta_value );

              return $parametroE;
          });
        }
      }
    }
  //}


    if($seImporto == 0){
      $seImporto = 2;
      //echo "<h1>----------------------------------------------> ".$seImporto."</h1>";
      formularioSub($seImporto);
    }
}

//ESTA FUNCTION SE ENCARGA DE RECORRER OTRO FORMULARIO EN BUSCA DE INSCRIPCIONES PASADAS
function formularioSub($seImporto){
  global $wpdb;
  global $user;

  //FORMULARIO
  global $miFormulario;
  global $miFormulario2;
  global $miFormulario3;
  global $miFormulario4;

  $formularioPasado = $miFormulario2;

  if($seImporto == 2){
    $formularioPasado = $miFormulario2;
  }else if($seImporto == 3){
    $formularioPasado = $miFormulario3;
  }else if($seImporto == 4){
    $formularioPasado = $miFormulario4;
  }else if($seImporto == 5){
    $formularioPasado = 20;
  }

  $valorSeImporto = $seImporto; //ESTO ES PARA GUARDAR EL NUMERO QUE TRAE LA DB

  $seImporto = 0;

  //echo "<h1>{$miFormulario} {$wpdb->prefix}</h1>";

  $idUsuario = $user->ID;


  //FORMULARIOS QUE QUEREMOS RELACIONAR 
  $formulariosR = [];
  //array_push($formulariosR, 4);
  array_push($formulariosR, $miFormulario);
  //array_push($formulariosR, 8);

  //ARREGLO QUE RECORREREMOS SEGUN EL FORMULARIO
  $datosForm = [];


  //AQUI SACAMOS LA CONSULTA PARA TRAERNOS TODOS LOS CAMPOS 
  $parametrosForm = [];

  //return 'Esto es el contenido';

  //EN ESTE VAMOS A TRAER LOS DATOS DEL FORMULARIO
  //SACAMOS EL NOMBRE DEL USUARIO
  $nombreSuser = $wpdb->get_results("SELECT display_meta FROM {$wpdb->prefix}rg_form_meta WHERE form_id = {$formularioPasado} ");

  if(count($nombreSuser) > 0){

  }else{
    $nombreSuser = $wpdb->get_results("SELECT display_meta FROM {$wpdb->prefix}rg_form_meta WHERE form_id = {$formularioPasado} ");
  }

  //echo "SELECT value FROM wp_2_rg_lead_detail WHERE lead_id = ".$_GET['id']." AND form_id = 12 AND field_number = 1 ";

  $cualNombre = "";
  foreach ($nombreSuser as $atributoss) {
    //ARREGLO MOMENTANEO
    $momentaneo = [];
    //relacionMetas($con3['display_meta']);
    //echo "<br>/<br>";

    //echo "<h1>DISPLAY META -> ".$atributoss->display_meta."</h1>";

    array_push($momentaneo, $formularioPasado);
    array_push($momentaneo, relacionMetas($atributoss->display_meta));

    //echo "<h1>".relacionMetas($atributoss->display_meta)."</h1>";

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

        //REALIZAMOS LA CONSULTA
        $cual = ".";

        $pos = strpos($datosForm[$i][1][$u][0], $cual);
        $busqueda = "";

        if($pos > 0){
          

          $busqueda = substr($datosForm[$i][1][$u][0], 0, $pos);//ESTO ERA SOLO PARA ELIMINAR EL . (REVISAR)

          //$busqueda = $datosForm[$i][1][$u][0];

          //echo "<h1>".$pos." ".$busqueda."</h1>";
        }else{
          $busqueda = $datosForm[$i][1][$u][0];

          //echo "<h3>".$busqueda."</h3>";
        }

        //echo "<h1>{$busqueda}</h1>";

        //echo "<h1>".$user->user_email."</h1>";

        $ultimaInscripcion = $wpdb->get_results("SELECT f.lead_id AS lead_id FROM {$wpdb->prefix}rg_lead_detail AS f WHERE f.form_id = ".$datosForm[$i][0]." AND value = '".$user->user_email."' ORDER BY f.id DESC LIMIT 1");

        //echo "<h1>SELECT f.lead_id AS lead_id FROM {$wpdb->prefix}rg_lead_detail AS f WHERE f.form_id = ".$datosForm[$i][0]." AND f.field_number = ".$busqueda." AND value = '".$user->user_email."' ORDER BY f.id DESC LIMIT 1</h1>";
        $idInscripcion = 0;
        foreach ($ultimaInscripcion as $keys) {
          //echo "jajajjaa";
          $idInscripcion = $keys->lead_id;
        }

        //echo "<h1>{$idInscripcion}</h1>";

        //$datosHijos = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}rg_lead_detail AS f WHERE f.form_id = ".$datosForm[$i][0]." AND f.field_number = ".$busqueda." ORDER BY f.id DESC LIMIT 1");
        //$datosHijos = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}rg_lead_detail AS f WHERE f.form_id = ".$datosForm[$i][0]." AND f.field_number = ".$busqueda." AND f.lead_id = ".$idInscripcion." ORDER BY f.id DESC LIMIT 1");
        $datosHijos = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}rg_lead_detail AS f WHERE f.form_id = ".$datosForm[$i][0]." AND f.lead_id = ".$idInscripcion." ");

        //echo "<h1> SELECT * FROM {$wpdb->prefix}rg_lead_detail AS f WHERE f.form_id = ".$datosForm[$i][0]." AND f.field_number = ".$busqueda." AND f.lead_id = ".$idInscripcion." ORDER BY f.id DESC LIMIT 1 </h1>";

        $queAtributo = "";
        foreach ($datosHijos as $atributoss) {
          //echo "<h1>SELECT * FROM wp_2_rg_lead_detail AS f WHERE f.form_id = ".$datosForm[$i][0]." AND f.field_number = ".$datosForm[$i][1][$u][0]." ORDER BY f.id DESC LIMIT 1  --> ".$atributoss->value."</h1>";
          $queAtributo = $atributoss->value;
          //echo "<h1> ".$queValor = devuelveLabel($atributoss->field_number)." ".$queAtributo."</h1>";



          $parametroE = $queAtributo;

          //echo "<h1>{$atributoss->field_number} {$parametroE}</h1>";

          //echo "<h1>".$atributoss->field_number."</h1>";

          //AQUI DEBEMOS LIMPIAR EL ID DEL PARAMETRO 17.6

          $cual = ".";
          $posst = strpos($atributoss->field_number, $cual);
          if($posst > 0){
            $field_numberA = "";
            $field_numberA = substr($atributoss->field_number, 0, $posst);
          }else{
            $field_numberA = $atributoss->field_number;
          }

          
          $parametroMinuscula1 = str_replace(" ", "_", devuelveLabel($field_numberA));
          $parametroMinuscula = strtolower(sanear_string($parametroMinuscula1));

          //echo "<h1>".$parametroMinuscula."</h1>";
          //$parametroMinuscula = "nombre";

          add_filter( 'gform_field_value_'.$parametroMinuscula, function( $content ) use($parametroE) {
            global $post;
              global $user;
              $queQuiero = "amigo";

              $seImporto++;

              //$parametro1 = str_replace(" ", "_", $atributoss->field_number);

              //$author_email = get_the_author_meta( $parametro1, $post->post_author );
              //$author_email = get_the_author_meta( $parametro1, $atributoss->meta_value );

              return $parametroE;
          });
        }
      }
  }

  if($seImporto == 0){//VOLVEMOS A LLAMAR ESTA FUNCION
    $valorSeImporto++;
    //$seImporto = $valorSeImporto + 1;
    if($valorSeImporto <= 4){
      formularioSub($valorSeImporto);

    }else{
      //echo "<h1>----------------------------------------------> ".$valorSeImporto."</h1>";
    }
  }

}
