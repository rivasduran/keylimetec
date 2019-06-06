<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

//CONECTOR CON LA DB
$conect = mysqli_connect("localhost","jleaguep_jluser","kRw[1vPswl8","jleaguep_dbjl17");

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");

/*
**
	DATOS A DESCARGAR DEL FORMULARIO
**
*/
//$postForm = $_POST['formulario'];
$postForm = $_GET['formulario'];

//SACAMOS EL ID DE LA RED
$pos_red = "";
$id_cat = "";//ESTE ES EL ID DE LA CATEGORIA
$nombre_categoria = "";

$redes1 = "SELECT * FROM wp_df_red WHERE form = ".$postForm;
$redes2 = mysqli_query($conect, $redes1);
while ($redes3 = mysqli_fetch_array($redes2)) {
	$pos_red = $redes3['red'];
	//ASIGNAMOS EL ID DE LA CATEGORIA
	$id_cat = $redes3['product_cat'];

	$cats1 = "SELECT * FROM wp_terms WHERE term_id = '{$id_cat}'";
	$cats2 = mysqli_query($conect, $cats1);
	while ($cats3 = mysqli_fetch_array($cats2)) {
		$nombre_categoria = $cats3['name'];
	}
}

//TAMBIEN DEBEMOS REVISAR SI ESTE FORMULARIO CUENTA O NO CON LOS TAGS NECESARIOS PARA SER DE PAGO O GRATUITO


// Add some data
						 
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C1', $nombre_categoria);
//ARRAY DONDE GUARDAMOS TODAS LAS VARIABLES DE JUGADORES.
#$arregloJugadores = array();
#$equipoJugadores = array();

//ESTRUCTURANDO EL ARCHIVO PARA SU DESCARGA

$posicion2 = 2;

/*
**
	FUNCTION PARA SABER CUAL ES LA LETRA
**
*/
function letras($numeroletra){
	$devuelve = "A";
	if($numeroletra == 1){ $devuelve = "A"; }
	if($numeroletra == 2){ $devuelve = "B"; }
	if($numeroletra == 3){ $devuelve = "C"; }
	if($numeroletra == 4){ $devuelve = "D"; }
	if($numeroletra == 5){ $devuelve = "E"; }
	if($numeroletra == 6){ $devuelve = "F"; }
	if($numeroletra == 7){ $devuelve = "G"; }
	if($numeroletra == 8){ $devuelve = "H"; }
	if($numeroletra == 9){ $devuelve = "I"; }
	if($numeroletra == 10){ $devuelve = "J"; }
	if($numeroletra == 11){ $devuelve = "K"; }
	if($numeroletra == 12){ $devuelve = "L"; }
	if($numeroletra == 13){ $devuelve = "M"; }
	if($numeroletra == 14){ $devuelve = "N"; }
	if($numeroletra == 15){ $devuelve = "O"; }
	if($numeroletra == 16){ $devuelve = "P"; }
	if($numeroletra == 17){ $devuelve = "Q"; }
	if($numeroletra == 18){ $devuelve = "R"; }
	if($numeroletra == 19){ $devuelve = "S"; }
	if($numeroletra == 20){ $devuelve = "T"; }
	if($numeroletra == 21){ $devuelve = "U"; }
	if($numeroletra == 22){ $devuelve = "V"; }
	if($numeroletra == 23){ $devuelve = "W"; }
	if($numeroletra == 24){ $devuelve = "X"; }
	if($numeroletra == 25){ $devuelve = "Y"; }
	if($numeroletra == 26){ $devuelve = "Z"; }

	return $devuelve;
}

