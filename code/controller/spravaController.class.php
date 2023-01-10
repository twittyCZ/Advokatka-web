<?php

require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladač zajišťující vypsání ceníku.
 */
class spravaController implements IController {

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

        /**
         * Přidání nového zaměstnance
         */
        if (isset($_POST['registruj']) and isset($_POST['email']) and
            isset($_POST['password']) and isset($_POST['username']) and
            $_POST['registruj'] == "registruj") {
            $email = htmlspecialchars($_POST['email']);
            $heslo = htmlspecialchars($_POST['password']);
            $username = htmlspecialchars($_POST['username']);
            if ($username == null || $heslo == null || $email == null) {
                $tplData['povedloSe'] = false;
                $tplData['login'] = "Přidání zaměstnance " . $username . " ne nezdařilo. Musíte vyplnit všechny údaje!";
            } else {
                $isRegistered1 = $this->db->getAUserByEmail($email);
                $isRegistered2 = $this->db->getAUserByName($username);
                if(!count($isRegistered2) && !count($isRegistered1)){
                    $tplData['povedloSe'] = $this->db->registrujUzivatele($email, $username, $heslo, 2);
                    $tplData['login'] = "Registrace se zdařila! Vítejte " . $username;
                } else {
                    $tplData['povedloSe'] = false;
                    $tplData['login'] = "Je nám líto, ale registrace se nezdařila. Nejspíše už je tento email nebo jmeno použito.";
                }
            }
        }

        /**
         * Odebrání zaměstnance
         */
        if (isset($_POST['smazUzivatele']) and (isset($_POST['email']) and
            isset($_POST['password']) and isset($_POST['username']))
            and $_POST['smazUzivatele'] == "smazUzivatele") {
            $email = htmlspecialchars($_POST['email']);
            $heslo = htmlspecialchars($_POST['password']);
            $username = htmlspecialchars($_POST['username']);
            if ($username == null || $heslo == null || $email == null){
                $tplData['povedloSe'] = false;
                $tplData['login'] = "Odebrání zaměstnance " . $username . " ne nezdařilo. Musíte vyplnit všechny údaje!";
            }
            else {
                $hash_password = $this->db->getPassword($email, $username);
                if ($hash_password != null) {
                    $tplData['password'] = $hash_password['password'];
                    $shoda = password_verify($heslo, $tplData['password']);
                    if ($shoda) {
                        $tplData['povedloSe'] = $this->db->smazZamestnance($username);
                        $tplData['login'] = "Odebrání zaměstnance " . $username . " se zdařilo.";
                    } else {
                        $tplData['povedloSe'] = false;
                        $tplData['login'] = "Odebrání zaměstnance " . $username . " se nezdařilo";
                    }
                } else {
                    $tplData['povedloSe'] = false;
                    $tplData['login'] = "Odebrání zaměstnance " . $username . " se nezdařilo";
                }
            }
        }
        /**
         * Přidání nové služby
         */
		if (isset($_POST['pridejSluzbu']) and isset($_POST['nazevSluzby']) and
			isset($_POST['cenaSluzby']) and $_POST['pridejSluzbu'] == "pridejSluzbu") {
            $nazevSluzby = htmlspecialchars($_POST['nazevSluzby']);
            $cena = htmlspecialchars($_POST['cenaSluzby']);
            if ($nazevSluzby == null || $cena == null) {
                $tplData['povedloSe'] = false;
                $tplData['login'] = "Přidání služby " . $nazevSluzby . " ne nezdařilo. Musíte vyplnit všechny údaje!";
            } else {
                $isSluzba = $this->db->getExactSluzbuByName($nazevSluzby);
                if (empty($isSluzba)) {
                    $tplData['povedloSe'] = $this->db->pridejNovouSluzbu($nazevSluzby, $cena);
                    $tplData['login'] = "Služba " . $nazevSluzby . " byla úspěšně přidána";
                } else {
                    $tplData['povedloSe'] = false;
                    $tplData['login'] = "Služba " . $nazevSluzby . " nebyla přidána";
                }
            }
        }
        /**
         * Odebrání služby
         */
        if (isset($_POST['odeberSluzbu']) and isset($_POST['nazevSluzby']) and
            isset($_POST['cenaSluzby'])  and $_POST['odeberSluzbu'] == "odeberSluzbu") {
            $nazevSluzby = htmlspecialchars($_POST['nazevSluzby']);
            $cena = htmlspecialchars($_POST['cenaSluzby']);
            if ($nazevSluzby == null || $cena == null) {
                $tplData['povedloSe'] = false;
                $tplData['login'] = "Odebrání služby " . $nazevSluzby . " ne nezdařilo. Musíte vyplnit všechny údaje!";
            } else {
                $sluzba = $this->db->vratSluzbu($nazevSluzby, $cena);
                if (!empty($sluzba)) {
                    $tplData['povedloSe'] = $this->db->odeberSluzbu($nazevSluzby, $cena);
                    $tplData['login'] = "Služba byla odebrána.";
                } else {
                    $tplData['povedloSe'] = false;
                    $tplData['login'] = "Služba nebyla odebrána.";
                }
            }
        }
		ob_start();
		require(DIRECTORY_VIEWS ."/sprava.php");
		$obsah = ob_get_clean();

		return $obsah;
	}

}

?>
