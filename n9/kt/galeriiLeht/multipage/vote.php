<?php require_once('head.html');

$pildid = array(
    array('id'=>1, 'src'=>'pildid/nameless1.jpg', 'img_id'=>'p1', 'alt'=>'nimetu 1'),
    array('id'=>2, 'src'=>'pildid/nameless2.jpg', 'img_id'=>'p2', 'alt'=>'nimetu 2'),
    array('id'=>3, 'src'=>'pildid/nameless3.jpg', 'img_id'=>'p3', 'alt'=>'nimetu 3'),
    array('id'=>4, 'src'=>'pildid/nameless4.jpg', 'img_id'=>'p4', 'alt'=>'nimetu 4'),
    array('id'=>5, 'src'=>'pildid/nameless5.jpg', 'img_id'=>'p5', 'alt'=>'nimetu 5'),
    array('id'=>6, 'src'=>'pildid/nameless6.jpg', 'img_id'=>'p6', 'alt'=>'nimetu 6')
);

?>
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

		<br/>
		<input type="submit" value="Valin!"/>
	</form>
<?php require_once('foot.html');?>
