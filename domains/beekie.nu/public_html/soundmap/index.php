<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script>
		<?php include "connect.php";?>
		
		function phpFunction(name){
			xmlhttp = new XMLHttpRequest();
			xmlhttp.open("GET","functions.php?functions=login&name="+name,true);
			xmlhttp.send();
			document.getElementById("login").style.display = "none";
		}
		
		function setTable(table){
			table = table.id
			xmlhttp = new XMLHttpRequest();
			xmlhttp.open("GET","functions.php?functions=table&table="+table,true);
			xmlhttp.send();
		}
		
		function createAudioMeter(audioContext,clipLevel,averaging,clipLag) {
			var processor = audioContext.createScriptProcessor(512);
			processor.onaudioprocess = volumeAudioProcess;
			processor.clipping = false;
			processor.lastClip = 0;
			processor.volume = 0;
			processor.clipLevel = clipLevel || 0.98;
			processor.averaging = averaging || 0.95;
			processor.clipLag = clipLag || 750;

			// this will have no effect, since we don't copy the input to the output,
			// but works around a current Chrome bug.
			processor.connect(audioContext.destination);

			processor.checkClipping =
				function(){
					if (!this.clipping)
						return false;
					if ((this.lastClip + this.clipLag) < window.performance.now())
						this.clipping = false;
					return this.clipping;
				};

			processor.shutdown =
				function(){
					this.disconnect();
					this.onaudioprocess = null;
				};

			return processor;
		}
		
		function volumeAudioProcess( event ) {
			var buf = event.inputBuffer.getChannelData(0);
			var bufLength = buf.length;
			var sum = 0;
			var x;

			// Do a root-mean-square on the samples: sum up the squares...
			for (var i=0; i<bufLength; i++) {
				x = buf[i];
				if (Math.abs(x)>=this.clipLevel) {
					this.clipping = true;
					this.lastClip = window.performance.now();
				}
				sum += x * x;
			}

			// ... then take the square root of the sum.
			var rms =  Math.sqrt(sum / bufLength);

			// Now smooth this out with the averaging factor applied
			// to the previous sample - take the max here because we
			// want "fast attack, slow release."
			this.volume = Math.max(rms, this.volume*this.averaging);
		}
		
		function mic() {
			var audioContext = null;
			var meter = null;
			var canvasContext = null;
			var WIDTH=500;
			var HEIGHT=50;
			var rafID = null;
				// monkeypatch Web Audio
				window.AudioContext = window.AudioContext || window.webkitAudioContext;

				// grab an audio context
				audioContext = new AudioContext();

				// Attempt to get audio input
				try {
					// monkeypatch getUserMedia
					navigator.getUserMedia = 
						navigator.getUserMedia ||
						navigator.webkitGetUserMedia ||
						navigator.mozGetUserMedia;

					// ask for an audio input
					navigator.getUserMedia(
					{
						"audio": {
							"mandatory": {
								"googEchoCancellation": "false",
								"googAutoGainControl": "false",
								"googNoiseSuppression": "false",
								"googHighpassFilter": "false"
							},
							"optional": []
						},
					}, gotStream, didntGetStream);
				} catch (e) {
					alert('getUserMedia threw exception :' + e);
				}


			function didntGetStream() {
				alert('Stream generation failed.');
			}

			var mediaStreamSource = null;

			function gotStream(stream) {
				// Create an AudioNode from the stream.
				mediaStreamSource = audioContext.createMediaStreamSource(stream);

				// Create a new volume meter and connect it.
				meter = createAudioMeter(audioContext);
				mediaStreamSource.connect(meter);
				
				// kick off the visual updating
				drawLoop();
			}

			function drawLoop( time ) {

				// draw a bar based on the current volume
				//alert(meter.volume);
				setTimeout(function(){
					rafID = window.requestAnimationFrame( drawLoop ); 
					
					xmlhttp = new XMLHttpRequest();
					xmlhttp.open("GET","functions.php?functions=volume&volume="+meter.volume,true);
					xmlhttp.send();
					
					xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == XMLHttpRequest.DONE) {
							volume = xmlhttp.responseText;
							document.getElementById("volume1").innerHTML = volume;
							
							if (volume < 0.30) {
								document.getElementById("table1").style.backgroundColor = "green";
							} else if (volume > 0.30 && volume < 0.50) {
								document.getElementById("table1").style.backgroundColor = "orange";
							} else if (volume > 0.50 & volume < 1) {
								document.getElementById("table1").style.backgroundColor = "red";
							}
						}
					}
					xmlhttp.open("GET","functions.php?functions=getVolume",true);
					xmlhttp.send();
				}, 500);
			}
		}
		
	</script>
</head>
	
<body>
	<div id="main">
		<div id="login">
			<div id="login-content">
				Name: <input id="name" type="text" name="name"><br>
				<input type="submit" value="Submit" onclick="phpFunction(document.getElementById('name').value)">
			</div>
		</div>
		<div id="tables">
			<div class="table" id="table1" onclick="mic(); setTable(this)">
				<h1 id="volume1"></h1>
			</div>
			<div class="table" id="table2" onclick="mic(); setTable(this)">
				
			</div>
		</div>
	</div>


	
	
</body>
</html>
