	<h3>Vali oma lemmik :)</h3>
	<form action="tulemus.php" method="GET">

		<?php foreach ($pildid as $pilt): ?>
        <p>
            <label for="<?php echo $pilt["id"]; ?>">
                <img src="<?php echo $pilt["src"]; ?>" alt="<?php echo $pilt["alt"];?>" height="100" />
            </label>
            <input type="radio" value="<?php echo $pilt["id"]; ?>" id="<?php echo $pilt["img_id"]; ?>" name="pilt"/>
        </p>

        <?php endforeach;?>
<?php /* two sample vote blocks
		<p>
			<label for="p1">
				<img src="../pildid/nameless1.jpg" alt="nimetu 1" height="100" />
			</label>
			<input type="radio" value="1" id="p1" name="pilt"/>
		</p>
		<p>
			<label for="p2">
				<img src="../pildid/nameless2.jpg" alt="nimetu 2" height="100" />
			</label>
			<input type="radio" value="2" id="p2" name="pilt"/>
		</p>
*/ ?>
		<br/>
		<input type="submit" value="Valin!"/>
	</form>
