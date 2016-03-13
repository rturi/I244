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
    </div>


    <div class="validator">
        <a href="http://validator.w3.org/check?uri=referer">
            <img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" />
        </a>
    </div>

</div>
</body>
</html>