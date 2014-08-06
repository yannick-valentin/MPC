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
	<!--<script src="js/hammer.min.js"></script>
	<script src="js/lowLag.js"></script>
	<script src="js/soundmanager2.js"></script>-->
	<script src="js/jquery.touch.js"></script>
	<script src="js/script.js"></script>

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

</body>
</html>
