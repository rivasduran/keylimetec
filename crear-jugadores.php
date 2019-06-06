<?php
/*
 *
 * FUNCION PARA PODER INSERTAR UN JUGADOR NUEVO
 *
*/
function crearJugadorJ($userId, $datosJugador, $idRed = ""){
	//echo "<h1>Aqui si llega: ".$userId."</h1>";
	//VARIABLES NECESARIAS PARA EL INSERT
	date_default_timezone_set('UTC-5');
	$diaHoy = date("Y-m-d");

	#h:i:s
	$horaActual = date("H:i:s");
	$formatoDia = $diaHoy." ".$horaActual;
	global $wpdb;
	//echo "<h1>llegas {$wpdb->prefix}</h1>";
	//nombreCompleto
	//equipoJ
	//dorsalJ
	//nacionalidadJ
	//competicionJ
	//temporadaJ

	$nombreCompleto = $datosJugador[0];
	$equipoJ = $datosJugador[1];
	//COMENTAR ESTO YA QUE EN JLEAGUE SI ENVIA DIRECTAMENTE EL ID DEL EQUIPOS
	/*

	$idEquipo = $consultaJugador = $wpdb->get_results("SELECT pos.* FROM {$wpdb->prefix}posts AS pos WHERE pos.post_type = 'sp_team' AND pos.post_title = '".$equipoJ."'");
    foreach ($consultaJugador as $key) {
    	$equipoJ = $key->ID;
    }
    */
	$dorsalJ = $datosJugador[2];
	$nacionalidadJ = $datosJugador[3];
    $competicionJ = $datosJugador[4];
	$backCompeticion = $competicionJ;
	//echo "<h1>----> {$competicionJ}</h1>";
	$temporadaJ = $datosJugador[5];


    $wpdb->insert(
            "{$wpdb->prefix}df_tags",
            array(
                'tags'             =>  'JOSER',
                'value'      =>  $competicionJ
              )
            );

	//CONSULTO EL ID TANTO DE LA TEMPORADA COMO DE LA COMPETICION
    if(strpos($competicionJ, "-") === false){
    	$competicionJ2 = $wpdb->get_results("SELECT * FROM wp_{$idRed}_terms WHERE name = '".$competicionJ."'");
    	foreach ($competicionJ2 as $key) {
    		$competicionJ = $key->term_id;
    	}
    }

	//echo "<h1>Compericion = ".$competicionJ."</h1>";

	$temporadaJ2 = $wpdb->get_results("SELECT * FROM wp_{$idRed}_terms WHERE name = '".$temporadaJ."'");
	foreach ($temporadaJ2 as $key) {
		$temporadaJ = $key->term_id;
	}

    

	//echo "<h1>{$equipoJ} {$competicionJ} {$temporadaJ}</h1>";

	$nombreJugadorCorregir = str_replace(" ","-",$nombreCompleto);

	//
	//ID,post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count
//'','$nombreJugador','','publish','closed','closed','','$nombreJugadorCorregir','','','$formatoDia','$formatoDia','','0','$rutaLiga','0','sp_player','','0'


	//DB DONDE ESTA PARADO WORDPRESS
	//$tablaDB = "{$wpdb->prefix}posts";
	//TABLA DONDE SE MONTARA EL EVENTO
	$tablaDB = "wp_{$idRed}_posts";
	$wpdb->insert(
                $tablaDB,
                array(
                    'post_author'				=> $userId,
                    'post_date' 				=>	$formatoDia,
                    'post_date_gmt'				=>	$formatoDia,
                    'post_content'				=>	'',
                    'post_title'				=>	$nombreCompleto,
                    'post_excerpt'				=>	'',
                    'post_status'				=>	'publish',
                    'comment_status'			=>	'closed',
                    'ping_status'				=>	'closed',
                    'post_password'				=>	'',
                    'post_name'					=>	$nombreJugadorCorregir,
					'to_ping'					=>	'',
					'pinged'					=>	'',
					'post_modified'				=>	$formatoDia,
					'post_modified_gmt'			=>	$formatoDia,
					'post_content_filtered'		=>	'',
					'post_parent'				=>	'0',
					'guid'						=>	'',
					'menu_order'				=>	'0',
					'post_type'					=>	'sp_player',
					'post_mime_type'			=>	'',
					'comment_count'				=>	'0'
                  )
                );

	if(count($wpdb->insert_id) > 0){
		//MODIFICAMOS LA RUTA DEL JUGADOR
		$idJugador = $wpdb->insert_id;

		//echo "<h1>El id del jugador es: ".$idJugador."</h1>";

		//$rutaLiga = "http://localhost/primerplugin/?post_type=sp_player&#038;p=".$idJugador;//ESTO SE DEBE CORREGUIR CON LA RUTA REAL DEL CLIENTE
		//http://jleague.keylimetest.com/football-masculino/?post_type=sp_player&#038;p=
        $rutaLiga = "http://jleague.keylimetest.com/liga-jleague/?post_type=sp_player&#038;p=".$idJugador;
        if($idRed == 7){
            $rutaLiga = "http://jleague.keylimetest.com/liga-jleague/?post_type=sp_player&#038;p=".$idJugador;
        }else if($idRed == 8){
            $rutaLiga = "http://jleague.keylimetest.com/liga-pro/?post_type=sp_player&#038;p=".$idJugador;
        }else{
            $rutaLiga = "http://jleague.keylimetest.com/liga-jleague/?post_type=sp_player&#038;p=".$idJugador;
        }

		//MODIFICAMOS EL JUGADOR CREADO PARA PODER MODIFICAR SU PROPIA RUTA
		$wpdb->update( 
                  $tablaDB, 
                  array( 
                    'guid' => $rutaLiga 
                  ), 
                  array( 
                    'ID' => $idJugador
                    ) 
                );

		//YA CON LA RUTA O UR DEL JUGADOR PROCEDEMOS A REALIZAR TODAS LAS RELACIONES DEL CLIENTE

		//wp_postmeta
		#_edit_last  1

		$wpdb->insert(
                "wp_{$idRed}_postmeta",
                array(
                    'post_id' 				=>	$idJugador,
                    'meta_key'				=>	'_edit_last',
                    'meta_value'			=>	'1'
                  )
                );

		#sp_twitter  ''
		$wpdb->insert(
                "wp_{$idRed}_postmeta",
                array(
                    'post_id' 				=>	$idJugador,
                    'meta_key'				=>	'sp_twitter',
                    'meta_value'			=>	''
                  )
                );

		#sp_number  Numero de la camiseta
		$wpdb->insert(
                "wp_{$idRed}_postmeta",
                array(
                    'post_id' 				=>	$idJugador,
                    'meta_key'				=>	'sp_number',
                    'meta_value'			=>	$dorsalJ
                  )
                );

		#sp_metrics  a:2:{s:6:"height";s:0:"";s:6:"weight";s:0:"";}
		$metricasJugador = 'a:2:{s:6:"height";s:0:"";s:6:"weight";s:0:"";}';

		$wpdb->insert(
                "wp_{$idRed}_postmeta",
                array(
                    'post_id' 				=>	$idJugador,
                    'meta_key'				=>	'sp_metrics',
                    'meta_value'			=>	$metricasJugador
                  )
                );

		//DEBEMOS CONSULTAR LA TEMPORADA Y LA COMPETICION DE ESTE EQUIPO
		// ----> ESTE ES PARA PODER VER QUE CATEGORIAS SON wp_term_taxonomy
		//ESTAMOS BUSCANDO EL ID DEL POST 72
		//SELECT rela.*, term.*, tax.* FROM wp_term_relationships AS rela , wp_terms AS term, wp_term_taxonomy AS tax WHERE rela.object_id = 72 AND term.term_id = rela.term_taxonomy_id AND term.term_id = tax.term_id

		#sp_leagues  a:2:{i:3;a:1:{i:2;s:3:"146";}i:0;a:1:{i:2;s:1:"1";}}
					       //a:2:{i:10;a:1:{i:11;s:4:"3432";}i:0;a:1:{i:11;s:1:"1";}}
		//a:2:{i:$competicion;a:1:{i:$temporada;s:4:"$equipoJ";}i:0;a:1:{i:$temporada;s:1:"1";}}

		//AQUI DEBEMOS CONSEGUIR LA COMPETICION Y TEMPORADA DEL EQUIPO
		//$competicionJ
		//$temporadaJ
		
        //REVISAREMOS SI SON 2 O SOLO ES UNA
        if(strpos($backCompeticion, "-") != false){
            $competi = explode(" - ", $backCompeticion);

            $backTemporada = $competicionJ;

            for ($isst=0; $isst <= count($competi); $isst++) { 

                $temporadaJ2 = $wpdb->get_results("SELECT * FROM wp_{$idRed}_terms WHERE name = '".$competi[$isst]."'");
                foreach ($temporadaJ2 as $key) {
                    $competicionJ = $key->term_id;
                }

                $ligaDeljugador = 'a:2:{i:'.$competicionJ.';a:1:{i:'.$temporadaJ.';s:4:"'.$equipoJ.'";}i:0;a:1:{i:'.$temporadaJ.';s:1:"1";}}';

                //$ligaDeljugador = 'a:1:{i:0;a:1:{i:'.$temporadaJ.';s:1:"1";}}';
                $wpdb->insert(
                        "wp_{$idRed}_postmeta",
                        array(
                            'post_id'               =>  $idJugador,
                            'meta_key'              =>  'sp_leagues',
                            'meta_value'            =>  $ligaDeljugador
                          )
                        );
            }



        }else{
            $ligaDeljugador = 'a:2:{i:'.$competicionJ.';a:1:{i:'.$temporadaJ.';s:4:"'.$equipoJ.'";}i:0;a:1:{i:'.$temporadaJ.';s:1:"1";}}';

            $wpdb->insert(
                    "wp_{$idRed}_postmeta",
                    array(
                        'post_id'               =>  $idJugador,
                        'meta_key'              =>  'sp_leagues',
                        'meta_value'            =>  $ligaDeljugador
                      )
                    );
        }

		#sp_statistics  a:2:{i:3;a:2:{i:0;a:8:{s:5:"goals";s:0:"";s:7:"assists";s:0:"";s:11:"yellowcards";s:0:"";s:8:"redcards";s:0:"";s:11:"appearances";s:0:"";s:8:"winratio";s:0:"";s:9:"drawratio";s:0:"";s:9:"lossratio";s:0:"";}i:2;a:8:{s:5:"goals";s:0:"";s:7:"assists";s:0:"";s:11:"yellowcards";s:0:"";s:8:"redcards";s:0:"";s:11:"appearances";s:0:"";s:8:"winratio";s:0:"";s:9:"drawratio";s:0:"";s:9:"lossratio";s:0:"";}}i:0;a:2:{i:0;a:8:{s:5:"goals";s:0:"";s:7:"assists";s:0:"";s:11:"yellowcards";s:0:"";s:8:"redcards";s:0:"";s:11:"appearances";s:0:"";s:8:"winratio";s:0:"";s:9:"drawratio";s:0:"";s:9:"lossratio";s:0:"";}i:2;a:8:{s:5:"goals";s:0:"";s:7:"assists";s:0:"";s:11:"yellowcards";s:0:"";s:8:"redcards";s:0:"";s:11:"appearances";s:0:"";s:8:"winratio";s:0:"";s:9:"drawratio";s:0:"";s:9:"lossratio";s:0:"";}}}
		$statistJugador = 'a:2:{i:3;a:2:{i:0;a:8:{s:5:"goals";s:0:"";s:7:"assists";s:0:"";s:11:"yellowcards";s:0:"";s:8:"redcards";s:0:"";s:11:"appearances";s:0:"";s:8:"winratio";s:0:"";s:9:"drawratio";s:0:"";s:9:"lossratio";s:0:"";}i:2;a:8:{s:5:"goals";s:0:"";s:7:"assists";s:0:"";s:11:"yellowcards";s:0:"";s:8:"redcards";s:0:"";s:11:"appearances";s:0:"";s:8:"winratio";s:0:"";s:9:"drawratio";s:0:"";s:9:"lossratio";s:0:"";}}i:0;a:2:{i:0;a:8:{s:5:"goals";s:0:"";s:7:"assists";s:0:"";s:11:"yellowcards";s:0:"";s:8:"redcards";s:0:"";s:11:"appearances";s:0:"";s:8:"winratio";s:0:"";s:9:"drawratio";s:0:"";s:9:"lossratio";s:0:"";}i:2;a:8:{s:5:"goals";s:0:"";s:7:"assists";s:0:"";s:11:"yellowcards";s:0:"";s:8:"redcards";s:0:"";s:11:"appearances";s:0:"";s:8:"winratio";s:0:"";s:9:"drawratio";s:0:"";s:9:"lossratio";s:0:"";}}}';

		$wpdb->insert(
                "wp_{$idRed}_postmeta",
                array(
                    'post_id' 				=>	$idJugador,
                    'meta_key'				=>	'sp_leagues',
                    'meta_value'			=>	$statistJugador
                  )
                );

		#slide_template  default

		$wpdb->insert(
                "wp_{$idRed}_postmeta",
                array(
                    'post_id' 				=>	$idJugador,
                    'meta_key'				=>	'slide_template',
                    'meta_value'			=>	'default'
                  )
                );

		#sp_nationality  ''

		$wpdb->insert(
                "wp_{$idRed}_postmeta",
                array(
                    'post_id' 				=>	$idJugador,
                    'meta_key'				=>	'sp_nationality',
                    'meta_value'			=>	''
                  )
                );

		#sp_current_team  dependiendo del ID del equipo

		$wpdb->insert(
                "wp_{$idRed}_postmeta",
                array(
                    'post_id' 				=>	$idJugador,
                    'meta_key'				=>	'sp_current_team',
                    'meta_value'			=>	$equipoJ
                  )
                );

		#sp_team  dependiendo del ID del equipo

		$wpdb->insert(
                "wp_{$idRed}_postmeta",
                array(
                    'post_id' 				=>	$idJugador,
                    'meta_key'				=>	'sp_team',
                    'meta_value'			=>	$equipoJ
                  )
                );


		#RELACIONANDO EL JUGADOR CON LA TEMPORADA Y CON EL EQUIPO
        //df_tags
        $wpdb->insert(
            "{$wpdb->prefix}df_tags",
            array(
                'tags'             =>  'JOSER 2',
                'value'      =>  $competicionJ
              )
            );


        if(strpos($backCompeticion, "-") != false){
            $competi = explode(" - ", $backCompeticion);

            $backTemporada = $competicionJ;

            for ($isst=0; $isst <= count($competi); $isst++) { 

                $temporadaJ2 = $wpdb->get_results("SELECT * FROM wp_{$idRed}_terms WHERE name = '".$competi[$isst]."'");
                foreach ($temporadaJ2 as $key) {
                    $competicionJ = $key->term_id;
                }

                $wpdb->insert(
                        "wp_{$idRed}_term_relationships",
                        array(
                            'object_id'             =>  $idJugador,
                            'term_taxonomy_id'      =>  $competicionJ,
                            'term_order'            =>  '0'
                          )
                        );

                $wpdb->insert(
                        "{$wpdb->prefix}df_tags",
                        array(
                            'tags'             =>  'JOSER 3',
                            'value'      =>  $competicionJ
                          )
                        );

            }

        }else{
    		$wpdb->insert(
                    "wp_{$idRed}_term_relationships",
                    array(
                        'object_id'				=>	$idJugador,
                        'term_taxonomy_id'		=>	$competicionJ,
                        'term_order'			=>	'0'
                      )
                    );
        }

		$wpdb->insert(
                "wp_{$idRed}_term_relationships",
                array(
                    'object_id'				=>	$idJugador,
                    'term_taxonomy_id'		=>	$temporadaJ,
                    'term_order'			=>	'0'
                  )
                );

		//echo "<h1>".$competicionJ." ".$temporadaJ."</h1>";
	}else{
		//echo "<h1>No se creo el jugador adecuadamente, por favor contactar al administrador</h1>";
	}
}