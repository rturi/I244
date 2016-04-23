<h3>Vali oma lemmik :)</h3>

    <?php if ($_SESSION['gallery_already_voded'] == false):?>
	<form action="?mode=tulemus" method="POST">

		<?php foreach ($pildid as $pilt): ?>
        <p>
            <label for="<?php echo $pilt["id"]; ?>">
                <img src="<?php echo $pilt["src"]; ?>" alt="<?php echo $pilt["alt"];?>" height="100" />
            </label>
            <input type="radio" value="<?php echo $pilt["id"]; ?>" id="<?php echo $pilt["img_id"]; ?>" name="pilt"/>
        </p>

        <?php endforeach;?>

		<br/>
		<input type="submit" value="Valin!"/>

	</form>
    <?php else : ?>
    <p>Oled juba korra hääletanud. <a href="?mode=vote&end=true">Kustuta sessioon.</a> </p>

    <?php endif; ?>
