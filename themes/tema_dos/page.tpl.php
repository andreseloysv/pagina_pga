<?php include_once 'estilo.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
    <head>
	<title><?php print $head_title ?></title>
	<?php print $head ?>
	<?php print $styles ?>	
	<?php print $scripts ?>
	<!--[if lt IE 7]>
	<?php print phptemplate_get_ie_styles(); ?>
	<![endif]-->
    </head>
    <body<?php print phptemplate_body_class($left, $right); ?>>

	<!-- Layout -->
	<div id="header-region" class="clear-block">
	    <?php print $header; ?>
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
			    echo ('<li><img src="/drupal/themes/tema_dos/images/imagenes_banner/' . $archivo . '" alt="' . $nombre . '" /></li>');
			}
			?>

		    </ul>
		</div><!-- sp-content -->

	    </div><!-- sp-slideshow -->

	</div>

	<div id="wrapper">
	    <div id="container" class="clear-block">

		<div id="header">
		    <!--		    <div id="logo-floater">-->
		    <?php
		    // Prepare header
//			$site_fields = array();
//			if ($site_name) {
//			    $site_fields[] = check_plain($site_name);
//			}
//			if ($site_slogan) {
//			    $site_fields[] = check_plain($site_slogan);
//			}
//			$site_title = implode(' ', $site_fields);
//			if ($site_fields) {
//			    $site_fields[0] = '<span>' . $site_fields[0] . '</span>';
//			}
//			$site_html = implode(' ', $site_fields);
//
//			if ($logo || $site_title) {
//			    print '<h1><a href="' . check_url($front_page) . '" title="' . $site_title . '">';
//			    if ($logo) {
//				print '<img src="' . check_url($logo) . '" alt="' . $site_title . '" id="logo" />';
//			    }
//			    print $site_html . '</a></h1>';
//			}
		    ?>
		    <!--		    </div>-->



		    <?php if (isset($primary_links)) : ?>
			<?php print theme('links', $primary_links, array('class' => 'links primary-links')) ?>
		    <?php endif; ?>
		    <?php if (isset($secondary_links)) : ?>
			<?php print theme('links', $secondary_links, array('class' => 'links secondary-links')) ?>
		    <?php endif; ?>

		</div> <!-- /header -->

		<?php if ($left): ?>
    		<div id="sidebar-left" class="sidebar">
			<?php if ($search_box): ?><div class="block block-theme"><?php print $search_box ?></div><?php endif; ?>
			<?php print $left ?>
    		</div>
		<?php endif; ?>

		<div id="center"><div id="squeeze"><div class="right-corner"><div class="left-corner">
				<?php print $breadcrumb; ?>
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
				<?php if ($articulo_a): ?><div class="articulo-a"><?php print $articulo_a ?></div><?php endif; ?>
				<?php if ($articulo_b): ?><div class="articulo-b"><?php print $articulo_b ?></div><?php endif; ?>
				<?php if ($articulo_c): ?><div class="articulo-c"><?php print $articulo_c ?></div><?php endif; ?>
				<?php if ($mapa): ?><div class="mapa"><?php print $mapa ?></div><?php endif; ?>
				<div id="footer"><?php print $footer_message . $footer ?></div>
			    </div></div></div></div> <!-- /.left-corner, /.right-corner, /#squeeze, /#center -->

		<?php if ($right): ?>
    		<div id="sidebar-right" class="sidebar">
			<?php if (!$left && $search_box): ?><div class="block block-theme"><?php print $search_box ?></div><?php endif; ?>
			<?php print $right ?>
    		</div>
		<?php endif; ?>

	    </div> <!-- /container -->
	</div>
	<!-- /layout -->

	<?php print $closure ?>
    </body>
</html>
