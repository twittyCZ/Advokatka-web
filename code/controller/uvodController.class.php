<?php

require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladač zajištující vypsání úvodní stránky
 */
class uvodController implements IController {

    /** @var MyDatabase $db  Sprava databaze. */
    private $db;
    /**
     * @var userManage $user Správa uživatele
     */
    private $user;

    /**
     * Inicializace připojení k databázi a správě uživatele.
     */
    public function __construct() {
        require_once (DIRECTORY_MODELS ."/MyDatabase.class.php");
        $this->db = new MyDatabase();
        require_once (DIRECTORY_MODELS ."/userManage.php");
        $this->user = new userManage();
    }

    /**
     * Vrátí obsah úvodní stránky
     * @param string $pageTitle     Název stránky
     * @return string               Výpis
     */
    public function show(string $pageTitle):string {

         //Při prvním spuštění zaheshuj defaultní uživatele

        $this->db->updateUser("spravce@seznam.cz", "admin");
        $this->db->updateUser("zamestnanec@seznam.cz", "zamestnanec");
        $this->db->updateUser("uzivatel@seznam.cz", "uzivatel");
        $this->db->updateUser("chudy@pracujici.cz", "987");
        $this->db->updateUser("leonardo@daVinci.cz", "leo");

        global $tplData;
        $tplData = [];

        $tplData['title'] = $pageTitle;

        if(isset($_POST['odhlasit']) and $_POST['odhlasit'] == "odhlasit"){
            $this->user->userLogout();
        }

        $tplData['userLogged'] = $this->user->isUserLogged();

        if($tplData['userLogged']){
            $user = $this->user->getLoggedUserData();
            $tplData['pravo'] = $user['PRAVA_id_prava'];
        } else {
            $tplData['pravo'] = null;
        }

        ob_start();
        require(DIRECTORY_VIEWS ."/uvod.php");
        $obsah = ob_get_clean();

        return $obsah;
    }

}
?>