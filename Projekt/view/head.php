<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>I244 prax</title>
    <link type="text/css" rel="stylesheet" href="./style.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-2.2.2.min.js"></script>
    <script src="./main.js" type="text/javascript"></script>
</head>

<body>

<div class="page_container">

    <div class="menu">
        <?php if (isset($_SESSION['username'])) : ?>
        <input class="search_box" type="text" placeholder="Search tasks...">
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
        <span class="menu_intermission">Your lists</span>
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
            <?php if(isset($page_title)) echo "<h1>" . $page_title . "</h1>"; ?>
        </div>

        <?php if (isset($_SESSION['errors'])) : ?>
            <?php foreach($_SESSION['errors'] as $error):?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endforeach;?>
            <?php $_SESSION['errors'] = null; ?>
        <?php endif ?>

        <?php if (isset($_SESSION['messages'])) : ?>
            <?php foreach($_SESSION['messages'] as $message):?>
                <div class="message"><?php echo htmlspecialchars($message); ?></div>
            <?php endforeach;?>
            <?php $_SESSION['messages'] = null; ?>
        <?php endif ?>