/*
**
	FUNCTION QUE TRADUCE LOS ATRIBUTOS DEL FORMULARIOS
**
*/
//FUNCTION PARA BUSCAR RELACION ENTRE ID Y META KEY
function relacionMetas($cualVariable){
	$obj = json_decode($cualVariable);//AQUI CREAMOS EL OBJETO JSON
	//CREAMOS ARREGLO MOMENTANEO
	$momentaneo = [];
	for($i = 0; $i < count($obj->{'fields'});$i++){//AQUI LO RECORREMOS
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



/*
**
	SELECCIONANDO EL FORMULARIO Y ARMANDOLO
**
*/
//FORMULARIOS QUE QUEREMOS RELACIONAR 
$formulariosR = [];
array_push($formulariosR, $postForm);

//ARREGLO QUE RECORREREMOS SEGUN EL FORMULARIO
$datosForm = [];
//AQUI SACAMOS LA CONSULTA PARA TRAERNOS TODOS LOS CAMPOS 
$parametrosForm = [];

//REALIZAMOS LA CONSULTA
for($i = 0; $i < count($formulariosR);$i++){
	$con1 = "SELECT display_meta FROM wp_rg_form_meta WHERE form_id = ".$formulariosR[$i];
	$con2 = mysqli_query($conect, $con1);
	while($con3 = mysqli_fetch_array($con2)){
		//ARREGLO MOMENTANEO
		$momentaneo = [];
		array_push($momentaneo, $formulariosR[$i]);
		array_push($momentaneo, relacionMetas($con3['display_meta']));
		//GUARDANDO LA DATA EN EL ARREGLO DE FORMULARIO
		array_push($datosForm, $momentaneo);
		//VACIANDO ARREGLO MOMENTANEO
		$momentaneo = [];
	}
}

//AQUI HACEMOS LA FUNCION DONDE BUSCAREMOS EL PARAMETRO DECEADO
function buscaNombre($datosForm, $formulario, $busqueda){
	for ($i=0; $i < count($datosForm); $i++) { 
		if($formulario == $datosForm[$i][0]){
			//echo "<h1> Es del formulario -->".$formulario." ".$datosForm[$i][0]."</h1><br>";

			for ($u=0; $u < count($datosForm[$i][1]); $u++) { 

				if($busqueda == $datosForm[$i][1][$u][0]){
					//echo "<h1>".$datosForm[$i][1][$u][1]."</h1>";

					//DEVOLVEMOS EL NOMBRE QUE ES
					return $datosForm[$i][1][$u][1];
				}
				//echo $datosForm[$i][0]." ".$datosForm[$i][1][$u][0]." ".$datosForm[$i][1][$u][1]."<br>";
			}

		}
	}
}

//lIMPIANDO EL TEXTO
function sanear_string($string)
{
 
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
**
	EXTRAEMOS DATA DEL USUARIO
**
*/
//HASTA ESTE PUNTO YA TENEMOS TODA LA INFO ESTRUCTURADA DE QUE SON LOS FORMULARIOS Y QUE CONTIENEN

//VARIABLE PARA PODER RECOGER TODOS LOS DATOS DEL USUARIO
$totalUsuario = [];


//CONSULTAMOS SI ESTE FORMULARIO TIENE RELACION CON ALGUN PRODUCTO
//$postForm;
$fcon1 = "SELECT f.*, d.product AS product, d.product_hijo AS product_hijo, d.value AS value FROM wp_df_tags AS d, wp_rg_form AS f WHERE d.form = {$postForm} AND d.form = f.id AND f.is_active = '1' AND f.is_trash = '0' ";
$fcon2 = mysqli_query($conect, $fcon1);
$fcon3 = mysqli_fetch_array($fcon2);

$producto_asignado = 0;

//AQUI VALIDAMOS SI ESTE FORMULARIO CUENTA CON ALGUN PRODUCTO ASIGNADO
if(count($fcon3) > 0){
	$producto_asignado++;
	//ARMAMOS LA CONSULTA
	$query1 = "SELECT u.ID, u.user_email, p.ID as idP FROM wp_users AS u, wp_posts AS p WHERE p.post_author = u.ID AND p.post_status = 'wc-processing' AND p.post_type = 'shop_order' ";
	$query2 = mysqli_query($conect, $query1);
	while($query3 = mysqli_fetch_array($query2)){
		//echo "<h3>".$query3['user_email']."</h3> <br>";

		//YA CON EL ID DE LA TRANSACCION QUE REALIZO EL CLIENTE PROCEDEMOS A CONSULTAR CUAL FUE EL ID DE TRANSACCION EN EL FORMULARIO
		$id_post = $query3['idP'];

		//CONSULTAMOS EL EN LAS METRICAS CUAL ES EL FORMULARIO
		$nombreProducto = "";
		$idTransaccion = "";
		$order_item_id = "";//ESTE ES PARA CONSULTAR LUEGO LA TABLA wp_woocommerce_order_itemmeta

		$ligaJ = "";
		$competicionJ = "";
		$temporadaJ = "";


		$conM1 = "SELECT oi.*, (SELECT m1.meta_value FROM wp_woocommerce_order_itemmeta AS m1 WHERE oi.order_item_id = m1.order_item_id AND m1.meta_key = 'Liga') AS liga, (SELECT m2.meta_value FROM wp_woocommerce_order_itemmeta AS m2 WHERE oi.order_item_id = m2.order_item_id AND m2.meta_key = 'Competicion') AS competicion, (SELECT m3.meta_value FROM wp_woocommerce_order_itemmeta AS m3 WHERE oi.order_item_id = m3.order_item_id AND m3.meta_key = 'Temporada') AS temporada, (SELECT m4.meta_value FROM wp_woocommerce_order_itemmeta AS m4 WHERE oi.order_item_id = m4.order_item_id ORDER BY m4.meta_id DESC LIMIT 1) AS idTransaccion FROM wp_woocommerce_order_items AS oi WHERE oi.order_id = {$id_post} AND oi.order_item_type = 'line_item' ";
		//echo "<h1>{$conM1}</h1>";
		$conM2 = mysqli_query($conect, $conM1);
		while($conM3 = mysqli_fetch_array($conM2)){
			$order_item_id = $conM3['order_item_id'];
			$nombreProducto = $conM3['order_item_name'];

			$idTransaccion = $conM3['idTransaccion'];
			//echo "<h1>---------------> {$idTransaccion}</h1>";
			$ligaJ = $conM3['liga'];
			$competicionJ = $conM3['competicion'];
			$temporadaJ = $conM3['temporada'];
		}

		//echo "<h1> {$nombreProducto} ({$idTransaccion}) {$ligaJ} {$competicionJ} {$temporadaJ} </h1>";

		for($i = 0; $i < count($formulariosR);$i++){		
			//form_id	
			//$con1 = "SELECT lead_id, form_id, field_number FROM wp_2_rg_lead_detail  WHERE form_id = ".$formulariosR[$i];

			$con1 = "SELECT attr.* FROM  wp_rg_lead_detail AS attr WHERE attr.value = '".$query3['user_email']."' AND form_id = ".$formulariosR[$i]." AND attr.lead_id = '{$idTransaccion}' ";

			//echo "<h3>".$con1."</h3>";
			$con2 = mysqli_query($conect, $con1);
			while($con3 = mysqli_fetch_array($con2)){
				//ARREGLO MOMENTANEO
				$momentaneo = [];

				//echo "<br>".$con3['lead_id']." ".$con3['form_id']." ".$con3['field_number']."<br>";

				//AQUI CULMINAMOS SELECCIONANDO TODOS LOS DATOS DE ESTE USUARIO EN ESTE FORMULARIO
				$t1 = "SELECT field_number, value FROM wp_rg_lead_detail WHERE lead_id = ".$con3['lead_id'];
				$t2 = mysqli_query($conect, $t1);
				while($t3 = mysqli_fetch_array($t2)){
					//echo $t3['field_number']." -> ".$t3['value']."<br>";

					//CREANDO OTRO ARREGLO PARA MANTENER EL ORDEN
					$uub3 = [];

					array_push($uub3, $t3['field_number']);
					array_push($uub3, $t3['value']);
					array_push($uub3, $formulariosR[$i]);

					//GUARDANDO LA INFO EN NUESTRAS VARIABLES MOMENTANEAS
					array_push($momentaneo, $uub3);
					//array_push($momentaneo, $t3['value']);


					//
					$uub3 = [];
				}

				//AQUI GUARDAMOS TODO EN EL ARRAY DEL USUARIO
				$momentaneoU = [];
				array_push($momentaneoU, $query3['user_email']);
				array_push($momentaneoU, $momentaneo);
				array_push($momentaneoU, $query3['ID']);

				//GUARDAMOS
				array_push($totalUsuario, $momentaneoU);

				$momentaneoU = [];

				//FIN ARREGLO MOMENTANEO
				$momentaneo = [];
			}
		}	
	}
}else{//SI NO CUENTA CON UN PRODUCTO ASIGNADO PROCEDEMOS A LA CONSULTA DE TODOS LOS USUARIOS
	//ARMAMOS LA CONSULTA
	$query1 = "SELECT ID, user_email FROM wp_users";
	$query2 = mysqli_query($conect, $query1);
	while($query3 = mysqli_fetch_array($query2)){
		//echo "<h3>".$query3['user_email']."</h3> <br>";
		for($i = 0; $i < count($formulariosR);$i++){		
			//form_id	
			//$con1 = "SELECT lead_id, form_id, field_number FROM wp_2_rg_lead_detail  WHERE form_id = ".$formulariosR[$i];

			$con1 = "SELECT attr.* FROM  wp_rg_lead_detail AS attr WHERE attr.value = '".$query3['user_email']."' AND form_id = ".$formulariosR[$i];

			//echo "<h3>".$con1."</h3>";
			$con2 = mysqli_query($conect, $con1);
			while($con3 = mysqli_fetch_array($con2)){
				//ARREGLO MOMENTANEO
				$momentaneo = [];

				//echo "<br>".$con3['lead_id']." ".$con3['form_id']." ".$con3['field_number']."<br>";

				//AQUI CULMINAMOS SELECCIONANDO TODOS LOS DATOS DE ESTE USUARIO EN ESTE FORMULARIO
				$t1 = "SELECT field_number, value FROM wp_rg_lead_detail WHERE lead_id = ".$con3['lead_id'];
				$t2 = mysqli_query($conect, $t1);
				while($t3 = mysqli_fetch_array($t2)){
					//echo $t3['field_number']." -> ".$t3['value']."<br>";

					//CREANDO OTRO ARREGLO PARA MANTENER EL ORDEN
					$uub3 = [];

					array_push($uub3, $t3['field_number']);
					array_push($uub3, $t3['value']);
					array_push($uub3, $formulariosR[$i]);

					//GUARDANDO LA INFO EN NUESTRAS VARIABLES MOMENTANEAS
					array_push($momentaneo, $uub3);
					//array_push($momentaneo, $t3['value']);


					//
					$uub3 = [];
				}

				//AQUI GUARDAMOS TODO EN EL ARRAY DEL USUARIO
				$momentaneoU = [];
				array_push($momentaneoU, $query3['user_email']);
				array_push($momentaneoU, $momentaneo);
				array_push($momentaneoU, $query3['ID']);

				//GUARDAMOS
				array_push($totalUsuario, $momentaneoU);

				$momentaneoU = [];

				//FIN ARREGLO MOMENTANEO
				$momentaneo = [];
			}
		}
	}
}

/*
**
	IMPRIMIENDO EN EL EXCEL EL FORMULARIO
**
*/
//$posicion2 = 1;
$numeroletra = 0;
for ($i=0; $i < count($datosForm); $i++) { 
	//
	for ($u=0; $u < count($datosForm[$i][1]); $u++) { 
		$letra = letras($numeroletra);
		$atributo = $datosForm[$i][1][$u][1];

		if($atributo != "Tarjeta crédito" && $atributo != "Datos de Juego" && $atributo != "Metodo de pago" && $atributo != "" && $atributo != "Acepto todos los terminos, condiciones y reglamentos de la J League detallados en el el archivo de reglamento." && $atributo != "sexo" && $atributo != "Bloque HTML" && $atributo != "Inscripción de jugador"){
			$numeroletra++;
			//echo $datosForm[$i][0]." ".$datosForm[$i][1][$u][0]." ".$datosForm[$i][1][$u][1]."<br>";
			

			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($letra.$posicion2, $atributo);
	        								//->setCellValue(letras($numeroletra).$posicion2, $datosForm[$i][1][$u][1]);
			$posicion3 = $posicion2;
			$posicion3++;


			//IMPRIMIREMOS TODO LO QUE TENGA QUE VER CON ESTE ATRIBUTO

			$numeroletra2 = 0;
			for ($ij=0; $ij < count($totalUsuario); $ij++) { 
				//AQUI RECORREMOS LOS DATOS DEL USUARIO

				for ($uj=0; $uj < count($totalUsuario[$ij][1]); $uj++) { 
					//MODIFICAREMOS LO QUE DECEAMOS BUSCAR PARA PODER TRAER EL RESULTADO ADECUADO

					$cual = ".";

					$pos = strpos($totalUsuario[$ij][1][$uj][0], $cual);

					if($pos > 0){
						

						$busqueda = substr($totalUsuario[$ij][1][$uj][0], 0, $pos);

						//echo "<h1>".$pos." ".$busqueda."</h1>";
					}else{
						$busqueda = $totalUsuario[$ij][1][$uj][0];
					}

					$resultadoBusqueda = buscaNombre($datosForm, $totalUsuario[$ij][1][$uj][2], $busqueda);

					if($atributo == $resultadoBusqueda){


						$numeroletra2++;
						$letra2 = letras($numeroletra2);
						$atributo2 = utf8_encode($totalUsuario[$ij][1][$uj][1]);

						//
						if($atributo == "Elige tu equipo"){

							$atributo2 = utf8_encode($totalUsuario[$ij][1][$uj][1]);

							$equipos1 = "SELECT * FROM wp_{$pos_red}_posts WHERE post_status = 'publish' AND post_type = 'sp_team' AND ID = '".$atributo2."' ";
							$equipos2 = mysqli_query($conect,$equipos1);
							//$equipos3 = mysqli_fetch_array($equipos2);

							while ($equipos3 = mysqli_fetch_array($equipos2)) {
								$valor1 = $equipos3['post_title'];

								$objPHPExcel->setActiveSheetIndex(0)
				        					->setCellValue($letra.$posicion3, $valor1);
							}
							/*
							$objPHPExcel->setActiveSheetIndex(0)
				        					->setCellValue($letra.$posicion3, $atributo2);
							*/
						}else if($atributo == "Plan de pago"){//SACAMOS EL METODO DE PAGO REAL
							$atributo2 = utf8_encode($totalUsuario[$ij][1][$uj][1]);

							$idProducto = explode(",", $atributo2);

							//AGARRAMOS EL SEGUNDO PRODUCTO QUE SERIA LA VARIACION DEL PROMERO
							$atributo2 = $idProducto[1];

							$equipos1 = "SELECT * FROM wp_posts WHERE ID = '".$atributo2."' ";
							$equipos2 = mysqli_query($conect,$equipos1);
							//$equipos3 = mysqli_fetch_array($equipos2);

							while ($equipos3 = mysqli_fetch_array($equipos2)) {
								$valor1 = $equipos3['post_title'];

								$objPHPExcel->setActiveSheetIndex(0)
				        					->setCellValue($letra.$posicion3, $valor1);
							}
						}else{
							$objPHPExcel->setActiveSheetIndex(0)
				        				->setCellValue($letra.$posicion3, $atributo2);	
						}

					}
				}

				$posicion3++;
			}


		}
	}
}

$posicion2++;

/*
**
	IMPRIMIENDO DATOS DEL FORMULARIO
**
*/
/*
$numeroletra = 0;
for ($i=0; $i < count($totalUsuario); $i++) { 
	//AQUI RECORREMOS LOS DATOS DEL USUARIO

	for ($u=0; $u < count($totalUsuario[$i][1]); $u++) { 
		//MODIFICAREMOS LO QUE DECEAMOS BUSCAR PARA PODER TRAER EL RESULTADO ADECUADO

		$cual = ".";

		$pos = strpos($totalUsuario[$i][1][$u][0], $cual);

		if($pos > 0){
			

			$busqueda = substr($totalUsuario[$i][1][$u][0], 0, $pos);

			//echo "<h1>".$pos." ".$busqueda."</h1>";
		}else{
			$busqueda = $totalUsuario[$i][1][$u][0];
		}

		$resultadoBusqueda = buscaNombre($datosForm, $totalUsuario[$i][1][$u][2], $busqueda);

		//PASANDO LA VARIABLE DE RESULTADO
		$metas = str_replace(" ", "", $resultadoBusqueda);

		$resultadoBusqueda = sanear_string($metas);

		//AQUI DECIDIMOS QUE DATOS NO QUEREMOS MOSTRAR
		if($resultadoBusqueda == "Transporte$10.00mensuales." || $resultadoBusqueda == "Trimestreapagar" || $resultadoBusqueda == "Metododepago" || $resultadoBusqueda == "Seleccionemetododepago" || $resultadoBusqueda == "Tarjetacredito" || $resultadoBusqueda == "Total" || $resultadoBusqueda == "BloqueHTML" || $resultadoBusqueda == "Precio" || $resultadoBusqueda == "Porfavordetallarenquegrupodeseainscribirse,diayhora:" || $resultadoBusqueda == "" || $resultadoBusqueda == "Deportes" || $resultadoBusqueda == "futbol" || $resultadoBusqueda == "DeportesGrupales" || $resultadoBusqueda == "Datosdeportes" || $resultadoBusqueda == "DeporteIndividual" || $resultadoBusqueda == "" ){

		}else{
			//HASTA AQUI LOS DATOS ORGANIZADOS POR USUARIO
			//echo $totalUsuario[$i][1][$u][0]." ".$resultadoBusqueda." ".utf8_encode($totalUsuario[$i][1][$u][1])."   form-> ".$totalUsuario[$i][1][$u][2]."<br>";
			$numeroletra++;
			$letra = letras($numeroletra);
			$atributo = utf8_encode($totalUsuario[$i][1][$u][1]);

			$objPHPExcel->setActiveSheetIndex(0)
        				->setCellValue($letra.$posicion2, $atributo);
			
		}
	}

	$posicion2++;
}
*/

$posicion2++;

$posicion2++;
/*
$objPHPExcel->setActiveSheetIndex(0)
        	->setCellValue('A'.$posicion2, 'Joser jajaja');
*/
/*
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$posicion2, 'NOMBRE')
        ->setCellValue('B'.$posicion2, 'APELLIDO')
        ->setCellValue('C'.$posicion2, 'APELLIDO MATERNO')
        ->setCellValue('D'.$posicion2, 'APODO')
        ->setCellValue('E'.$posicion2, 'EDAD')
        ->setCellValue('F'.$posicion2, 'EMAIL')
        ->setCellValue('G'.$posicion2, 'TELEFONO')
        ->setCellValue('H'.$posicion2, 'SEGURO MEDICO')
        ->setCellValue('I'.$posicion2, 'NUMERO DE POLIZA')
        ->setCellValue('J'.$posicion2, 'NUMERO QUE DESEA EN CAMISETA')
        ->setCellValue('K'.$posicion2, 'NOMBRE QUE DESEA EN CAMISETA')
        ->setCellValue('L'.$posicion2, 'POSICION DESEADA')
        ->setCellValue('M'.$posicion2, 'OTRA POSICION DESEADA')
        ->setCellValue('N'.$posicion2, 'TALLA CAMISA')
        ->setCellValue('O'.$posicion2, 'TALLA PANTALON')
        ->setCellValue('P'.$posicion2, '');
*/
//SELECCION DE EQUIPOS 




$posicion2 = $posicion2 + 5;

//MASCULINO B




// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle($nombre_categoria);


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

//QUITAMOS LOS ESPACIOS
$nombre_categoria2 = str_replace(" ", "-", $nombre_categoria);

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$nombre_categoria2.'.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
