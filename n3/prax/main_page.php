<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>I244 prax</title>
    <link rel="stylesheet" href="style.css">
</head>


<!--
Lisada lehel olevale pealkirjale sobiv värv (color).
Selleks, et kõik selle taseme pealkirjad samat värvi ei oleks anna värvitavale pealkirja elemendile id atribuut ning kasuta css-is selektorit #id_väärtus mis viitab konkreetsele id atribuudi väärtusele.
Värvi saab kirjutada kas #HEX NUMBRID või rgb(decimal numbrid). Näiteks #F8F8FF ja rgb(248,248,255) on ekvivalentsed Värvikaardi leiad siit
ümbritseda lehe sisu (kõik body vahel) div-iga, millel on lehe taustavärvist erinev taustavärv. Selleks, et kõikidel tulevastel div elementidel poleks sama taustavärv, tuleb elemendile anda kas klass või id
ümbritseda lehe reaalne sisu (va. menüülinke sisaldav list ja validaatori logo) omakorda div elemendiga. kirjelda sellele lehe sisu hõlmavale div-ile järgmine kujundus:
taustavärv valge (#ffffff) VÕI mingi oma valitav värvus
teksti joondus justify
anna menüü linke sisaldavale listielemendile (ul või ol) id atribuut mingi väärtusega (nt menu).
Muuta menüülinkide stiili (kasutada nt: color, text-decoration, font-weight, font-size jne.). Kasutada id-ga vanema sees oleva lingi selektorit piiramaks stiili mõju menüü sees olevatele linkidele
CSS võimaldab reageerida hiire kursori liikumisele elemendi kohale. Selleks lisatakse elemendi selektori järgi :hover ning määratakse stiilireeglid, mida rakendada hiirega konkreetse elemendi kohal olles. Enamasti kasutatakse seda linkide stiili muutmiseks, aga ka keerukamate menüüde loomisel (google - css menu)
Teha nii, et hiirega menüüs oleva lingi kohale minnes, muudab see oma stiili (taustavärv, tekstivärv, tekib/kaob alljoon etc.)

Organiseerida nii, et piltidel on piirjoon (border) ümber, aga validaatori nupul seda ei ole.
Vihje: kirjelda stiil ainult kindla div-i sees olevatele img elementidele või anna piltidele class atribuut.
Kui kasutad windowsi, saad kontrollida kas IE-s validaatori logol on piirjoon või mitte. Selle saab eemaldada andes validaatori logole omaduse border:none;
Kontrolli taaskord, et (http://validator.w3.org) on ikka veel rõõmus ja roheline, seda saad teha lihtsalt: kliki lehel olevale validaatori logo pildile.
Lisaks saad kontrollida CSS õigsust CSS validaatoris. Edaspidiseks mugavaks CSS valideerimiseks võid (aga ei pea) pealeht.html HTML validaatori logo juurde lisada ka CSS validaatori logo:
<a href="http://jigsaw.w3.org/css-validator/check/referer">
  <img src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!" />
</a>
Selleks, et ka teistel vaadetel (galerii, sisse logimine jne) oleks sarnane välimus, tuleks ka neile samad muudatused sisse viia...

-->

<body>

<div class="page_container">
    <?php include("navigation.php"); ?>

    <div class="content">
        <h1>Tähtis pealkiri</h1>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
            magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
            pariatur. Excepteur sint occaecat <em>cupidatat non proident</em>, sunt in culpa qui officia deserunt mollit anim id est
            laborum...
            <br>
            <img src="img/html.png" class="images" alt="HTML-i pilt">
        </p>

        <h2>Vähemtähtis pealkiri</h2>

        <p>
            <a href="http://www.lipsum.com/">Lorem ipsum</a> dolor sit amet, <u>consectetur adipiscing elit</u>, sed do eiusmod tempor incididunt ut labore et dolore
            magna aliqua.
        </p>
        <ol>
            <li>Lorem ipsum bla bla bla..</li>
            <li>Lorem ipsum bla bla bla..</li>
            <li>Lorem ipsum bla bla bla..</li>
            <li>Lorem ipsum bla bla bla..</li>
        </ol>

        <h2>Veel üks vähemtähtis pealkiri</h2>

        <p class="underlined">
            Lorem <b>ipsum</b> dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
            magna aliqua.
        </p>

        <ul>
            <li>Lorem ipsum bla bla bla..</li>
            <li>Lorem ipsum bla bla bla..</li>
            <li>Lorem ipsum bla bla bla..</li>
            <li>Lorem ipsum bla bla bla..</li>
        </ul>

        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
            magna aliqua:
        </p>
            <pre>
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            </pre>
    </div>


</div>

<div class="validator">
    <a href="http://validator.w3.org/check?uri=referer">
        <img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" />
    </a>
</div>

</body>
</html>