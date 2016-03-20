<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>I244 prax</title>
    <link type="text/css" rel="stylesheet" href="style.css">
    <script src="main.js" type="text/javascript"></script>
</head>

<body>

<div class="page_container">

    <!-- Menu generated with PHP: -->
    <?php include("navigation.php"); ?>

    <div class="content">

        <div id="gallery">
            <a href="img/1.jpg">
                <img src="thumb/1.jpg" alt="image1 by an anonymous genius" height="100" width="150">
            </a>
            <a href="img/2.jpg">
                <img src="thumb/2.jpg" alt="image2 by an anonymous genius" height="100" width="150">
            </a>
            <a href="img/3.jpg">
                <img src="thumb/3.jpg" alt="image3 by an anonymous genius" height="100" width="150">
            </a>
            <a href="img/4.jpg">
                <img src="thumb/4.jpg" alt="image4 by an anonymous genius" height="100" width="150">
            </a>
            <a href="img/5.jpg">
                <img src="thumb/5.jpg" alt="image5 by an anonymous genius" height="100" width="150">
            </a>
            <a href="img/6.jpg">
                <img src="thumb/6.jpg" alt="image6 by an anonymous genius" height="100" width="150">
            </a>
        </div>
    </div>

    <div id="hoidja" style="display:none;">
        <div id="taust"></div>
        <div id="tabel">
            <div id="cell">
                <div id="sulge" onclick="hideDetails();">Sulge</div>
                <div id="sisu">
                    <img id="suurpilt" src="img/1.jpg" alt="ajutine"/><br/>
                    <span id="inf"></span>
                </div>
            </div>
        </div>
    </div>


    <div class="validator">
        <a href="http://validator.w3.org/check?uri=referer">
            <img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" />
        </a>
    </div>

</div>
</body>
</html>