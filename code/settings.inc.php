<?php
///////////////////////////////////////////////////////
////////////// Zakladni nastaveni webu ////////////////
///////////////////////////////////////////////////////

////// nastaveni pristupu k databazi ///////

    // prihlasovaci udaje k databazi
    define("DB_SERVER","localhost");
    define("DB_NAME","muj_pravnik");
    define("DB_USER","root");
    define("DB_PASS","");

    // definice konkretnich nazvu tabulek
    define("TABLE_USER","user");
    define("TABLE_PRAVA","prava");
    define("TABLE_SLUZBY","sluzby");
    define("TABLE_OBJEDNAVKA","objednavka");
    define("TABLE_OBJEDNAVKA_SLUZBY","objednavky_sluzby");


//// Dostupne stranky webu ////

/** Adresar kontroleru. */
const DIRECTORY_CONTROLLERS = "controller";
/** Adresar modelu. */
const DIRECTORY_MODELS = "model";
/** Adresar pohledů */
const DIRECTORY_VIEWS = "view";

/** Klic defaultni webove stranky - stranka uvod. */
const DEFAULT_WEB_PAGE_KEY = "uvod";

/** Dostupne webove stranky. */
const WEB_PAGES = array(
    //// Uvodni stranka ////
    /// Zobrazí potřebné soubory ////
    "uvod" => array(
        "title" => "Úvodní stránka",

        //// kontroler
        "file_name" => "uvodController.class.php",
        "class_name" => "uvodController",
    ),
    //// KONEC: Uvodni stranka ////

//// Události ////

"udalosti" => array(
        "title" => "Události",

        //// kontroler
        "file_name" => "udalostiController.class.php",
        "class_name" => "udalostiController",
    ),
//// Události konec ////


    /// Registrace ///
    "registrace" => array(
        "title" => "Registrace",

        //// kontroler
        "file_name" => "registraceController.class.php",
        "class_name" => "registraceController"
    ),
    //// KONEC: Registrace /////

    //// Objednávka ////
    "objednavka" => array(
        "title" => "Objednávka",

        //// kontroler
        "file_name" => "objednavkaController.class.php",
        "class_name" => "objednavkaController",
    ),
    //// KONEC: Objednávka ////

    //// Login ////
    "login" => array(
        "title" => "Přihlášení",

        //// kontroler
        "file_name" => "loginController.class.php",
        "class_name" => "loginController",
    ),
    //// KONEC: Login ////

    //// Uvodni stranka ////
    "cenik" => array(
        "title" => "Ceník",

        //// kontroler
        "file_name" => "CenikController.class.php",
        "class_name" => "CenikController",
    ),
    //// KONEC: Uvodni stranka ////

    //// Objednávky ////
    "objednavky" => array(
        "title" => "Objednávky",

        //// kontroler
        "file_name" => "objednavkyController.class.php",
        "class_name" => "objednavkyController",
    ),
    //// KONEC: Objednávky ////

    ///  Profil ///
    "profil" => array(
        "title" => "Profil",

        //// kontroler ////
        "file_name" => "profilController.class.php",
        "class_name" => "profilController",
    ),
    //// KONEC: Profil ////

    /// Správa ///
    "sprava" => array(
        "title" => "Správa",

        //// kontroler ////
        "file_name" => "spravaController.class.php",
        "class_name" => "spravaController",
    ),
    //// KONEC: Správy ///
);
?>
