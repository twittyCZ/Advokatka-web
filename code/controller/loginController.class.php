<?php

require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladač pro vypsaní loginu.
 */
class loginController implements IController {

    /** @var MyDatabase $db  Správa databáze. */
    private $db;
    /**
     * @var userManage  $user Správa uživatele
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
     * Vrati obsah loginu.
     * @param string $pageTitle     Název stránky.
     * @return string               Výpis
     */
    public function show(string $pageTitle):string {
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

        if (isset($_POST['prihlasit']) and isset($_POST['email']) and
            isset($_POST['password']) and $_POST['prihlasit'] == "prihlasit"){
            $email = htmlspecialchars($_POST['email']);
            $heslo = htmlspecialchars($_POST['password']);
            $hash_password = $this->db->getPasswordByEmail($email);
            if($hash_password != null){
            $tplData['password'] = $hash_password['password'];
            $shoda = password_verify($heslo,$tplData['password']);
            if ($shoda){
                $tplData['userLogged'] = $this->user->userLogin($email,$tplData['password']);
                $tplData['povedloSe'] = true;
                $tplData['login'] = "Přihlášení se povedlo! Vítejte";
            } else {
                $tplData['povedloSe'] = false;
                $tplData['login'] = "Zadali jste špatný email nebo heslo!";
            }
        }else{
                $tplData['povedloSe'] = false;
                $tplData['login'] = "Zadali jste špatný email nebo heslo!";
            }
        }

        ob_start();
        require(DIRECTORY_VIEWS ."/login.php");
        $obsah = ob_get_clean();

        return $obsah;
    }

}

?>