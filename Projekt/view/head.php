<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>I244 prax</title>
    <link type="text/css" rel="stylesheet" href="./style.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-2.2.2.min.js"></script>
    <script src="./main.js" type="text/javascript"></script>
<!-- background photo taken from https://www.flickr.com/photos/pixsells/1637946080/ - Attribution-ShareAlike 2.0 Generic - https://creativecommons.org/licenses/by-sa/2.0/-->
</head>

<body>

<div class="page_container">

    <div class="menu">
        <?php if (isset($_SESSION['username'])) : ?>
            <form action="?mode=search_task" method="post">
                <input class="search_box" placeholder="Search..." type="text" name="q">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token']); ?>">
            </form>
        <?php endif; ?>

        <ul>
            <li>
                <a href="?mode=main_page">Main page</a>
            </li>

            <?php if (!isset($_SESSION['username'])) : ?>
            <li>
                <a href="?mode=login">Log in</a>
            </li>
            <li>
                <a href="?mode=register">Create account</a>
            </li>
            <?php endif; ?>
            <?php if (isset($_SESSION['username'])) : ?>
            <li>
                <a href="?mode=logout">Log out</a>
            </li>
        </ul>
        <div class="menu_intermission">Your lists</div>
        <ul>
            <?php foreach($_SESSION['lists'] as $list) : ?>
            <li>
                <a href="?mode=lists&list_id=<?php echo htmlspecialchars($list['id']); ?>"><?php echo htmlspecialchars($list['name']); ?></a>
            </li>
            <?php endforeach; ?>
            <?php endif; ?>
        </ul>

    </div>


    <div class="content">

        <div class="title_area">
            <?php if(isset($page_title)) echo "<h1>" . htmlspecialchars($page_title) . "</h1>"; ?>
        </div>

        <?php if (isset($_SESSION['errors'])) : ?>
            <div class="error_message_area">
            <?php foreach($_SESSION['errors'] as $error):?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endforeach;?>
            </div>
            <?php $_SESSION['errors'] = null; ?>
        <?php endif ?>

        <?php if (isset($_SESSION['messages'])) : ?>
            <div class="message_area">
            <?php foreach($_SESSION['messages'] as $message):?>
                <div class="message"><?php echo htmlspecialchars($message); ?></div>
            <?php endforeach;?>
            <?php $_SESSION['messages'] = null; ?>
            </div>
        <?php endif ?>

