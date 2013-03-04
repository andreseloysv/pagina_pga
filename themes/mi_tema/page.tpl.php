<!DOCTYPE html>

<?php
drupal_flush_all_caches();
db_query("DELETE FROM {cache};");

echo('<link rel="stylesheet" href="http://www.compensa.com.ve/drupal/themes/mi_tema/menu_ie/css/style.css" type="text/css" media="screen, projection"/>

	<!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="css/ie.css" media="screen" />
    <![endif]-->

<script type="text/javascript" src="http://www.compensa.com.ve/drupal/themes/mi_tema/menu_ie/js/jquery-1.3.1.min.js"></script>	
<script type="text/javascript" language="javascript" src="http://www.compensa.com.ve/drupal/themes/mi_tema/menu_ie/js/jquery.dropdownPlain.js"></script>');


global $user;


$clases = array('class="leaf first active-trail"', 'class="expanded"', 'class="leaf"', 'class="expanded last"', 'class="leaf first"', 'class="leaf last"', 'class="leaf active-trail"', 'class="collapsed"', 'class="expanded active-trail"', 'class="active"', 'class="leaf last active-trail"');


$menu = menu_tree($menu_name = 'navigation');


$menu = str_replace('</a><ul class="menu">', '</a><div class="megaborder" style="opacity: 1; display: none;"><ul class="sub_menu">', $menu);

$menu = str_replace('</ul></li">', '</ul></div></li">', $menu);


$bodytag = str_replace($clases, '', $menu);

$bodytag = str_replace('class="menu"', 'class="dropdown"', $bodytag);

$grupos_id = array();
$flag_borrar = true;
$query = db_query("SELECT nodo2.nid nid, nodo1.title
FROM  `dr_node` nodo1,  `dr_node` nodo2
WHERE (nodo1.title = nodo2.title) and nodo1.type='grupos' and nodo2.type='page'");
while ($result = db_fetch_object($query)) {
    if ((!$user->uid)) {
	$bodytag = str_replace('<li ><a href="/drupal/?q=node/' . $result->nid . '" title="' . $result->title . '">' . $result->title . '</a></li>', '', $bodytag);
    } else {
	foreach ($user->og_groups as $key => $value) {

	    $query_grupo = db_query("SELECT  nid  FROM {node} WHERE type='grupos' and title ='" . $value . "'");
	    while ($result_grupo = db_fetch_object($query_grupo)) {
		$node = node_load($result_grupo->nid);
		$grupos_id[] = $result_grupo->nid;
	    }
	    if ($result_grupo->nid == $result->nid) {
		$flag_borrar = false;
	    }
	}
	if ($flag_borrar) {
	    $bodytag = str_replace('<li ><a href="/drupal/?q=node/' . $node->nid . '" title="' . $value['title'] . '" >' . $value['title'] . '</a></li>', '', $bodytag);
	}
    }
}

function get_user_browser() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $ub = '';
    if (preg_match('/MSIE/i', $u_agent)) {
	$ub = "ie";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
	$ub = "firefox";
    } elseif (preg_match('/Safari/i', $u_agent)) {
	$ub = "safari";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
	$ub = "chrome";
    } elseif (preg_match('/Flock/i', $u_agent)) {
	$ub = "flock";
    } elseif (preg_match('/Opera/i', $u_agent)) {
	$ub = "opera";
    }

    return $ub;
}

$navegador = get_user_browser();



$pieces = explode("/", $_SERVER["REQUEST_URI"]);
$nodo_actual = $pieces[2];

include_once 'estilo.php';
?>


    <head>
	<?php print $head ?> 
        <title><?php print $head_title ?></title>

	<?php print $styles ?>
	<?php
	?>
	<?php print $scripts ?>

        <!--[if lt IE 7]>   
	<?php print phptemplate_get_ie_styles(); ?>
        <![endif]-->
    </head>
    <body<?php print phptemplate_body_class($left, $right); ?>>

        <!-- Layout -->
        <div id="header-region" class="clear-block">
            <div id="barra_menu_superior">
		<div id="barra_busqueda">
		    <input type="text" width="400px" placeholder="Buscar">
		</div>
                <div id="barra_menu_superior_centrada">
		    <?php echo($bodytag);
		    ?>
                </div>
            </div>

	    <?php
	    $lista_archivos_baner_ie = $lista_archivos;
	    asort($lista_archivos_baner_ie);
	    include 'banner_ie.php';

	    if ($navegador == 'ie') {
		echo('');
	    } else if ($navegador == "ie1") {
		?>

    	    <div class="sp-slideshow">
		    <?php
		    foreach ($lista_archivos as $key => $archivo) {
			if (($key + 1) == 1) {
			    echo('<input id="button-' . ($key + 1) . '" type="radio" name="radio-set" class="sp-selector-' . ($key + 1) . '" checked="checked" onclick="setContador(this)" />');
			} else {
			    echo('<input id="button-' . ($key + 1) . '" type="radio" name="radio-set" class="sp-selector-' . ($key + 1) . '"  onclick="setContador(this)"/>');
			}
			echo('<label for="button-' . ($key + 1) . '" class="button-label-' . ($key + 1) . '"></label>');
		    }

		    echo('<input type="hidden" name="max_images" id="max_images" value="' . (max(array_keys($lista_archivos)) + 1) . '">');

		    asort($lista_archivos);
		    ?>
    		<div class="sp-content">
    		    <div class="sp-parallax-bg"></div>
    		    <ul class="sp-slider clearfix">
			    <?php
			    foreach ($lista_archivos as $archivo) {
				$nombre = explode(".", $archivo);
				$nombre = $nombre[0];
				echo ('<li><img src="/drupal/themes/mi_tema/images/imagenes_banner/' . $archivo . '" alt="' . $nombre . '" /></li>');
			    }
			    ?>

    		    </ul>
    		</div><!-- sp-content -->

    	    </div><!-- sp-slideshow -->
		<?php
	    }
	    ?>
        </div>
	<div id="wrapper">
            <div id="container" class="clear-block">
		<div id="wrapper_barra_inferior">
		    <div id="barra_inferior">
			<div class="articulo-a">
			    <?php
			    $node = 0;
			    global $user;
			    $encuesta_usuario = false;
			    $pieces = explode("/", $_GET['q']);
			    if ($pieces[1] != null) {
				echo('<div style="font-size: small;">');
				$query = db_query("SELECT og.group_nid nid FROM dr_og_ancestry og, dr_node n WHERE og.nid = n.nid and n.nid =" . $pieces[1]);
				while ($result = db_fetch_object($query)) {
				    $og_nid = $result->nid;
				    if ($result->nid == NULL) {
					break;
				    }
				}
				$query = db_query("SELECT  MAX(n.nid) nid FROM dr_og_ancestry og, dr_node n WHERE og.nid=n.nid and n.type='poll' and og.group_nid=" . $og_nid);
				while ($result = db_fetch_object($query)) {
				    if ($result->nid == NULL) {
					break;
				    }
				    $node = node_load($result->nid);
				    $node = poll_view($node, 'full');
				    echo($node->content['body']['#value']);
				    echo($node->title);
//						echo($node->results);
//						echo($node->vote);
						echo($node->content['body']['#value']);
						var_dump($node);
						exit();
//				    echo("<h2>" . $node->title . "</h2>");
				    echo("" . $node->title . "");
				    $encuesta_usuario = true;
				}
				echo('</div>');
			    }

			    if (!$encuesta_usuario) {
				$query = db_query("SELECT MAX(nid) nidd  FROM {node} WHERE type ='articuloa'");
				while ($result = db_fetch_object($query)) {
				    $node = node_load($result->nidd);
				}
				if ($node->type == 'articuloa') {
				    echo('<img src="/drupal/' . $node->field_imagen_articulo_a[0]['filepath'] . '">');
				    print($node->body);
//				    echo '<h2>' . $node->title . '</h2>';
				    echo '' . $node->title . '';
				}
			    }
			    ?>
			    <?php if ($articulo_a): print $articulo_a ?><?php endif; ?>
			</div>
			<div class="articulo-b">
			    <?php
			    $articulob_usuario = false;
			    $pieces = explode("/", $_GET['q']);
			    if ($pieces[1] != null) {
				echo('<div style="font-size: small;">');
				$query = db_query("SELECT og.group_nid nid FROM dr_og_ancestry og, dr_node n WHERE og.nid = n.nid and n.nid =" . $pieces[1]);
				while ($result = db_fetch_object($query)) {
				    $og_nid = $result->nid;
				    if ($result->nid == NULL) {
					break;
				    }
				}
				$query = db_query("SELECT  MAX(n.nid) nid FROM dr_og_ancestry og, dr_node n WHERE og.nid=n.nid and n.type='articulob' and og.group_nid=" . $og_nid);
				while ($result = db_fetch_object($query)) {
				    if ($result->nid == NULL) {
					break;
				    }

				    $node = node_load($result->nid);
				    if ($node->field_imagen_articulo_b != null) {
					echo('<img src="/drupal/' . $node->field_imagen_articulo_b[0]['filepath'] . '">');
				    } else {
					echo $node->body;
				    }
//				    echo '<h2>' . $node->title . '</h2>';
				    echo '' . $node->title . '';
				    $articulob_usuario = true;
				}
				echo('</div>');
			    }

			    if (!$articulob_usuario) {
				$query = db_query("SELECT max(n.nid) nid
FROM   dr_node n, dr_og_ancestry og
WHERE n.nid  NOT IN (SELECT  og.nid
                   FROM   dr_og_ancestry og ) and type='articulob'");
				while ($result = db_fetch_object($query)) {
				    $node = node_load($result->nid);
				}
				if ($node->type == 'articulob') {
				    if ($node->field_imagen_articulo_b != null) {
					echo('<img src="/drupal/' . $node->field_imagen_articulo_b[0]['filepath'] . '">');
				    } else {
					echo $node->body;
				    }
//				    echo '<h2>' . $node->title . '</h2>';
				    echo '' . $node->title . '';
				}
			    }
			    ?>
			    <?php if ($articulo_b): ?><?php print $articulo_b ?><?php endif; ?>
			</div>
			<div class="articulo-b">
			    <?php
			    $articulob_usuario = false;
			    $pieces = explode("/", $_GET['q']);
			    if ($pieces[1] != null) {
				echo('<div style="font-size: small;">');
				$query = db_query("SELECT og.group_nid nid FROM dr_og_ancestry og, dr_node n WHERE og.nid = n.nid and n.nid =" . $pieces[1]);
				while ($result = db_fetch_object($query)) {
				    $og_nid = $result->nid;
				    if ($result->nid == NULL) {
					break;
				    }
				}
				$query = db_query("SELECT  MAX(n.nid) nid FROM dr_og_ancestry og, dr_node n WHERE og.nid=n.nid and n.type='articulob' and og.group_nid=" . $og_nid);
				while ($result = db_fetch_object($query)) {
				    if ($result->nid == NULL) {
					break;
				    }

				    $node = node_load($result->nid);
				    if ($node->field_imagen_articulo_b != null) {
					echo('<img src="/drupal/' . $node->field_imagen_articulo_b[0]['filepath'] . '">');
				    } else {
					echo $node->body;
				    }
//				    echo '<h2>' . $node->title . '</h2>';
				    echo '' . $node->title . '';
				    $articulob_usuario = true;
				}
				echo('</div>');
			    }

			    if (!$articulob_usuario) {
				$query = db_query("SELECT max(n.nid) nid
FROM   dr_node n, dr_og_ancestry og
WHERE n.nid  NOT IN (SELECT  og.nid
                   FROM   dr_og_ancestry og ) and type='articulob'");
				while ($result = db_fetch_object($query)) {
				    $node = node_load($result->nid);
				}
				if ($node->type == 'articulob') {
				    if ($node->field_imagen_articulo_b != null) {
					echo('<img src="/drupal/' . $node->field_imagen_articulo_b[0]['filepath'] . '">');
				    } else {
					echo $node->body;
				    }
//				    echo '<h2>' . $node->title . '</h2>';
				    echo '' . $node->title . '';
				}
			    }
			    ?>
			    <?php if ($articulo_b): ?><?php print $articulo_b ?><?php endif; ?>
			</div>
			<div class="articulo-c">
			    <?php
			    $articuloc_usuario = false;
			    $pieces = explode("/", $_GET['q']);
			    if ($pieces[1] != null) {
				echo('<div style="font-size: small;">');
				$query = db_query("SELECT og.group_nid nid FROM dr_og_ancestry og, dr_node n WHERE og.nid = n.nid and n.nid =" . $pieces[1]);
				while ($result = db_fetch_object($query)) {
				    $og_nid = $result->nid;
				    if ($result->nid == NULL) {
					break;
				    }
				}
				$query = db_query("SELECT  MAX(n.nid) nid FROM dr_og_ancestry og, dr_node n WHERE og.nid=n.nid and n.type='articuloc' and og.group_nid=" . $og_nid);
				while ($result = db_fetch_object($query)) {
				    if ($result->nid == NULL) {
					break;
				    }
				    $node = node_load($result->nid);
				    if ($node->field_imagen_articulo_c != null) {
					echo('<img src="/drupal/' . $node->field_imagen_articulo_c[0]['filepath'] . '">');
				    } else {
					echo $node->body;
				    }
//				    echo '<h2>' . $node->title . '</h2>';
				    echo '' . $node->title . '';
				    $articuloc_usuario = true;
				}
				echo('</div>');
			    }

			    if (!$articuloc_usuario) {
				$query = db_query("SELECT max(n.nid) nid
FROM   dr_node n, dr_og_ancestry og
WHERE n.nid  NOT IN (SELECT  og.nid
                   FROM   dr_og_ancestry og ) and type='articuloc'");
				while ($result = db_fetch_object($query)) {
				    $node = node_load($result->nid);
				}
				if ($node->type == 'articuloc') {
				    if ($node->field_imagen_articulo_c != null) {
					echo('<img src="/drupal/' . $node->field_imagen_articulo_c[0]['filepath'] . '">');
				    } else {
					echo $node->body;
				    }
//				    echo '<h2>' . $node->title . '</h2>';
				    echo '' . $node->title . '';
				}
			    }
			    ?>
			    <?php if ($articulo_c): ?><?php print $articulo_c ?><?php endif; ?>
			</div>
		    </div>
		</div>

                <div id="login">
		    <?php
		    global $user;
		    if (!$user->uid) {
			echo('<button id="boton_inicio_sesion">Inicia Sesion</button>');
			echo('<button id="boton_registro">Registrate</button>');
		    }
		    ?>
                </div>
                <div id="header">
                    <div id="logo-floater">
			<?php
			if ($logo || $site_title) {
			    print '<h1><a href="' . check_url($front_page) . '" title="' . $site_title . '">';
			    if ($logo) {
				print '<img src="' . check_url($logo) . '" alt="' . $site_title . '" id="logo" />';
			    }
			    print $site_html . '</a></h1>';
			}
			?>
                    </div> 
		    <?php if (isset($primary_links)) : ?>
			<?php print theme('links', $primary_links, array('class' => 'links primary-links')) ?>
		    <?php endif; ?>
		    <?php if (isset($secondary_links)) : ?>
			<?php print theme('links', $secondary_links, array('class' => 'links secondary-links')) ?>
		    <?php endif; ?>
                </div> <!-- /header -->
                <div id="marco">
                    <div id="wrapper_barra_central">
                        <div id="barra_central">
			    <?php if ($_GET['q'] == "node") { ?>
    			    <div id="sidebar-left" class="sidebar">
				    <?php //if ($search_box):           ?>
    				<div class="block block-theme">
					<?php // print $search_box          ?>

					<?php
					global $user;
					$encuesta_usuario = false;
					$pieces = explode("/", $_GET['q']);
					if ($pieces[1] != null) {
					    $query = db_query("SELECT og.group_nid nid FROM dr_og_ancestry og, dr_node n WHERE og.nid = n.nid and n.nid =" . $pieces[1]);
					    while ($result = db_fetch_object($query)) {
						$og_nid = $result->nid;
						if ($result->nid == NULL) {
						    break;
						}
					    }
					    $query = db_query("SELECT  n.nid nid FROM dr_og_ancestry og, dr_node n WHERE og.nid=n.nid and n.type='poll' and og.group_nid=" . $og_nid);
					    while ($result = db_fetch_object($query)) {
						if ($result->nid == NULL) {
						    break;
						}
						$node = node_load($result->nid);
						$node = poll_view($node, 'full');
						echo($node->title);
						echo($node->results);
						echo($node->links);
						echo($node->vote);
						echo($node->content['body']['#value']);
						var_dump($node);
						$encuesta_usuario = true;
					    }
					}
					?>
					<?php if (($left) && (!$encuesta_usuario)): ?>
					    <?php print $left ?>
					<?php endif; ?>
    				</div>
    			    </div>

				<?php
				global $user;
				if (($user->uid) == 1) { // uid = 1 ==> ADMIN
				    ?>
				    <div id="center"><div id="squeeze"><div class="right-corner"><div class="left-corner">
						    <?php ?>
						    <?php // print $breadcrumb;   ?>
						    <?php
						    if ($mission): print '<div id="mission">' . $mission . '</div>';
						    endif;
						    ?>
						    <?php
						    if ($tabs): print '<div id="tabs-wrapper" class="clear-block">';
						    endif;
						    ?>
						    <?php
						    if ($title): print '<h2' . ($tabs ? ' class="with-tabs"' : '') . '>' . $title . '</h2>';
						    endif;
						    ?>

						    <?php if ($below_title): ?><div class="below-title"><?php print $below_title ?></div><?php endif; ?>
						    <?php
						    if ($tabs): print '<ul class="tabs primary">' . $tabs . '</ul></div>';
						    endif;
						    ?>
						    <?php
						    if ($tabs2): print '<ul class="tabs secondary">' . $tabs2 . '</ul>';
						    endif;
						    ?>
						    <?php
						    if ($show_messages && $messages): print $messages;
						    endif;
						    ?>
						    <?php print $help; ?>
						    <div class="clear-block">
							<?php print $content ?>
						    </div>
						    <?php print $feed_icons ?>

						</div></div></div></div> <!-- /.left-corner, /.right-corner, /#squeeze, /#center -->
				    <?php
				}
				else {
				    ?>
				    <div id="centro">
					<?php
					$query = db_query("SELECT MAX(nid) nidd  FROM {node} WHERE type ='centro'");
					while ($result = db_fetch_object($query)) {
					    $node = node_load($result->nidd);
					}
					if ($node->type == 'centro') {
					    echo '<h2>' . $node->title . '</h2>';
					    echo('<img src="/drupal/' . $node->field_imagen_centro[0]['filepath'] . '">');
					    print($node->body);
					}
					?>
				    </div>
				    <?php
				};
				?>


    			    <div id="sidebar-right" class="sidebar">
    				<div id="twitter">		    
    				    <a class="twitter-timeline" href="https://twitter.com/pgagroup" data-widget-id="292351983006912513">Tweets por @pgagroup</a>
    				    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    				</div>
				    <?php if ($right): ?>
					<?php // if (!$left && $search_box):       ?><div class="block block-theme"><?php //print $search_box       ?></div><?php //endif;       ?>
					<?php print $right ?>
				    <?php endif; ?>
    			    </div>
				<?php
				//          Estilo para el contenido de la pagina
			    } //End If ($nodo_actual==="node)"
			    else {
				echo("<div id='centro_interno'>");
				$pieces = explode("/", $_GET['q']);
				$node_id = $pieces[1]; // piece1
				$query = db_query("SELECT MAX(nid) nidd  FROM {node} WHERE type ='articuloa'");
				$node = node_load($node_id);
				if (($node->type == 'page') && ($pieces[2] == null)) {
				    echo '<h2>' . $node->title . '</h2>';
				    if ($node->field_imagen_articulo_c != null) {
					echo('<img src="/drupal/' . $node->field_imagen_articulo_c[0]['filepath'] . '">');
				    } else {
					echo $node->body;
				    }
				} else {

				    echo('<div id="squeeze" style="width: 1000px;"><div class="right-corner"><div class="left-corner">');
				    ?>
				    <?php // print $breadcrumb; ?>
				    <?php
				    if ($mission): print '<div id="mission">' . $mission . '</div>';
				    endif;
				    ?>
				    <?php
				    if ($tabs): print '<div id="tabs-wrapper" class="clear-block">';
				    endif;
				    ?>
				    <?php
				    if ($title): print '<h2' . ($tabs ? ' class="with-tabs"' : '') . '>' . $title . '</h2>';
				    endif;
				    ?>

				    <?php if ($below_title): ?><div class="below-title"><?php print $below_title ?></div><?php endif; ?>



				    <?php
				    if ($tabs): print '<ul class="tabs primary">' . $tabs . '</ul></div>';
				    endif;
				    ?>
				    <?php
				    if ($tabs2): print '<ul class="tabs secondary">' . $tabs2 . '</ul>';
				    endif;
				    ?>
				    <?php
				    if ($show_messages && $messages): print $messages;
				    endif;
				    ?>
				    <?php print $help; ?>
				    <div class="clear-block">
					<?php print $content ?>
				    </div>
				    <?php print $feed_icons ?>

				</div></div></div></div></div>
		<?php
	    }
	}
	echo("</div>");
	?>
        </div>
        </div>
        <div id="wrapper_foo">
            <div id="foo">
                <div class="mapa">
		    <?php
		    $bodytag = menu_tree($menu_name = 'navigation');
		    var_dump(htmlentities($bodytag));
		    $grupos_id = array();
		    $flag_borrar = true;
		    $query = db_query("SELECT nodo2.nid nid, nodo1.title
FROM  `dr_node` nodo1,  `dr_node` nodo2
WHERE (nodo1.title = nodo2.title) and nodo1.type='grupos' and nodo2.type='page'");
		    while ($result = db_fetch_object($query)) {
			if ((!$user->uid)) {

			    //$bodytag = str_replace('<li class="leaf last"><a href="/drupal/?q=node/26" title="Banking Group">Banking Group</a></li>', '', $bodytag);
			    $bodytag = str_replace('<li class="leaf last"><a href="/drupal/?q=node/' . $result->nid . '" title="' . $result->title . '">' . $result->title . '</a></li>', '', $bodytag);
			} else {
			    foreach ($user->og_groups as $key => $value) {

				$query_grupo = db_query("SELECT  nid  FROM {node} WHERE type='grupos' and title ='" . $value . "'");
				while ($result_grupo = db_fetch_object($query_grupo)) {
				    $node = node_load($result_grupo->nid);
				    $grupos_id[] = $result_grupo->nid;
				}
				if ($result_grupo->nid == $result->nid) {
				    $flag_borrar = false;
				}
			    }
			    if ($flag_borrar) {
				//$bodytag = str_replace('<li class="leaf last"><a href="/drupal/?q=node/26" title="Banking Group">Banking Group</a></li>', '', $bodytag);
				//$bodytag = str_replace('<li ><a href="/drupal/?q=node/' . $node->nid . '" title="' . $value['title'] . '" >' . $value['title'] . '</a></li>', '', $bodytag);
				$bodytag = str_replace('<li class="leaf last"><a href="/drupal/?q=node/' . $result->nid . '" title="' . $result->title . '">' . $result->title . '</a></li>', '', $bodytag);
			    }
			}
		    }
		    echo $bodytag;
//		    var_dump(htmlentities($bodytag)) ;
		    ?>
		    <?php if ($mapa): ?><?php print $mapa ?>
		    <?php endif; ?>
                </div>
<!--                <div id="footer"><?php // print $footer_message . $footer                     ?></div>-->
            </div>
        </div>
        </div> <!-- /container -->
        </div>
        <!-- /layout -->

	<?php print $closure ?>
        <div id="dialogo_login" title="Inicia Sesion">
	    <?php
	    global $user;
	    if (!$user->uid) {
		?>
    	    <div class="user-register">
		    <?php
		    print drupal_get_form('user_login');
		    ?>
    	    </div>
		<?php
	    } else {
		?>
    	    You are already logged in.  GO AWAY!
		<?php
	    }
	    ?>
        </div>
        <div id="dialogo_registro" title="Registrate">
	    <?php
	    global $user;
	    if (!$user->uid) {
		?>
    	    <div class="user-register">
		    <?php
		    print drupal_get_form('user_register');
		    ?>
    	    </div>
		<?php
	    } else {
		?>
    	    You are already logged in.  GO AWAY!
		<?php
	    }
	    ?>
        </div>
    </body>
</html>
