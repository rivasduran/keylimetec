<?php
//TABLAS PARA SPORTPRESS

/*
**
	SABER EL ROLL DE UN USUARIO
**
*/
//"SELECT * FROM wp_usermeta WHERE user_id = '".$userid."' AND meta_key = 'wp_2_capabilities' ";
//a:1:{s:9:"sp_player";b:1;}


//CANTIDAD DE POST
/*
$cuantasPublic1 = "SELECT *  FROM wp_3_posts ORDER BY ID DESC";
$cuantasPublic2 = mysqli_query($conect,$cuantasPublic1);
$cuantasPublic3 = mysqli_fetch_array($cuantasPublic2);
$cantidadPost = $cuantasPublic3['ID'];

$cantidadPost = $cantidadPost + 1;
$cantidadPost2 = $cantidadPost + 1;

*/

/*
**
	EQUIPOS
**
*/
// ---> wp_posts <---
//DUENO DE EQUIPO
// ---> post_author = '".$userid."'  AND post_type  = 'sp_team' <---php

//CREAREMOS EL EQUIPO
//
// --> PARAMETROS QUE NECESITAREMOS PARA CREAR EL EQUIPO <-- //
//
//
//$userid == id usuario
//$formatoDia

//date_default_timezone_set('UTC-5');
//$diaHoy = date("Y-m-d");
#h:i:s
//$horaActual = date("H:i:s");
//$formatoDia = $diaHoy." ".$horaActual;

//$nombreEquipo == SE DEBE CONSULTAR EN DB DEL FORMULARIO RELLENADO
//$nombreEquipoCorregir == ES EL MISMO NOMBRE PERO SIN ESPACIOS : str_replace(" ","-",$nombreEquipoC3['value']);
//
//$rutaEquipo ==  "http://jleague.keylimetest.com/football-femenino/?post_type=sp_team&#038;p=".$cantidadPost;
//
//CREAMOS EL INSERT EQUIPOS
//
//"INSERT INTO wp_2_posts (ID,post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count) VALUES (NULL,'$userid','$formatoDia','$formatoDia','','$nombreEquipo','','publish','closed','closed','','$nombreEquipoCorregir','','','$formatoDia','$formatoDia','','0','$rutaEquipo','0','sp_team','','0')"
//
//
//
//
//
//

//  --> CREAMOS LA LISTA DE JUGADORES <-- //
//
//CREAMOS EL INSERT LISTA
//
//$rutaLiga = "http://jleague.keylimetest.com/football-masculino/?post_type=sp_list&#038;p=".$cantidadPost2;
//
//"INSERT INTO wp_2_posts (ID,post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count) VALUES (NULL,'$userid','$formatoDia','$formatoDia','','$nombreEquipo','','publish','closed','closed','','$nombreEquipoCorregir','','','$formatoDia','$formatoDia','','0','$rutaLiga','0','sp_list','','0')";
//
//
//
// -->  RELACIONAMOS LA LIGA  <-- //
//
#PRUEBA INSERTANDO DATOS EN
//
#_edit_last    1
//$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost','_edit_last','1')";
//$insertarParametro2 = mysqli_query($conect,$insertarParametro);
#sp_url   ''
//$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost','sp_url','')";
//$insertarParametro2 = mysqli_query($conect,$insertarParametro);
#sp_abbreviation    ''
//$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost','sp_abbreviation','')";
//$insertarParametro2 = mysqli_query($conect,$insertarParametro);
#sp_colors     a:0:{}
//$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost','sp_colors','a:0:{}')";
//$insertarParametro2 = mysqli_query($conect,$insertarParametro);


#sp_twitter     ''
//$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost','sp_twitter','')";
//$insertarParametro2 = mysqli_query($conect,$insertarParametro);
#slide_template    default
//$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost','slide_template','default')";
//$insertarParametro2 = mysqli_query($conect,$insertarParametro);
/* BLOQUEADO PARA QUE NO SE AGREGE A MASCULINO A YA QUE ESTO NOS JENERA PROBLEMAS */
#sp_table    8 porque estamos en masculino a
//$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost','sp_table','8')";
//$insertarParametro2 = mysqli_query($conect,$insertarParametro);
/*BLOQUEADO PARA QUE NO NOS AGREGE A NINGUNA LISTA YA QUE NOS JENERA PROBLEMAS
#sp_list    34 porque estamos en Mejores jugadores
//$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost','sp_list','34')";
//$insertarParametro2 = mysqli_query($conect,$insertarParametro);
*/
#sp_list de la lista de jugadores que acabamos de crear  $idListajugadores
//$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost','sp_list','".$idListajugadores."')";
//$insertarParametro2 = mysqli_query($conect,$insertarParametro);

