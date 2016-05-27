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
<h3>Valiku tulemus</h3>
<?php
if (!empty($_GET['pilt'])){

    $pilt_exists = false;
    foreach ($pildid as $pilt) {
        if ($pilt['id'] == $_GET['pilt']) $pilt_exists = true;
    }

    if ($pilt_exists) {
        echo "valisid ".$_GET['pilt'];
    } else {
        echo "andsid hääle olematu pildi eest";
    }

} else {
    echo "sul jäi pilt valimata";
}
?>

<?php require_once('foot.html');?>
