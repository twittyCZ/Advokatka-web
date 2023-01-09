<?php

require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladač zajišťující vypsání uživatelova profilu.
 */
class profilController implements IController {

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
	 * Vrati obsah profilu.
	 * @param string $pageTitle     Název stránky.
	 * @return string
	 */
	public function show(string $pageTitle):string {
		global $tplData;
		$tplData = [];

		$tplData['title'] = $pageTitle;


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
		} else {
			$tplData['pravo'] = null;
		}

		$objednavky = $this->db->getExactObjByUserId($user['id_user']);

		foreach ($objednavky as $key => $objednavka){
			$objednavky[$key]['USER_id_user'] = $this->db->getExactUserById($objednavka['USER_id_user'])['username'];
			$exactsluzby = $this->db->getAllSluzbyByIdObjednavky($objednavka['id_objednavky']);
			foreach ($exactsluzby as $keySecond => $exactSluzba){
				$exactsluzby[$keySecond]['SLUZBY_id_sluzba'] = $this->db->getExactSluzbuById3($exactSluzba['SLUZBY_id_sluzba'])['typ_sluzby'];
			}
			$tplData["sluzby".$objednavka["id_objednavky"]] = $exactsluzby;
			if ($objednavka['schvalena'] == 0){
				$objednavky[$key]['schvalena'] = "NE";
			} else {
				$objednavky[$key]['schvalena'] = "ANO";
			}
		}

		$tplData['exactUserObj'] = $objednavky;

		ob_start();
		require(DIRECTORY_VIEWS ."/profil.php");
		$obsah = ob_get_clean();

		return $obsah;
	}

}

?>