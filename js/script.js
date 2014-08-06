
/*		// Keep track of all loaded buffers.
		var BUFFERS = {};
		// Page-wide audio context.
		var context = null;
		var url = 'samples/tr909/';


	function BufferLoader(context, urlList, callback) {
  this.context = context;
  this.urlList = urlList;
  this.onload = callback;
  this.bufferList = new Array();
  this.loadCount = 0;
}

BufferLoader.prototype.loadBuffer = function(url, index) {
  // Load buffer asynchronously
  var request = new XMLHttpRequest();
  request.open("GET", url, true);
  request.responseType = "arraybuffer";

  var loader = this;

  request.onload = function() {
    // Asynchronously decode the audio file data in request.response
    loader.context.decodeAudioData(
      request.response,
      function(buffer) {
        if (!buffer) {
          alert('error decoding file data: ' + url);
          return;
        }
        loader.bufferList[index] = buffer;
        if (++loader.loadCount == loader.urlList.length)
          loader.onload(loader.bufferList);
      },
      function(error) {
        console.error('decodeAudioData error', error);
      }
    );
  }

  request.onerror = function() {
    alert('BufferLoader: XHR error');
  }

  request.send();
}

BufferLoader.prototype.load = function() {
  for (var i = 0; i < this.urlList.length; ++i)
  this.loadBuffer(this.urlList[i], i);
}



		// An object to track the buffers to load {name: path}
		var BUFFERS_TO_LOAD = {
			kick: url+'kick.wav',
			rimshot: url+'rimshot.wav',
			clap: url+'clap.wav',
			snare: url+'snare.wav',
			snare_2: url+'snare_2.wav',
			snare_3: url+'snare_3.wav',
			HH_c: url+'HH_c.wav',
			HH_o: url+'HH_o.wav',
			HH_f: url+'HH_f.wav',
			tom_h: url+'tom_h.wav',
			tom_l: url+'tom_l.wav',
			tom_m: url+'tom_m.wav',
			ride: url+'ride.wav',
			ride_h: url+'ride_h.wav',
			cowbell: url+'cowbell.wav',
			crash: url+'crash.wav',
		};

		// Loads all sound samples into the buffers object.
		function loadBuffers() {
			// Array-ify
			var names = [];
			var paths = [];
			for (var name in BUFFERS_TO_LOAD) {
				var path = BUFFERS_TO_LOAD[name];
				names.push(name);
				paths.push(path);
			}
			bufferLoader = new BufferLoader(context, paths, function(bufferList) {
				for (var i = 0; i < bufferList.length; i++) {
					var buffer = bufferList[i];
					var name = names[i];
					BUFFERS[name] = buffer;
				}
			});
			bufferLoader.load();
		}

		document.addEventListener('DOMContentLoaded', function() {
			try {
				// Fix up prefixing
				window.AudioContext = window.AudioContext || window.webkitAudioContext;
				context = new AudioContext();
			}
			catch(e) {
				alert("Web Audio API is not supported in this browser");
			}
			loadBuffers();
		});*/

		url = 'samples/tr909/';
		samples_buffer = {};

		// Fix up prefixing
		var context;
		window.addEventListener('load', init, false);

		function init() {
			try {
				// Fix up for prefixing
				window.AudioContext = window.AudioContext||window.webkitAudioContext;
				context = new AudioContext();
			}
			catch(e) {
				alert('Web Audio API is not supported in this browser');
			}
		}

		function errorMsg(e){console.log("Error loading webkitAudio: "+e);}


		function loadSound(file, tag) {
			var request = new XMLHttpRequest();
			request.open('GET', url+file, true);
			request.responseType = 'arraybuffer';

			// Decode asynchronously
			request.onload = function() {
				context.decodeAudioData(request.response, function(buffer) {
					return samples_buffer[tag] = buffer;
				}, errorMsg);
			}

			request.send();
		}

		function playSound(buffer) {
			var source = context.createBufferSource(); // creates a sound source
			source.buffer = buffer;                    // tell the source which sound to play
			source.connect(context.destination);       // connect the source to the context's destination (the speakers)
			source.start(0);                           // play the source now
			                                 			// note: on older systems, may have to use deprecated noteOn(time);
		}


	loadSound('snare.wav');	
	console.log(samples_buffer);
		// Chargement des samples
		/*$('.pad').each(function(){	
			the_sample = $(this).attr('id');			
			loadSound(the_sample+'.wav', the_sample);	

		});*/


		// Gestion du clic / touch
		$('.pad, a.actions_btn').touchInit();

		$(".pad").on("touch_start", function(event) {
			the_sample = $(this).attr('id');
			//play_sample(the_sample);
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


		function play_sample(sample) {
			// Joue le sample
			lowLag.play(sample);

			// Gère la class active sur le pad
			$('#'+sample).addClass('active');
			setTimeout(function(){
				$('#'+sample).removeClass('active');
			}, 100);
		}




			/* ============== */
			/* LOOP           */
			/* ============== *

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

		//});
