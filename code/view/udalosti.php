<?php
global $tplData;

require("zakladHTML.class.php");
$tplHeaders = new zakladHTML();

$tplHeaders->createHeader("Styles/carousel.css",$tplData['title']);
?>
<body>
<?php
if (!$tplData['userLogged']) {
    $tplHeaders->createNav($tplData['pravo']);
} else {
    $tplHeaders->createNav($tplData['pravo'],"odhlaseni");
}
?>
<!-- Místo pro sekci o nás-->

<section>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 order-lg-2">
                <div class="p-5">
                    <img class="img-fluid rounded-circle" src="../image/skoleni.jpg" alt="Školení">
                </div>
            </div>
            <div class="col-lg-6 order-lg-1">
                <div class="p-5">
                    <h2 class="display-4">Školení administrativních pracovníků</h2>
                    <p>Efektivita a bezpečnost. To byly témata již 12. setkání s administrativními pracovníky velkých českých firem!</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="p-5">
                    <img class="img-fluid rounded-circle" src="../image/urad.jpg" alt="Úřad">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="p-5">
                    <h2 class="display-4">Zlepšujeme úřady!</h2>
                    <p>Funkční a vstřícný stát. To není jen klišé volební kampaně, to je naše advokátní kancelář v praxi!</p>                </div>
            </div>
        </div>
    </div>
</section>

<?php
$tplHeaders->createFooter();
?>
</body>
