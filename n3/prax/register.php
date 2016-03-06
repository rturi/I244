<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>I244 prax</title>
    <link rel="stylesheet" href="style.css">
</head>
    <?php include("navigation.php"); ?>

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
</body>
</html>