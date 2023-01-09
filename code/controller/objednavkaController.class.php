<?php

require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladač pro vypsání stránky s objednávkou
 */
class objednavkaController implements IController {

    /** @var MyDatabase $db  Správa databáze */
    private $db;
    /**
     * @var userManage $user Správa uživatele
     */
    private $user;

    /**
     * Inicializace připojení k databázi a správě uživatele
     */
    public function __construct() {
        require_once (DIRECTORY_MODELS ."/MyDatabase.class.php");
        $this->db = new MyDatabase();
        require_once (DIRECTORY_MODELS ."/userManage.php");
        $this->user = new userManage();
    }
    /**
     * Vrátí stránku s možností objednávky.
     * @param string $pageTitle     Název stránky.
     * @return string               Výpis.
     */
    public function show(string $pageTitle):string {
        global $tplData;
        $tplData = [];

        $tplData['title'] = $pageTitle;

        $tplData['sluzby'] = $this->db->getAllSluzby();

        if(isset($_POST['odhlasit']) and $_POST['odhlasit'] == "odhlasit"){
            $this->user->userLogout();
            header('location: index.php?page=uvod');
        }

        $tplData['userLogged'] = $this->user->isUserLogged();

        if($tplData['userLogged']){
            $user = $this->user->getLoggedUserData();
            $tplData['pravo'] = $user['PRAVA_id_prava'];
            $tplData['username'] = $user['username'];
            $tplData['email'] = $user['email'];
            $tplData['password'] = $user['password'];
        } else {
            $tplData['pravo'] = null;
        }

        $tplData['povedloSe'] = false;

	    $poleHodnot=[];
	    foreach ($tplData['sluzby'] as $sluzba){
		    $sluzba = str_replace(' ', 'XXXX', $sluzba);
		    array_push($poleHodnot,$sluzba);
	    }
	    for ($i = 0; $i < count($poleHodnot);$i++){
		    $poleHodnot[$i] = $poleHodnot[$i][1];
	    }
            $datVyp = date('y-m-d');
            $poleRealHodnot = [];
	        foreach ($poleHodnot as $hodnota){
	        	if (isset($_POST[$hodnota])){
	        		$valueInArray = $_POST[$hodnota];
	        		$hodnota = str_replace('XXXX',' ',$hodnota);
			        $poleRealHodnot[$hodnota] = $valueInArray;
		        } else {
                    $tplData['povedloSe'] = false;
                    $tplData['uspech'] = "Objednávka nesmí být prázdná.";
                }
            }
	            $cas = intval(time()/10);
                $user = $this->db->vratUzivatele($tplData['email']);
                $userID = $user[0]['id_user'];
        foreach ($poleRealHodnot as $key => $itemForInsert) {
            $isSluzba = $this->db->getExactSluzbuByName($key);
            if($isSluzba != null) {
                $this->db->vytvorObjednavku($cas,$datVyp,$userID);
                $this->db->pridejSluzbu($isSluzba[0]['id_sluzba'], $cas, intval($itemForInsert));
                $tplData['povedloSe'] = true;
                $tplData['uspech'] = "Rezervace proběhla úspěšně. Svoji rezervaci naleznete po přihlášení v záložce profil.";
            } else {
                $tplData['povedloSe'] = false;
                $tplData['uspech'] = "Objednávka nesmí být prázdná.";
            }
        }
        ob_start();
        require(DIRECTORY_VIEWS ."/objednavka.php");
        $obsah = ob_get_clean();

        return $obsah;
    }

}

?>