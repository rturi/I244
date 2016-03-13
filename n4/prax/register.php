<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>I244 prax</title>
    <link type="text/css" rel="stylesheet" href="style.css">
</head>

<body>

<div class="page_container">

    <!-- Menu generated with PHP: -->
    <?php include("navigation.php"); ?>

    <div class="content">

        <form action="register.php" method="post">
            <table>
                <tr>
                    <td>User name</td>
                    <td><input type="text" name="user"></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password"></td>
                </tr>
                <tr>
                    <td>Repeat password</td>
                    <td><input type="password" name="re_password"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Register"></td>
                </tr>
            </table>
        </form>
    </div>


    <div class="validator">
        <a href="http://validator.w3.org/check?uri=referer">
            <img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" />
        </a>
    </div>

</div>
</body>
</html>