#INSERTANDO DATOS DE LA LIGA 
#_edit_last 1
//$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost2','_edit_last','1')";
//$insertarParametro2 = mysqli_query($conect,$insertarParametro);
#sp_format list
//$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost2','sp_format','list')";
//$insertarParametro2 = mysqli_query($conect,$insertarParametro);
#sp_columns a:3:{i:0;s:1:"0";i:1;s:1:"0";i:2;s:1:"0";}
//$variableLarga = 'a:3:{i:0;s:1:"0";i:1;s:1:"0";i:2;s:1:"0";}';
//$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost2','sp_columns','".$variableLarga."')";
//$insertarParametro2 = mysqli_query($conect,$insertarParametro);
#sp_caption ''
//$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost2','sp_caption','')";
//$insertarParametro2 = mysqli_query($conect,$insertarParametro);
#sp_team este es el id del equipo anterior
//$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost2','sp_team','".$cantidadPost."')";
//$insertarParametro2 = mysqli_query($conect,$insertarParametro);
#sp_era all
//$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost2','sp_era','all')";
//$insertarParametro2 = mysqli_query($conect,$insertarParametro);
#sp_grouping 0
//$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost2','sp_grouping','0')";
//$insertarParametro2 = mysqli_query($conect,$insertarParametro);
#sp_orderby number
//$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost2','sp_orderby','number')";
//$insertarParametro2 = mysqli_query($conect,$insertarParametro);
#sp_order ASC
//$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost2','sp_order','ASC')";
//$insertarParametro2 = mysqli_query($conect,$insertarParametro);
#sp_select auto
//$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost2','sp_select','auto')";
//$insertarParametro2 = mysqli_query($conect,$insertarParametro);
#sp_adjustments  a:0:{}
//$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost2','sp_adjustments','a:0:{}')";
//$insertarParametro2 = mysqli_query($conect,$insertarParametro);
#sp_players   a:0:{}
//$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost2','sp_players','a:0:{}')";
//$insertarParametro2 = mysqli_query($conect,$insertarParametro);
#slide_template  default
//$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost2','slide_template','default')";
//$insertarParametro2 = mysqli_query($conect,$insertarParametro);
#sp_player  0
//$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost2','sp_player','0')";
//$insertarParametro2 = mysqli_query($conect,$insertarParametro);

/* INSERTANDO VALORES DE LA RELACION DEL EQUIPO */
//$cuantasPublic1 = "SELECT *  FROM wp_2_posts ORDER BY ID DESC";
//$cuantasPublic2 = mysqli_query($conect,$cuantasPublic1);
//$cuantasPublic3 = mysqli_fetch_array($cuantasPublic2);
#RELACIONANDO EL EQUIPO CON LA TEMPORADA Y LA LIGA
//$ligas = "INSERT INTO wp_2_term_relationships (object_id,term_taxonomy_id,term_order) VALUES ('".$cantidadPost."', '2', '0'), ('".$cantidadPost."', '3', '0')";
//$ligas2 = mysqli_query($conect,$ligas);
#RELACIONANDO LA LISTA DE JUGADORES CON LA TEMPORADA Y LA LIGA
//$ligas = "INSERT INTO wp_2_term_relationships (object_id,term_taxonomy_id,term_order) VALUES ('".$cantidadPost2."', '2', '0'), ('".$cantidadPost2."', '3', '0')";
//$ligas2 = mysqli_query($conect,$ligas);
#AQUI CONSULTAMOS LA CANTIDAD DE JUGADORES Y LA AGREGAMOS A LA TABLA PARA
//$nombreJugadores1 = "SELECT * FROM wp_rg_lead_detail WHERE lead_id = '".$useridNuevo."' AND field_number = '19'";
//$nombreJugadores2 = mysqli_query($conect,$nombreJugadores1);
//$nombreJugadores3 = mysqli_fetch_array($nombreJugadores2);
//$cadena1 = $nombreJugadores3['value'];
//$cadena3 = '"';
//$pos = 0;
//$cantidadDebucles = 1;

