<?php
//http://enos.itcollege.ee/~rturi/I244/n8/kt/style_selector.php
$sampleText = "see on näitetekst";
if (isset($_POST['sampleText'])) {
    $sampleText = htmlspecialchars($_POST['sampleText']);
}

$backgroundColor = "#ffffff";
if (isset($_POST['backgroundColor'])) {
    $backgroundColor = htmlspecialchars($_POST['backgroundColor']);
}

$textColor = "#000000";
if (isset($_POST['textColor'])) {
    $textColor = htmlspecialchars($_POST['textColor']);
}

$borderWidth = "2";
if (isset($_POST['borderWidth'])) {
    $borderWidth = htmlspecialchars($_POST['borderWidth']);
}

$borderStyle = "solid";
if (isset($_POST['borderStyle'])) {
    $borderStyle = htmlspecialchars($_POST['borderStyle']);
}

$borderRadius = "15";
if (isset($_POST['borderRadius'])) {
    $borderRadius = htmlspecialchars($_POST['borderRadius']);
}

$borderColor = "#000000";
if (isset($_POST['borderColor'])) {
    $borderColor = htmlspecialchars($_POST['borderColor']);
}


?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>I244 kt8</title>
    <style>
        p.demo {
            background: <?php echo $backgroundColor; ?>;
            color: <?php echo $textColor; ?>;
            border-radius: <?php echo $borderRadius; ?>%;
            border-style: <?php echo $borderStyle; ?>;
            border-width: <?php echo $borderWidth; ?>px;
        }

        .content {
            width: 30%;
        }

    </style>
</head>
<body>

    <div class="content">

        <p class="demo">
            <?php echo $sampleText;?>
        </p>

        <hr>
        editor
        <form action="style_selector.php" method="post">
            <textarea name="sampleText" rows="4" columns="50"><?php echo $sampleText; ?></textarea><br>
            <input type="color" name="backgroundColor" value="<?php echo $backgroundColor; ?>">Taustavärvus<br>
            <input type="color" name="textColor" value="<?php echo $textColor; ?>">Tekstivärvus<br>
            Piirjoon: <br>
            <input type="number" name="borderWidth" min="0" max="20" step="1" value="<?php echo $borderWidth; ?>"> Piirjoone laius (0-20px)<br>
            <select name="borderStyle" selected="<?php echo $borderStyle; ?>">
                <option value="dotted">solid</option>
                <option value="none">none</option>
                <option value="dotted">dotted</option>
                <option value="dashed">dashed</option>
                <option value="double">double</option>
            </select> <br>
            <input type="color" name="borderColor" value="<?php echo $borderColor; ?>">Piirjoone värv<br>
            <input type="number" name="borderRadius" min="0" max="100" step="5" value="<?php echo $borderRadius; ?>"> piirjoone nurga raadius (0-100px)<br>
        <hr>
        <input type="submit" value="Kinnita">
        </form>

    </div>
</body>
</html>