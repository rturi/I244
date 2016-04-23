<h3>Valiku tulemus</h3>
<?php
if (!empty($_POST['pilt'])){

    $pilt_exists = false;
    foreach ($pildid as $pilt) {
        if ($pilt['id'] == $_POST['pilt']) $pilt_exists = true;
    }

    if ($pilt_exists) {
        echo "valisid pildi ".$_POST['pilt'];
    } else {
        echo "andsid hääle olematu pildi eest";
    }

} else {
    echo "sul jäi pilt valimata";
}
?>
