<?php

/**
 * Třída spravující databázi
 */
class MyDatabase
{

    /** @var PDO $pdo PDO objekt pro práci s databází. */
    private $pdo;

    /**
     * Inicializace připojení k databázi.
     */
    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $this->pdo->exec("set names utf8");
    }


    /**
     *  Provede dotaz a bud vrati ziskana data, nebo pri chybe ji vypise a vrati null.
     *  Varianta, pokud je pouzit PDO::ERRMODE_EXCEPTION
     *
     *  @param string $dotaz        SQL dotaz.
     *  @return PDOStatement|null    Vysledek dotazu.
     */
    private function executeQuery(string $dotaz){
        try {
            $res = $this->pdo->query($dotaz);
            return $res;
        } catch (PDOException $ex){
            echo "Nastala výjimka: ". $ex->getCode() ."<br>"
                ."Text: ". $ex->getMessage();
            return null;
        }
    }

    /**
     * Provede příkaz SELECT v tabulce
     *
     * @param string $tableName Název tabulky
     * @param string $whereStatement Pripadne omezeni na ziskani radek tabulky. Default "".
     * @param string $orderByStatement Pripadne razeni ziskanych radek tabulky. Default "".
     * @return array                    Vraci pole ziskanych radek tabulky.
     */
    public function selectFromTable(string $tableName, string $whereStatement = "", string $orderByStatement = ""): array
    {
        $q = "SELECT * FROM " . $tableName
            . (($whereStatement == "") ? "" : " WHERE $whereStatement")
            . (($orderByStatement == "") ? "" : " ORDER BY $orderByStatement");

        $obj = $this->executeQuery($q);
        if ($obj == null) {
            return [];
        }
        return $obj->fetchAll();
    }
    /**
     * Provede příkaz SELECT v tabulce
     *
     * @param string $tableName Název tabulky
     * @param string $whereStatement Pripadne omezeni na ziskani radek tabulky. Default "".
     * @param string $orderByStatement Pripadne razeni ziskanych radek tabulky. Default "".
     * @return array                    Vraci prazdnou radku nebo hodnotu
     */
     public function selectAtributFromTable(string $tableName, string $whereStatement = "", string $orderByStatement = ""){

         $q = "SELECT password FROM " . $tableName
             . (($whereStatement == "") ? "" : " WHERE $whereStatement")
             . (($orderByStatement == "") ? "" : " ORDER BY $orderByStatement");
         $obj = $this->executeQuery($q);
         if ($obj == null) {
             return [];
         }
         return $obj->fetch();
     }

    /**
     * Upráva řádku databáze
     *
     * @param string $tableName Nazev tabulky.
     * @param string $updateStatementWithValues Cela cast updatu s hodnotami.
     * @param string $whereStatement Cela cast pro WHERE.
     * @return bool true, pokud byl řádek změněn
     */
    public function updateInTable(string $tableName, string $updateStatementWithValues, string $whereStatement): bool
    {
        $q = "UPDATE $tableName SET $updateStatementWithValues WHERE $whereStatement";

        $obj = $this->executeQuery($q);
        if ($obj == null) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Úprava hodnot uživatele
     *
     * @param string $email email uživatele
     * @param string $heslo heslo uživatele
     * @return bool vrátí true pokud se odebrání povede
     */
    public function updateUser(string $email, string $heslo){
        $password = password_hash($heslo, PASSWORD_BCRYPT);
        $updateStatementWithValues = "password='$password'";
        $whereStatement = "email='$email'";
        return $this->updateInTable(TABLE_USER, $updateStatementWithValues, $whereStatement);
    }

    /**
     * Získání uživatele podle Emailu a jméma.
     *
     * @param string $email Email pro vyhledání v databízi.
     * @return array    Pole se vsemi uživateli (vždycky bude pouze jeden uživatel).
     */
    public function getAUser($username, $email): ?array
    {
        $q = "SELECT * FROM " . TABLE_USER . " WHERE email=:uEmail AND username=:username;";
        $user = $this->pdo->prepare($q);
        $user->bindValue(":uEmail", $email);
        $user->bindValue(":username", $username);
        if ($user->execute()) {
            return $user->fetchAll();
        } else {
            return null;
        }
    }
    /**
     * Získání uživatele podle jmena.
     *
     * @param string $email Email pro vyhledání v databízi.
     * @return array    Pole se vsemi uživateli (vždycky bude pouze jeden uživatel).
     */
    public function getAUserByName($username): ?array
    {
        $q = "SELECT * FROM " . TABLE_USER . " WHERE username=:username;";
        $user = $this->pdo->prepare($q);
        $user->bindValue(":username", $username);
        if ($user->execute()) {
            return $user->fetchAll();
        } else {
            return null;
        }
    }

        /**
     * Získání uživatele podle Emailu.
     *
     * @param string $email Email pro vyhledání v databízi.
     * @return array    Pole se vsemi uživateli (vždycky bude pouze jeden uživatel).
     */
    public function getAUserByEmail($email): ?array
    {
        $q = "SELECT * FROM " . TABLE_USER . " WHERE email=:uEmail;";
        $user = $this->pdo->prepare($q);
        $user->bindValue(":uEmail", $email);

        if ($user->execute()) {
            return $user->fetchAll();
        } else {
            return null;
        }
    }
    /**
     * Získání všech sluzeb, které jsou v jedné objednávce
     *
     * @param int $idObjednavky ID objednávky ve které hledám sluzby
     * @return array    Pole se vsemi sluzbamimi.
     */
    public function getAllSluzbyByIdObjednavky(int $idObjednavky): ?array
    {

        $q = "SELECT * FROM " . TABLE_OBJEDNAVKA_SLUZBY. " WHERE OBJEDNAVKA_id_objednavky=:uIDObj;";
        $user = $this->pdo->prepare($q);
        $user->bindValue(":uIDObj", $idObjednavky);

        if ($user->execute()) {
            return $user->fetchAll();
        } else {
            return null;
        }
    }

    /**
     * Získání dané sluzby podle jejího jména
     *
     * @param $nazev    nazev sluýby
     * @return array    Pole s sluzeb.
     */
    public function getExactSluzbuByName($nazev): ?array
    {
        $q = "SELECT * FROM " . TABLE_SLUZBY . " WHERE typ_sluzby=:nazev;";
        $vystup = $this->pdo->prepare($q);
        $vystup->bindValue(":nazev", $nazev);
        if ($vystup->execute()) {
            return $vystup->fetchAll();
        } else {
            return null;
        }
    }

    /**
     * Vytvoření celé objednávky
     *
     * @param $id /ID objednávky
     * @param $datumVyberu /Datum vypůjčení
     * @param $id_user /ID uživatele, který vytvořil objednávku
     * @param int $schvalena Byla schálena? 0 - NE || 1 - ANO
     * @return bool Povedlo se vytvořit objednávku?
     */
    public function vytvorObjednavku($id, $datumVyberu, $id_user, $schvalena = 0): bool
    {

        $q = "INSERT INTO " . TABLE_OBJEDNAVKA . " (id_objednavky,datum_vytvoreni,USER_id_user,schvalena) 
        VALUES (:idObj,:datumVyberu, :ID_User, :schvalena);";
        $vystup = $this->pdo->prepare($q);

        $vystup->bindValue(":idObj", $id);
        $vystup->bindValue(":datumVyberu", $datumVyberu);
        $vystup->bindValue(":ID_User", $id_user);
        $vystup->bindValue(":schvalena", $schvalena);

        if ($vystup->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Přidání vztahu mezi objednávkou a službou, která ji tvoří
     *
     * @param $idsluzba /ID sluzby
     * @param $idObj /ID objednávky
     * @param $pocet /Počet sluzeb
     * @return bool     true pokud byla služba přidána
     */
    public function pridejSluzbu($idsluzba, $idObj, $pocet): bool
    {
        $q = "INSERT INTO " . TABLE_OBJEDNAVKA_SLUZBY . " (SLUZBY_id_sluzba,OBJEDNAVKA_id_objednavky,pocet) 
        VALUES (:idSluzba,:idObj,:pocet);";
        $vystup = $this->pdo->prepare($q);

        $vystup->bindValue(":idSluzba", $idsluzba);
        $vystup->bindValue(":idObj", $idObj);
        $vystup->bindValue(":pocet", $pocet);

        if ($vystup->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Přidání služby do databáze
     *
     * @param $idSluzby ID služby
     * @param $nazev /Název služby
     * @param $cena cena služby
     * @return bool    true pokud byla služba přidána
     */
    public function pridejNovouSluzbu($nazev, $cena): bool
    {
        $q = "INSERT INTO " . TABLE_SLUZBY . " (typ_sluzby,cena) VALUES (:nazev,:cena);";
        $vystup = $this->pdo->prepare($q);
        ;
        $vystup->bindValue(":nazev", $nazev);
        $vystup->bindValue(":cena", $cena);

        if ($vystup->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Odebere službu z databáze
     *
     * @param $tableSluzby tabulka služby
     * @param $nazev    název služby
     * @param $idSluzby ID služby
     * @param $cena     cena služby
     * @return bool true pokud byla služba odebrána
     */
    public function odeberSluzbu($nazev, $cena): bool
    {
        $whereStatement = "typ_sluzby='$nazev' AND cena='$cena'";
        $q = "DELETE FROM ".TABLE_SLUZBY." WHERE typ_sluzby=:nazev AND cena=:cena;";

        $vystup = $this->pdo->prepare($q);

        $vystup->bindValue(":nazev", $nazev);
        $vystup->bindValue(":cena", $cena);

        if ($vystup->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Nalezne uživatele s daným emailem a heslem
     *
     * @param $email /Email uživatele v databázi
     * @param $password /Heslo uživatele
     * @return mixed        Vrácení uživatele pokud se povede nebo vrátí NULL
     */
    public function vratUzivatele($email)
    {
        $q = "SELECT * FROM " . TABLE_USER . " WHERE email=:uLogin";
        $vystup = $this->pdo->prepare($q);
        $vystup->bindValue(":uLogin", $email);
        if ($vystup->execute()) {
            return $vystup->fetchAll();
        } else {
            return null;
        }
    }

    /**
     * Nalezne službu s danými atributy
     *
     * @param $email /Email uživatele v databázi
     * @param $password /Heslo uživatele
     * @return mixed        Vrácení uživatele pokud se povede nebo vrátí NULL
     */
    public function vratSluzbu($nazevSluzby, $cena )
    {

        $q = "SELECT * FROM ".TABLE_SLUZBY." WHERE typ_sluzby=:uNazev AND cena=:uCena;";
        $vystup = $this->pdo->prepare($q);
        $vystup->bindValue(":uNazev", $nazevSluzby);
        $vystup->bindValue(":uCena", $cena);
        if ($vystup->execute()) {
            return $vystup->fetchAll();
        } else {
            return null;
        }
    }

    /**
     * Ziskani konkretniho hesla uzivatele dle emailu uzivatele
     *
     * @param string $email       email uživatele
     */
   public function getPasswordByEmail(string $email)
   {

       $q = "SELECT password FROM ".TABLE_USER." WHERE email = :email";
       $vystup = $this->pdo->prepare($q);
       if($vystup->execute(array( ":email" => $email ))){
           return $vystup->fetch();
       } else {
           return null;
       }
   }

    /**
     * Ziskani konkretniho hesla uzivatele dle emailu uzivatele
     *
     * @param int $email       email.
     * @return array        Data nalezeneho prava.
     */
    public function getPassword(string $email, string  $username)
    {

        $q = "SELECT password FROM ".TABLE_USER." WHERE email = :email AND username=:username;";
        $vystup = $this->pdo->prepare($q);
        if($vystup->execute(array( ":email" => $email, ":username" => $username))){
            return $vystup->fetch();
        } else {
            return null;
        }
    }

    /**
     * Registruje nového uživatele
     *
     * @param $email /Email uživatele
     * @param $username /Uživatelské jméno
     * @param $password /Heslo
     * @param string $pravo /právo uživatele
     * @return bool         Povedlo se?
     */
    public function registrujUzivatele($email, $username, $password, $pravo = "3"): bool
    {

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $uzivatel = $this->vratUzivatele($email);

        if (!isset($uzivatel) || count($uzivatel) == 0) {

            $q = "INSERT INTO " . TABLE_USER . " (id_user,email,username,password,PRAVA_id_prava) VALUES (NULL,:email, :login, :heslo, :pravo);";
            $vystup = $this->pdo->prepare($q);
            $vystup->bindValue(":email", $email);
            $vystup->bindValue(":login", $username);
            $vystup->bindValue(":heslo", $hashed_password);
            $vystup->bindValue(":pravo", $pravo);

            if ($vystup->execute()) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * Smazání zaměstnance
     *
     * @param $whereStatement  se má mazat
     *
     * @return bool true pokud smazáno
     */
    public function smazZamestnance($username): bool
    {
        $q = "DELETE FROM ".TABLE_USER. " WHERE username=:username;";

        $vystup = $this->pdo->prepare($q);
        $vystup->bindValue(":username", $username);

        if ($vystup->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Získání dané sluzby podle jejího ID.
     *
     * @param int $id ID sluzby
     * @return array    Pole s sluzeb.
     */
    public function getExactSluzbuById(int $id): ?array
    {
        $sluzba = $this->selectFromTable(TABLE_SLUZBY, "id_sluzba='$id'");
        return $sluzba[0];
    }

    /**
     * Získání jednoho uživatele podle jeho ID
     *
     * @param int $id ID uživatele
     * @return array    Pole s prvním uživatelem.
     */
    public function getExactUserById(int $id): ?array
    {
        $user = $this->selectFromTable(TABLE_USER, "id_user='$id'");
        return $user[0];
    }
    /**
     * Získání objednávky podle jejího ID
     *
     * @param int $id ID objednávky
     * @return array    Pole s danou objednávkou
     */
    public function getExactObjById(int $id): array
    {
        $obj = $this->selectFromTable(TABLE_OBJEDNAVKA, "id_objednavky='$id'");
        return $obj[0];
    }

    /**
     * Vratí konkrétní službu dle ID
     *
     * @param int $id
     * @return array|null
     */
    public function getExactSluzbuById3(int $id): ?array
    {
        $sluzba = $this->selectFromTable(TABLE_SLUZBY, "id_sluzba='$id'");
        return $sluzba[0];
    }
    /**
     * Získání objednávky podle uživatelovo ID
     *
     * @param int $idUser Uživatelovo ID
     * @return array    Pole s danou objednávkou
     */
    public function getExactObjByUserId(int $idUser): array
    {
        $obj = $this->selectFromTable(TABLE_OBJEDNAVKA, "USER_id_user='$idUser'");
        return $obj;
    }
    /**
     * Ziskani zaznamu vsech sluzeb z aplikace.
     *
     * @return array    Pole se vsemi sluzbamimi.
     */
    public function getAllSluzby(): array
    {
        $cena = $this->selectFromTable(TABLE_SLUZBY, "", "id_sluzba");
        return $cena;
    }

    /**
     * Ziskani zaznamu vsech objednávek z aplikace.
     *
     * @return array    Pole se vsemi objednávkami.
     */
    public function getAllObjednavky(): array
    {
        $objednavky = $this->selectFromTable(TABLE_OBJEDNAVKA, "", "datum_vytvoreni");
        return $objednavky;
    }

    /**
     * Úprava konkrétní objednávky
     *
     * @param int $idObjednavky ID objednávky
     * @param $datum_vytvoreni /Datum vypůjčení
     * @param int $USER_id_user /ID uživatele, který je autor objednávky
     * @param int $schvalena /Schávalena? 0 = NE || 1 = ANO
     * @return bool                 Byla upravena?
     */
    public function updateObjednavka(int $idObjednavky, $datum_vytvoreni, int $USER_id_user, int $schvalena): bool
    {
    if($schvalena == 0) {
    $schvalena = 1;

    $updateStatementWithValues = "id_objednavky='$idObjednavky', datum_vytvoreni='$datum_vytvoreni', USER_id_user='$USER_id_user', schvalena='$schvalena'";

    $whereStatement = "id_objednavky=$idObjednavky";

    return $this->updateInTable(TABLE_OBJEDNAVKA, $updateStatementWithValues, $whereStatement);

}
else {
    $schvalena = 0;
    $updateStatementWithValues = "id_objednavky='$idObjednavky', datum_vytvoreni='$datum_vytvoreni', USER_id_user='$USER_id_user', schvalena='$schvalena'";

    $whereStatement = "id_objednavky=$idObjednavky";

    return $this->updateInTable(TABLE_OBJEDNAVKA, $updateStatementWithValues, $whereStatement);
        }
    }
}
?>
