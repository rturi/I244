<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Praktikum 1 leht</title>
<style>
	body {color:blue;}
	p {background:yellow}
</style>
</head>

<body>
	<h1>Tähtis pealkiri 20.02</h1>
	<p>Lorem ipsum bla bla bla..</p>
	<p>Lorem ipsum bla bla bla..</p>
	<p>Lorem ipsum bla bla bla..</p>
	<p>Lorem ipsum bla bla bla..</p>






	<p>Viie minuti countdown <span id="time"></span></p>

	<script>
		<!-- allikas http://stackoverflow.com/questions/20618355/the-simplest-possible-javascript-countdown-timer -->
		function startTimer(duration, display) {
		var timer = duration, minutes, seconds;
		setInterval(function () {
		minutes = parseInt(timer / 60, 10);
		seconds = parseInt(timer % 60, 10);

		minutes = minutes < 10 ? "0" + minutes : minutes;
		seconds = seconds < 10 ? "0" + seconds : seconds;

		display.textContent = minutes + ":" + seconds;

		if (--timer < 0) {
		    timer = duration;
		}
		}, 1000);
		}

		window.onload = function () {
		var fiveMinutes = 60 * 5,
		display = document.querySelector('#time');
		startTimer(fiveMinutes, display);
		};
	</script>
	

	<br />
	<img src="html.png" alt="HTML-i pilt" height="150">

	<br />


	<?php 
		$logfile = "log.txt";
		//$counter = fgets($logfile);
		$counter = file_get_contents($logfile);
		$counter = $counter + 1;
		file_put_contents($logfile, $counter);
		echo "lehe külastuste arv on: " . $counter;	
	?>


	


</body>
</html>
