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
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <svg class="bd-placeholder-img" width="100%" height="100%" focusable="false"><img
                        src="../image/uvod1.jpg"  alt="law picture"/></svg>
                <div class="container">
                    <div class="carousel-caption text-left">
                        <h1>Nebojte se ozvat!</h1>
                        <p class="highlight">Normální je problémy rešit. Regisrtujte se a objednejte si právní pomoc ještě dnes!</p>
                        <p><a class="btn btn-lg btn-primary" href="index.php?page=registrace" role="button">Registrovat ihned</a></p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <svg class="bd-placeholder-img" width="100%" height="100%" focusable="false" ><img
                            src="../image/uvod2.jpg" alt="Law picture"/></svg>
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Akce pro soukromý i veřejný sektor</h1>
                        <p class="highlight">Školení, zvyšování kvalifikace i nejnovější judikatura. Z praxe přímo pro Vás.</p>
                        <p><a class="btn btn-lg btn-primary" href="index.php?page=udalosti" role="button">Mám zájem</a></p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <svg class="bd-placeholder-img" width="100%" height="100%" focusable="false" ><img
                        src="../image/uvod3.jpg"  alt="River-Rafting-Falls-Belize"/></svg>
                <div class="container">
                    <div class="carousel-caption text-right text-white">
                        <h1 class="font-weight-bolder">Prohlédněte si námi nabízené služby</h1>
                        <p class="highlight font-weight-bold">Věnujeme se všem odvětvím práva</p>
                        <p><a class="btn btn-lg btn-primary" href="index.php?page=registrace" role="button">Prohlédnout nabídku</a></p>
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="container marketing">

    <!-- 2 sloupečky pod carouselem -->

    <div class="row pt-5 pb-5">
        <div class="col-lg-6">
            <img class="rounded-circle" src="../image/skoleni.jpg" width="200" height="200" alt="školení"/>
            <h2>Školení administrativních pracovníků</h2>
            <p>Efektivita a bezpečnost. To byly témata již 12. setkání s administrativními pracovníky velkých českých firem!</p>
            <p><a class="btn btn-primary" href="index.php?page=udalosti" role="button">Dozvědět se více &raquo;</a></p>
        </div>

        <div class="col-lg-6">
            <img class="bd-placeholder-img rounded-circle" src="../image/urad.jpg" width="200" height="200" alt="vodaci"/>
            <h2>Zlepšujeme úřady!</h2>
            <p>Funkční a vstřícný stát. To není jen klišé volební kampaně, to je naše advokátní kancelář v praxi!</p>
            <p><a class="btn btn-primary" href="index.php?page=udalosti" role="button">Dozvědět se více &raquo;</a></p>
        </div>
    </div>
    </div>
<?php
$tplHeaders->createFooter();
?>
</body>
