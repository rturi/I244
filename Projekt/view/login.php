<div class="content_block">
<form action="?mode=login" method="post">
    <table>
        <tr>
            <td>User name</td>
            <td><input type="text" name="user" value="<?php if (isset($input_user)) echo $input_user; ?>"></td>
        </tr>
            <td>Password</td>
            <td><input type="password" name="password"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Log in"></td>
        </tr>
    </table>
</form>
</div>