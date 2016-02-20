<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Praktikum 1 leht</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="coundDownScript.js"></script>
	</head>

	<body>
		<h1>Tähtis pealkiri</h1>
		<p>Lorem ipsum bla bla bla..</p>
		<p>Lorem ipsum bla bla bla..</p>
		<p>Lorem ipsum bla bla bla..</p>
		<p>Lorem ipsum bla bla bla..</p>
		<img src="html.png" alt="HTML-i pilt" height="150">

		<p>Countdown: <span id="time"></span></p>
		<br>

		<?php
			include("counter.php");
		?>

		<p>
			<a href="http://validator.w3.org/check?uri=referer">
				<img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" />
			</a>
		</p>

	</body>
</html>
