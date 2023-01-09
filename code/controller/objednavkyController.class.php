<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladač zajišťující vypsaní objednávek pro zaměstnance
 */
class objednavkyController implements IController {

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
     * Vrátí obsah stránky pro výpis objednávek
     * @param string $pageTitle     Název stránky
     * @return string               Výpis
     */
    public function show(string $pageTitle):string {
        global $tplData;
        $tplData = [];

        $tplData['title'] = $pageTitle;

        $objednavky = $this->db->getAllObjednavky();


        foreach ($objednavky as $key => $objednavka){
            $objednavky[$key]['USER_id_user'] = $this->db->getExactUserById($objednavka['USER_id_user'])['username'];
            $exactsluzby = $this->db->getAllSluzbyByIdObjednavky($objednavka['id_objednavky']);
            foreach ($exactsluzby as $keySecond => $exactSluzba){
                $exactsluzby[$keySecond]['SLUZBY_id_sluzba'] = $this->db->getExactSluzbuById($exactSluzba['SLUZBY_id_sluzba'])['typ_sluzby'];
            }

            $tplData["sluzby".$objednavka["id_objednavky"]] = $exactsluzby;
            if ($objednavka['schvalena'] == 0){
                $objednavky[$key]['schvalena'] = "NE";
            } else {
                $objednavky[$key]['schvalena'] = "ANO";
            }
        }

        $tplData['objednavky'] = $objednavky;

        if(isset($_POST['Schvalit'])){
            $objID = $_POST['Schvalit'];
            $obj = $this->db->getExactObjById($objID);
            $this->db->updateObjednavka($objID,$obj['datum_vytvoreni'],$obj['USER_id_user'],$obj['schvalena']);
            header("Refresh:0");
        }


        if(isset($_POST['odhlasit']) and $_POST['odhlasit'] == "odhlasit"){
            $this->user->userLogout();
	        header('location: index.php?page=uvod');
        }

        $tplData['userLogged'] = $this->user->isUserLogged();

        if($tplData['userLogged']){
            $user = $this->user->getLoggedUserData();
            $tplData['pravo'] = $user['PRAVA_id_prava'];
        } else {
            $tplData['pravo'] = null;
        }

        ob_start();
        require(DIRECTORY_VIEWS ."/objednavky.php");
        $obsah = ob_get_clean();

        return $obsah;
    }
}
?>