<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Eksam - I244 - Roland Türi</title>
    <link type="text/css" rel="stylesheet" href="./style.css">
</head>
<body>

<!-- Error area code from course study materials -->


<?php if (isset($_SESSION['errors'])) : ?>
    <div class="error_message_area">
    <?php foreach($_SESSION['errors'] as $error):?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endforeach;?>
    <?php $_SESSION['errors'] = null; ?>
<?php endif ?>

        <div class="page_content">
