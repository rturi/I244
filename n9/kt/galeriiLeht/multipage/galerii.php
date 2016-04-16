	<h3>Fotod</h3>
	<div id="gallery">

		<?php foreach ($pildid as $pilt): ?>

            <img src="<?php echo $pilt["src"]; ?>" alt="<?php echo $pilt["alt"]; ?>" />

        <?php endforeach;?>

        /* sample images
		<img src="../pildid/nameless1.jpg" alt="nimetu 1" />
		<img src="../pildid/nameless2.jpg" alt="nimetu 2" />
		*/
	</div>