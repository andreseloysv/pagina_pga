<?php

echo('
	<link rel="stylesheet" href="http://www.compensa.com.ve/drupal/themes/mi_tema/banner_ie/examples/Standard/css/global.css">

	<script>
		$(function(){');
echo("
		});
	</script>
");

echo('<div id="container"><div id="example"><div id="slides"><div class="slides_container">');


foreach ($lista_archivos_baner_ie as $archivo) {
    $nombre=null;
    $nombre_solo=null;
    $nombre = explode(".", $archivo);
    $nombre = $nombre[0];
    $nombre_solo = explode(".", $nombre);
    $nombre_solo = $nombre_solo[0];
    echo ('<a href="#" title="145.365 - Happy Bokeh Thursday! | Flickr - Photo Sharing!" target="_blank"><img src="/drupal/themes/mi_tema/images/imagenes_banner/' . $carpeta . '/' . $archivo . '" alt="' . $nombre . '"  width="1045px" height="370" alt="Slide 1" class="imagenes_slider" style="position: absolute;z-index:1;"><img src="/drupal/themes/mi_tema/images/imagenes_banner/color_' . $carpeta . '/' . $nombre_solo.'_color.png" alt="' . $nombre . '"  width="120%" height="370px" alt="Slide 1" class="imagen_fondo_banner"></a>');
}

//					<a href="http://www.flickr.com/photos/jliba/4665625073/" title="145.365 - Happy Bokeh Thursday! | Flickr - Photo Sharing!" target="_blank"><img src="http://slidesjs.com/examples/standard/img/slide-1.jpg"  width="107%" height="270" alt="Slide 1" id="imagenes_slider" ></a>
//					<a href="http://www.flickr.com/photos/stephangeyer/3020487807/" title="Taxi | Flickr - Photo Sharing!" target="_blank"><img src="http://slidesjs.com/examples/standard/img/slide-2.jpg" width="107%" height="270" alt="Slide 2" ></a>
//					<a href="http://www.flickr.com/photos/childofwar/2984345060/" title="Happy Bokeh raining Day | Flickr - Photo Sharing!" target="_blank"><img src="http://slidesjs.com/examples/standard/img/slide-3.jpg" width="107%" height="270" alt="Slide 3" ></a>
//					<a href="http://www.flickr.com/photos/b-tal/117037943/" title="We Eat Light | Flickr - Photo Sharing!" target="_blank"><img src="http://slidesjs.com/examples/standard/img/slide-4.jpg" width="107%" height="270" alt="Slide 4 "></a>
//					<a href="http://www.flickr.com/photos/bu7amd/3447416780/" title="“I must go down to the sea again, to the lonely sea and the sky; and all I ask is a tall ship and a star to steer her by.” | Flickr - Photo Sharing!" target="_blank"><img src="http://slidesjs.com/examples/standard/img/slide-5.jpg" width="107%" height="270" alt="Slide 5" ></a>
//					<a href="http://www.flickr.com/photos/streetpreacher/2078765853/" title="twelve.inch | Flickr - Photo Sharing!" target="_blank"><img src="http://slidesjs.com/examples/standard/img/slide-6.jpg" width="107%" height="270" alt="Slide 6" ></a>
//					<a href="http://www.flickr.com/photos/aftab/3152515428/" title="Save my love for loneliness | Flickr - Photo Sharing!" target="_blank"><img src="http://slidesjs.com/examples/standard/img/slide-7.jpg" width="107%" height="270" alt="Slide 7" ></a> 
echo('
</div>
			</div>
	<img src="http://www.compensa.com.ve/drupal/themes/mi_tema/banner_ie/examples/Standard/img/example-frame.png" height="341" alt="Example Frame" id="frame">
		</div>');
?>