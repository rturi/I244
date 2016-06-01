<div class="content_block">
<form action="?mode=register" method="post">
    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
    <table>
        <tr>
            <td>User name</td>
            <td><input type="text" name="user" <?php if (isset($inputUserName)) echo "value=\"" . htmlspecialchars($inputUserName) . "\""?>></td>
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
            <td>&nbsp;</td>
            <td><input class="neutral_button" type="submit" value="Register"></td>
        </tr>
    </table>
</form>
</div>