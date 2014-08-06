<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->

<head>

	<title>MPD</title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,  maximum-scale=1">
	<meta name="apple-mobile-web-app-capable" content="yes" />


	<link rel="stylesheet" href="css/foundation.css">
	<link rel="stylesheet" href="css/style.css">


	<script src="js/vendor/custom.modernizr.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<!--<script src="js/hammer.min.js"></script>-->
	<script src="js/jquery.touch.js"></script>
	<script src="js/lowLag.js"></script>
	<script src="js/soundmanager2.js"></script>

</head>
<body onload="setTimeout(function() { window.scrollTo(0, 1) }, 100);">
	<div id="pagewrapper">

		<div class="row">
			<div class="large-4 push-8 columns" id="controls">
				
				<input id="tempo_input" value="90" type="range" min="60" max="140">
				<label id="tempo_label"></label>

				<select id="bank">
					<option value="tr909">Roland TR-909</option>
					<option value="cr78">Roland CR-78</option>
				</select>
				<a class="button actions_btn" href="#" id="play_btn">Play</a>
				<a class="button actions_btn" href="#" id="stop_btn">Stop</a>

			</div>
			<div class="large-8 pull-4 columns">			

				<ul class="large-block-grid-4 small-block-grid-4" id="machine">
					<?php 
						$pads = Array("crash", "cowbell", "snare_3", "ride", "tom_h", "tom_m", "HH_o", "ride_h", "snare_2", "tom_l", "HH_c", "HH_f", "kick", "snare", "rimshot", "clap");

						foreach ($pads as $pad) {
							echo '<li class="pad_wrapper"><span class="pad" id="'.$pad.'"></span></li>';
						}
					?>
				</ul>

			</div>
		</div>

	</div>

	<script>
		function play_sample(sample) {
			// Joue le sample
			lowLag.play(sample);

			// Gère la class active sur le pad
			$('#'+sample).addClass('active');
			setTimeout(function(){
				$('#'+sample).removeClass('active');
			}, 100);
		}

		function set_tempo(tempo) {
			temps = 60 / tempo * 1000;

			carre =		temps * 8;
			ronde = 	temps * 4;
			blanche = 	temps * 2;
			noir = 		temps;
			croche = 	temps / 2;
			double_croche = 	temps / 4
			trible_croche = 	temps / 8;
		}


		function play_loop(stop) {

			//console.log(tempo);

			play_sample('kick');
			play_sample('HH_c');

			setTimeout(function(){
				play_sample('HH_c');
			}, noir);

			setTimeout(function(){
				play_sample('HH_c');
				play_sample('snare');
			}, noir*2);

			setTimeout(function(){
				play_sample('HH_c');
			}, noir*3);

			setTimeout(function(){
				play_loop();
			}, noir*4);

			if(stop == 'stop')
				return;

		}



		$(document).ready(function(){

			// définition des paramètre de LowLag
			lowLag.init({
				'urlPrefix':'samples/tr909/'
			});

			// Chargement des samples
			$('.pad').each(function(){
				the_sample = $(this).attr('id');

				lowLag.load([the_sample+'.wav'],the_sample);
			});

			// Gestion du clic / touch
			$('.pad, a.actions_btn').touchInit();

			$(".pad").on("touch_start", function(event) {
				the_sample = $(this).attr('id');
				play_sample(the_sample);
			});

			// Gestion du clavier
			$(document).keypress(function(event) {
				/* 1 */ if ( event.which == 38 ) 	play_sample('crash');
				/* 2 */ if ( event.which == 233 ) 	play_sample('cowbell');
				/* 3 */ if ( event.which == 34 ) 	play_sample('snare_3');
				/* 4 */ if ( event.which == 39 ) 	play_sample('ride');
				/* A */ if ( event.which == 97 ) 	play_sample('tom_h');
				/* Z */ if ( event.which == 122 ) 	play_sample('tom_m');
				/* E */ if ( event.which == 101 ) 	play_sample('HH_o');
				/* R */ if ( event.which == 114 ) 	play_sample('ride_h');
				/* Q */ if ( event.which == 113 ) 	play_sample('snare_2');
				/* S */ if ( event.which == 115 ) 	play_sample('tom_l');
				/* D */ if ( event.which == 100 ) 	play_sample('HH_c');
				/* F */ if ( event.which == 102 ) 	play_sample('HH_f');
				/* W */ if ( event.which == 119 ) 	play_sample('kick');
				/* X */ if ( event.which == 120 ) 	play_sample('snare');
				/* C */ if ( event.which == 99 ) 	play_sample('rimshot');
				/* V */ if ( event.which == 118 ) 	play_sample('clap');			
			});



			/* ============== */
			/* LOOP           */
			/* ============== */

			// gestion du tempo
			tempo_value = $('#tempo_input').val();
			$('#tempo_label').html(tempo_value);
			set_tempo(tempo_value);

			// au chagnement du slider
			$('#tempo_input').change(function(){
				tempo_value = $(this).val();
				$('#tempo_label').html(tempo_value);
				set_tempo(tempo_value);
			});


			/*$('a#play_btn').on("touch_start", function(event) {
				event.preventDefault();
				//play_loop();
				console.log(noir);
			});


			$('a#stop_btn').click(function(e){
				e.preventDefault();
				stop_loop();
			});*/

		});


	</script>
</body>
</html>
