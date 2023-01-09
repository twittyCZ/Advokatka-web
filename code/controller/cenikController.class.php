<?php
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladač zajišťující vypsání ceníku.
 */
class cenikController implements IController {

    /** @var MyDatabase $db  Sprava databaze. */
    private $db;
    /**
     * @var userManage  $user Načtení správy uživatele
     */
    private $user;

    /**
     * Inicializace pripojeni k databazi a ke správě uživatele.
     */
    public function __construct() {
        require_once (DIRECTORY_MODELS ."/MyDatabase.class.php");
        $this->db = new MyDatabase();
        require_once (DIRECTORY_MODELS ."/userManage.php");
        $this->user = new userManage();
    }

    /**
     * Vrati obsah ceníku.
     * @param string $pageTitle     Název stránky.
     * @return string
     */
    public function show(string $pageTitle):string {
        global $tplData;
        $tplData = [];

        $tplData['title'] = $pageTitle;

        $tplData['sluzby'] = $this->db->getAllSluzby();

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
        require(DIRECTORY_VIEWS ."/cenik.php");
        $obsah = ob_get_clean();

        return $obsah;
    }

}

?>