$aPost = array();
while($pos = strpos($cadena1,$cadena3,$pos)){
	array_push($aPost,$pos);
	$pos++;
}
for($i = 0; $i<count($aPost);$i++){
	if($cantidadDebucles%2==0){
		$valordeI = $i - 1;

		$partida = $aPost[$valordeI] + 1;
		$final = $aPost[$i];

		$longitud = $final - $partida;

		#AQUI SE INSERTAN LOS JUGADORES EN LAS TABLAS
		#echo substr($cadena1,$partida,$longitud)."<br>";

		$nombreJugador = substr($cadena1,$partida,$longitud);
		$nombreJugadorCorregir = str_replace(" ","-",$nombreJugador);

		#SACANDO CUENTA DE CUANTAS PUBLICACIONES HAY EN LA DB PARA ASIGNARLE UNA AL EQUIPO
		
		$cuantasPublic12 = "SELECT *  FROM wp_2_posts ORDER BY ID DESC";

		$cuantasPublic22 = mysqli_query($conect,$cuantasPublic12);
		$cuantasPublic33 = mysqli_fetch_array($cuantasPublic22);
		$cantidadPost223 = $cuantasPublic33['ID'];

		$cantidadPost3 = $cantidadPost223 + 1;

		#ruta del post
		$rutaEquipo = "http://jleague.keylimetest.com/football-masculino/?post_type=sp_player&#038;p=".$cantidadPost3;

		#CREANDO JUGADORES 
		$creaLista1 = "INSERT INTO wp_2_posts (ID,post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count) VALUES (NULL,'$userid','$formatoDia','$formatoDia','','$nombreJugador','','publish','closed','closed','','$nombreJugadorCorregir','','','$formatoDia','$formatoDia','','0','$rutaLiga','0','sp_player','','0')";

		$creaLista2 = mysqli_query($conect,$creaLista1);

		#_edit_last  1
		$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost3','_edit_last','1')";

		$insertarParametro2 = mysqli_query($conect,$insertarParametro);
		#sp_twitter  ''
		$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost3','sp_twitter','')";
		$insertarParametro2 = mysqli_query($conect,$insertarParametro);
		#sp_number  Numero de la camiseta
		$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost3','sp_number','')";

		$insertarParametro2 = mysqli_query($conect,$insertarParametro);
		#sp_metrics  a:2:{s:6:"height";s:0:"";s:6:"weight";s:0:"";}
		$metricasJugador = 'a:2:{s:6:"height";s:0:"";s:6:"weight";s:0:"";}';

		$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost3','sp_metrics','".$metricasJugador."')";

		$insertarParametro2 = mysqli_query($conect,$insertarParametro);
		#sp_leagues  a:2:{i:3;a:1:{i:2;s:3:"146";}i:0;a:1:{i:2;s:1:"1";}}
		$ligaDeljugador = 'a:2:{i:3;a:1:{i:2;s:3:"'.$cantidadPost.'";}i:0;a:1:{i:2;s:1:"1";}}';

		$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost3','sp_leagues','".$ligaDeljugador."')";

		$insertarParametro2 = mysqli_query($conect,$insertarParametro);
		#sp_statistics  a:2:{i:3;a:2:{i:0;a:8:{s:5:"goals";s:0:"";s:7:"assists";s:0:"";s:11:"yellowcards";s:0:"";s:8:"redcards";s:0:"";s:11:"appearances";s:0:"";s:8:"winratio";s:0:"";s:9:"drawratio";s:0:"";s:9:"lossratio";s:0:"";}i:2;a:8:{s:5:"goals";s:0:"";s:7:"assists";s:0:"";s:11:"yellowcards";s:0:"";s:8:"redcards";s:0:"";s:11:"appearances";s:0:"";s:8:"winratio";s:0:"";s:9:"drawratio";s:0:"";s:9:"lossratio";s:0:"";}}i:0;a:2:{i:0;a:8:{s:5:"goals";s:0:"";s:7:"assists";s:0:"";s:11:"yellowcards";s:0:"";s:8:"redcards";s:0:"";s:11:"appearances";s:0:"";s:8:"winratio";s:0:"";s:9:"drawratio";s:0:"";s:9:"lossratio";s:0:"";}i:2;a:8:{s:5:"goals";s:0:"";s:7:"assists";s:0:"";s:11:"yellowcards";s:0:"";s:8:"redcards";s:0:"";s:11:"appearances";s:0:"";s:8:"winratio";s:0:"";s:9:"drawratio";s:0:"";s:9:"lossratio";s:0:"";}}}
		$statistJugador = 'a:2:{i:3;a:2:{i:0;a:8:{s:5:"goals";s:0:"";s:7:"assists";s:0:"";s:11:"yellowcards";s:0:"";s:8:"redcards";s:0:"";s:11:"appearances";s:0:"";s:8:"winratio";s:0:"";s:9:"drawratio";s:0:"";s:9:"lossratio";s:0:"";}i:2;a:8:{s:5:"goals";s:0:"";s:7:"assists";s:0:"";s:11:"yellowcards";s:0:"";s:8:"redcards";s:0:"";s:11:"appearances";s:0:"";s:8:"winratio";s:0:"";s:9:"drawratio";s:0:"";s:9:"lossratio";s:0:"";}}i:0;a:2:{i:0;a:8:{s:5:"goals";s:0:"";s:7:"assists";s:0:"";s:11:"yellowcards";s:0:"";s:8:"redcards";s:0:"";s:11:"appearances";s:0:"";s:8:"winratio";s:0:"";s:9:"drawratio";s:0:"";s:9:"lossratio";s:0:"";}i:2;a:8:{s:5:"goals";s:0:"";s:7:"assists";s:0:"";s:11:"yellowcards";s:0:"";s:8:"redcards";s:0:"";s:11:"appearances";s:0:"";s:8:"winratio";s:0:"";s:9:"drawratio";s:0:"";s:9:"lossratio";s:0:"";}}}';

		$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost3','sp_leagues','".$statistJugador."')";

		$insertarParametro2 = mysqli_query($conect,$insertarParametro);
		#slide_template  default

		$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost3','slide_template','default')";

		$insertarParametro2 = mysqli_query($conect,$insertarParametro);
		#sp_nationality  ''

		$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost3','sp_nationality','')";

		$insertarParametro2 = mysqli_query($conect,$insertarParametro);
		#sp_current_team  dependiendo del ID del equipo

		$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost3','sp_current_team','".$cantidadPost."')";

		$insertarParametro2 = mysqli_query($conect,$insertarParametro);
		#sp_team  dependiendo del ID del equipo

		$insertarParametro = "INSERT INTO wp_2_postmeta (meta_id,post_id,meta_key,meta_value) VALUES (NULL,'$cantidadPost3','sp_team','".$cantidadPost."')";

		$insertarParametro2 = mysqli_query($conect,$insertarParametro);

		#RELACIONANDO EL JUGADOR CON LA TEMPORADA Y CON EL EQUIPO

		$ligas = "INSERT INTO wp_2_term_relationships (object_id,term_taxonomy_id,term_order) VALUES ('".$cantidadPost3."', '2', '0'), ('".$cantidadPost3."', '3', '0')";

		$ligas2 = mysqli_query($conect,$ligas);
	}
	$cantidadDebucles++;
}


//CREAR JUGADORES
//"INSERT INTO wp_2_posts (ID,post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count) VALUES (NULL,'$userid','$formatoDia','$formatoDia','','$nombreJugador','','publish','closed','closed','','$nombreJugadorCorregir','','','$formatoDia','$formatoDia','','0','$rutaLiga','0','sp_player','','0')";





?>






DDCPTY


<?php

//[gravityform id="11" title="true" description="true"] 
				        	//echo do_shortcode ('[gravityform id="11" title="true" description="true"] '); 
				        	$id_or_title = "12";
				        	gravity_form( $id_or_title, $display_title = false, $display_description = false, $display_inactive = false, $field_values = null, $ajax = false, $tabindex, $echo = true );