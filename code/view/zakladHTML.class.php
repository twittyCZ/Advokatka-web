<?php


class zakladHTML
{
    /**
     *  Vytvoření hlavičky stránky (header)
     * @param $styleHref    /Stylesheet
     * @param string $title Nazev stranky.
     */
public static function createHeader($styleHref,$title=""){
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" sizes="180x180" href="../image/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="../image/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="../image/favicon/favicon-16x16.png">
        <link rel="manifest" href="../image/favicon/site.webmanifest">
        <link rel="mask-icon" href="../image/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <link rel="shortcut icon" href="../image/favicon/favicon.ico">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="msapplication-config" content="../image/favicon/browserconfig.xml">
        <meta name="theme-color" content="#ffffff">

        <script src="npm-ukazka/node_modules/jquery/dist/jquery.min.js"></script>
        <script src="npm-ukazka/node_modules/popper.js/dist/popper.min.js"></script>
        <script src="npm-ukazka/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="https://kit.fontawesome.com/788503f4f8.js" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="npm-ukazka/node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="npm-ukazka/node_modules/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?=$styleHref?>">

        <title><?=$title?></title>

    </head>
    <?php
    }

	/**
	 * Vytvoření navigace
	 *
	 * @param $pravo        /Hodnota práva uživatele
	 * @param string $stav  /Stav - přihlášen/odhlášen
	 */
public static function createNav($pravo,$stav="prihlaseni"){
    ?>
    <div class="d-flex navbar bg-white border-bottom shadow-sm navbar-dark sticky-top">
        <a href="index.php?page=uvod"><h5 class="my-0 mr-md-auto font-weight-normal headline">Můj právník</h5></a>
        <nav class="navbar-expand-md">
            <button class="navbar-toggler bg-dark justify-content-around" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <div class="navbar-nav">
                    <a class="p-2 text-dark" href="index.php?page=udalosti">Události</a>
                    <a class="p-2 text-dark" href="index.php?page=cenik">Ceník</a>
                    <?php
                    if ($pravo != null){ ?>
                    <a class="p-2 text-dark" href="index.php?page=objednavka">Objednavka</a>
	                <?php }
	                if ($pravo == null){ ?>
		                <a class="p-2 text-dark" href="index.php?page=registrace">Registrace</a>
	                <?php }

                    if($pravo == 2 || $pravo == 1){ ?>
                        <a class="p-2 text-dark" href="index.php?page=objednavky">Objednávky</a>
                    <?php }
                    if ($pravo != null){ ?>
	                    <a class="p-2 text-dark" href="index.php?page=profil">Profil</a>
                   <?php }
                    if ($pravo == 1) {?>
	                    <a class="p-2 text-dark" href="index.php?page=sprava">Správa</a>
                    <?php }
                    if ($stav=='prihlaseni'){ ?>
                        <a class="btn btn-outline-primary" href="index.php?page=login">Přihlášení</a>
                    <?php } else { ?>
                            <form method="post">
                        <button type="submit" name="odhlasit" value="odhlasit" class="btn btn-outline-primary">Odhlásit se</button>
                        </form>
                    <?php } ?>
                 </div>
            </div>
        </nav>
    </div>
    <?php
    }

	/**
	 * Vypsání patičky
	 */
public static function createFooter(){
    ?>
    <footer class="pt-2 border-top d-flex justify-content-around">
        <div class="row container">
            <div class="col-6 col-md">
                <h5>Ozvěte se!</h5>
                <p>123 456 789</p>
                <p>muj@pravnik.cz</p>

            </div>
            <div class="col-6 col-md">
                <h5>Navštivte nás!</h5>
                <p>Plzeň, Jižní předměstí 42</p>
            </div>
           <div class="col-6 col-md">
                <p class=""><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2578.8342343283466!2d13.4019195151758!3d49.73274517938273!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x470aee29a2e3ce77%3A0xf7c3b50acfdc7a86!2zVnnFocWhw60gb2Rib3Juw6EgxaFrb2xhIGEgc3TFmWVkbsOtIHByxa9teXNsb3bDoSDFoWtvbGEgZWxla3Ryb3RlY2huaWNrw6EgUGx6ZcWI!5e0!3m2!1scs!2scz!4v1516544171980" width="660" height="190" frameborder="0" style="width:80%" allowfullscreen></iframe>
            </div>
        </div>
    </footer>
    <?php
    }
}