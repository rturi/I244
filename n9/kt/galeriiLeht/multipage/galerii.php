<?php
$pildid = array(
    array('id'=>1, 'src'=>'pildid/nameless1.jpg', 'img_id'=>'p1', 'alt'=>'nimetu 1'),
    array('id'=>2, 'src'=>'pildid/nameless2.jpg', 'img_id'=>'p2', 'alt'=>'nimetu 2'),
    array('id'=>3, 'src'=>'pildid/nameless3.jpg', 'img_id'=>'p3', 'alt'=>'nimetu 3'),
    array('id'=>4, 'src'=>'pildid/nameless4.jpg', 'img_id'=>'p4', 'alt'=>'nimetu 4'),
    array('id'=>5, 'src'=>'pildid/nameless5.jpg', 'img_id'=>'p5', 'alt'=>'nimetu 5'),
    array('id'=>6, 'src'=>'pildid/nameless6.jpg', 'img_id'=>'p6', 'alt'=>'nimetu 6')
);

require_once('head.html');
?>
	<h3>Fotod</h3>
	<div id="gallery">

		<?php foreach ($pildid as $pilt): ?>

            <img src="<?php echo $pilt['src']; ?>" alt="<?php echo $pilt['alt'];?>" />

        <?php endforeach;?>

        <?php
        /* sample images
		<img src="../pildid/nameless1.jpg" alt="nimetu 1" />
		<img src="../pildid/nameless2.jpg" alt="nimetu 2" />
		*/
        ?>
	</div>
<?php require_once('foot.html');?>