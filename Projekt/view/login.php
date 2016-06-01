<div class="content_block">
<form action="?mode=login" method="post">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token']); ?>">
    <table>
        <tr>
            <td>User name</td>
            <td><input type="text" name="user" value="<?php if (isset($input_user)) echo htmlspecialchars($input_user); ?>"></td>
        </tr>
            <td>Password</td>
            <td><input type="password" name="password"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input class="neutral_button" type="submit" value="Log in"></td>
        </tr>
    </table>
</form>
</div>