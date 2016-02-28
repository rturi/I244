<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>I244 prax</title>
</head>
    <?php include("navigation.php"); ?>

    <form action="img_upload.php" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td>Title</td>
                <td><input type="text" name="title"></td>
            </tr>
            <tr>
                <td>Author</td>
                <td><input type="text" name="author"></td>
            </tr>
            <tr>
                <td>Original image file</td>
                <td><input type="file" name="img"></td>
            </tr>
            <tr>
                <td>Thumbnail file</td>
                <td><input type="file" name="thumb"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Upload"></td>
            </tr>
        </table>
    </form>

</body>
</html>