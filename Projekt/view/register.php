<div class="content_block">
<form action="?mode=register" method="post">
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
            <td></td>
            <td><input type="submit" value="Register"></td>
        </tr>
    </table>
</form>
</div>